<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 1)->count();
        $totalCategories = ProductCategory::where('status', 1)->count();
        $totalCustomers = Customer::count();
        $totalOrders = Order::count();;
        $pendingOrders = Order::where('status', 'placed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $revenue = Order::where('payment_status', 'paid')->sum('total');

        $labels = [];
        $orders = [];
        $income = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $labels[] = $date->format('D');

            $dayOrders = Order::whereDate('created_at', $date)->where('status', ['placed', 'confirmed', 'processing', 'shipping', 'delivered']);

            $orders[] = $dayOrders->count();

            $income[] = Order::whereDate('created_at', $date)->where('payment_status', 'paid')
                ->sum('total');
        }


        // dd($labels, $orders, $income);
        return Inertia::render(
            'Backend/Dashboard/Index',
            [
                'totalProducts' => $totalProducts,
                'activeProducts' => $activeProducts,
                'totalCategories' => $totalCategories,
                'totalCustomers' => $totalCustomers,
                'totalOrders' => $totalOrders,
                'pendingOrders' => $pendingOrders,
                'cancelledOrders' => $cancelledOrders,
                'revenue' => $revenue,
                'labels' => $labels,
                'orders' => $orders,
                'income' => $income,
            ]
        );
    }
}
