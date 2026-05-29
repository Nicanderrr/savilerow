<?php

namespace App\Http\Controllers;

use App\Models\{AdminNotification, Customer, Order, Payment};
use App\Services\Analytics\GeoResolver;
use App\Services\Payments\PaystackService;
use App\Support\Catalog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;

class CheckoutController extends Controller
{
    public function initializePaystack(Request $request, PaystackService $paystack): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:60'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'postal_code' => ['required', 'string', 'max:40'],
            'market' => ['nullable', 'string', 'max:80'],
            'note' => ['nullable', 'string', 'max:1000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.slug' => ['required', 'string', 'max:160'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:99'],
            'items.*.size' => ['nullable', 'string', 'max:60'],
            'items.*.color' => ['nullable', 'string', 'max:80'],
            'items.*.fulfillment' => ['nullable', 'string', 'max:80'],
        ]);

        try {
            [$order, $payment] = DB::transaction(fn () => $this->createOrderAndPayment($validated, $request));

            $data = $paystack->initialize([
                'email' => $validated['email'],
                'amount' => (int) round($payment->amount * 100),
                'currency' => $payment->currency,
                'reference' => $payment->reference,
                'callback_url' => route('checkout.paystack.callback'),
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $validated['name'],
                    'custom_fields' => [
                        [
                            'display_name' => 'Order Number',
                            'variable_name' => 'order_number',
                            'value' => $order->order_number,
                        ],
                    ],
                ],
            ]);

            $payment->update([
                'authorization_url' => $data['authorization_url'] ?? null,
                'access_code' => $data['access_code'] ?? null,
                'payload' => $data,
            ]);

            return response()->json([
                'authorization_url' => $payment->authorization_url,
                'reference' => $payment->reference,
            ]);
        } catch (RuntimeException $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }
    }

    public function paystackCallback(Request $request, PaystackService $paystack): View
    {
        $reference = (string) $request->query('reference');
        $payment = Payment::where('reference', $reference)->with('order')->first();

        if (! $reference || ! $payment) {
            return view('storefront.payment-status', [
                'status' => 'failed',
                'title' => 'Payment not found',
                'message' => 'We could not find the payment reference returned by Paystack.',
                'order' => null,
            ]);
        }

        try {
            $data = $paystack->verify($reference);
            $paid = ($data['status'] ?? null) === 'success';

            $payment->update([
                'status' => $paid ? 'paid' : ($data['status'] ?? 'failed'),
                'gateway_response' => $data['gateway_response'] ?? null,
                'payload' => $data,
                'paid_at' => $paid ? now() : null,
            ]);

            $payment->order->update([
                'payment_status' => $paid ? 'paid' : 'failed',
                'status' => $paid ? 'processing' : 'pending',
                'placed_at' => $paid ? now() : $payment->order->placed_at,
            ]);

            if ($paid && $payment->wasChanged('status')) {
                AdminNotification::create([
                    'type' => 'payment',
                    'title' => 'New Paystack payment received',
                    'message' => $payment->order->order_number.' was paid successfully for '.$payment->order->currency.' '.number_format((float) $payment->order->total, 2).'.',
                    'url' => route('admin.orders.show', $payment->order),
                ]);
            }

            return view('storefront.payment-status', [
                'status' => $paid ? 'success' : 'failed',
                'title' => $paid ? 'Payment received' : 'Payment not completed',
                'message' => $paid ? 'Your order has been received and is being reviewed by client services.' : 'Paystack did not mark this transaction as successful.',
                'order' => $payment->order,
            ]);
        } catch (RuntimeException $exception) {
            return view('storefront.payment-status', [
                'status' => 'failed',
                'title' => 'Verification failed',
                'message' => $exception->getMessage(),
                'order' => $payment->order,
            ]);
        }
    }

    private function createOrderAndPayment(array $validated, Request $request): array
    {
        $geo = app(GeoResolver::class)->fromRequest($request);
        $nameParts = collect(explode(' ', trim($validated['name'])))->filter()->values();
        $firstName = $nameParts->first() ?: 'Client';
        $lastName = $nameParts->slice(1)->implode(' ') ?: 'Guest';

        $customer = Customer::firstOrCreate(
            ['email' => $validated['email']],
            ['first_name' => $firstName, 'last_name' => $lastName, 'phone' => $validated['phone'] ?? null]
        );

        $lines = collect($validated['items'])->map(function (array $item) {
            $product = Catalog::find($item['slug']);

            if (! $product) {
                throw new RuntimeException('One or more cart items are no longer available.');
            }

            $quantity = (int) $item['quantity'];

            return [
                'product' => $product,
                'quantity' => $quantity,
                'total' => $product['price'] * $quantity,
            ];
        });

        $subtotal = $lines->sum('total');
        $shipping = $subtotal > 500 ? 0 : 25;
        $currency = config('services.paystack.currency', 'USD');

        $order = Order::create([
            'customer_id' => $customer->id,
            'order_number' => 'SR-'.now()->format('ymd').'-'.Str::upper(Str::random(6)),
            'status' => 'pending',
            'payment_status' => 'pending',
            'fulfillment_status' => 'unfulfilled',
            'currency' => $currency,
            'subtotal' => $subtotal,
            'discount_total' => 0,
            'tax_total' => 0,
            'shipping_total' => $shipping,
            'total' => $subtotal + $shipping,
            'shipping_method' => $validated['market'] ?? 'Standard',
            'ip_address' => $geo['ip_address'],
            'country_code' => $geo['country_code'],
            'country' => $geo['country'],
            'region' => $geo['region'],
            'city' => $geo['city'],
            'latitude' => $geo['latitude'],
            'longitude' => $geo['longitude'],
        ]);

        foreach ($lines as $line) {
            $product = $line['product'];

            $order->items()->create([
                'product_name' => $product['name'],
                'sku' => Str::upper($product['slug']),
                'quantity' => $line['quantity'],
                'unit_price' => $product['price'],
                'total' => $line['total'],
            ]);
        }

        $payment = $order->payments()->create([
            'provider' => 'paystack',
            'reference' => 'SRPAY-'.Str::upper(Str::random(18)),
            'status' => 'pending',
            'currency' => $currency,
            'amount' => $order->total,
        ]);

        return [$order, $payment];
    }
}
