<?php

namespace App\Services\Payments;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PaystackService
{
    public function initialize(array $payload): array
    {
        $response = $this->client()->post($this->url('/transaction/initialize'), $payload);

        if (! $response->successful() || ! $response->json('status')) {
            throw new RuntimeException($response->json('message') ?: 'Unable to initialize Paystack transaction.');
        }

        return $response->json('data');
    }

    public function verify(string $reference): array
    {
        $response = $this->client()->get($this->url('/transaction/verify/'.$reference));

        if (! $response->successful() || ! $response->json('status')) {
            throw new RuntimeException($response->json('message') ?: 'Unable to verify Paystack transaction.');
        }

        return $response->json('data');
    }

    private function client(): PendingRequest
    {
        $secret = config('services.paystack.secret_key');

        if (! $secret) {
            throw new RuntimeException('Paystack secret key is not configured.');
        }

        return Http::acceptJson()
            ->asJson()
            ->withToken($secret)
            ->timeout(20);
    }

    private function url(string $path): string
    {
        return rtrim((string) config('services.paystack.payment_url'), '/').$path;
    }
}
