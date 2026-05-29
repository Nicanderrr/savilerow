<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{ActivityLog, AdminNotification, Customer, Order, Product, ProductVariant};
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $preset = $request->query('range', '12m');
        $end = $request->filled('end') ? Carbon::parse($request->query('end'))->endOfDay() : now()->endOfDay();
        $start = $request->filled('start')
            ? Carbon::parse($request->query('start'))->startOfDay()
            : match ($preset) {
                '7d' => now()->subDays(6)->startOfDay(),
                '30d' => now()->subDays(29)->startOfDay(),
                '90d' => now()->subDays(89)->startOfDay(),
                default => now()->subMonths(11)->startOfMonth(),
            };

        if ($start->greaterThan($end)) {
            [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
        }

        $useDaily = $start->diffInDays($end) <= 62;

        $orders = Order::with('customer')->latest('placed_at')->limit(8)->get();
        $paidOrders = Order::query()
            ->where('payment_status', 'paid')
            ->whereNotNull('placed_at')
            ->whereBetween('placed_at', [$start, $end])
            ->get(['placed_at', 'total']);

        $grouped = $paidOrders->groupBy(fn (Order $order) => $useDaily
            ? $order->placed_at->format('Y-m-d')
            : $order->placed_at->format('Y-m')
        );

        $period = $useDaily
            ? CarbonPeriod::create($start->copy()->startOfDay(), '1 day', $end->copy()->startOfDay())
            : CarbonPeriod::create($start->copy()->startOfMonth(), '1 month', $end->copy()->startOfMonth());

        $labels = [];
        $revenueValues = [];
        $orderValues = [];

        foreach ($period as $date) {
            $key = $useDaily ? $date->format('Y-m-d') : $date->format('Y-m');
            $bucket = $grouped->get($key, collect());

            $labels[] = $useDaily ? $date->format('M j') : $date->format('M Y');
            $revenueValues[] = round((float) $bucket->sum('total'), 2);
            $orderValues[] = $bucket->count();
        }

        $rangeRevenue = array_sum($revenueValues);
        $rangeOrders = array_sum($orderValues);
        $averageOrderValue = $rangeOrders > 0 ? $rangeRevenue / $rangeOrders : 0;
        $revenue = Order::where('payment_status', 'paid')->sum('total');

        return view('admin.dashboard', [
            'stats' => [
                'revenue' => $revenue,
                'orders' => Order::count(),
                'customers' => Customer::count(),
                'products' => Product::count(),
            ],
            'chart' => [
                'labels' => $labels,
                'revenue' => $revenueValues,
                'orders' => $orderValues,
                'range' => $preset,
                'start' => $start->toDateString(),
                'end' => $end->toDateString(),
                'useDaily' => $useDaily,
                'summary' => [
                    'revenue' => $rangeRevenue,
                    'orders' => $rangeOrders,
                    'averageOrderValue' => $averageOrderValue,
                ],
            ],
            'recentOrders' => $orders,
            'topProducts' => Product::withCount('variants')->with('images')->latest()->limit(5)->get(),
            'lowStock' => ProductVariant::with('product')->whereColumn('stock', '<=', 'low_stock_threshold')->limit(8)->get(),
            'activity' => ActivityLog::with('user')->latest()->limit(8)->get(),
            'notifications' => AdminNotification::latest()->limit(5)->get(),
        ]);
    }
}
