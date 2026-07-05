<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductCategory;
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
        $totalIncome = 12480;
        $totalOrders = 10;
        $pendingOrders = 5;
        $cancelledOrders = 2;

        // dd($totalProducts, $activeProducts, $totalCategories, $totalCustomers);
        return Inertia::render('Backend/Dashboard/Index',
            [
                'totalProducts' => $totalProducts,
                'activeProducts' => $activeProducts,
                'totalCategories' => $totalCategories,
                'totalCustomers' => $totalCustomers,
                'totalOrders' => $totalOrders,
                'pendingOrders' => $pendingOrders,
                'cancelledOrders' => $cancelledOrders,
                'totalIncome' => $totalIncome,
            ]
        );
    }
}
