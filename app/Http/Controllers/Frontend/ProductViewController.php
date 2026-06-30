<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductViewController extends Controller
{
    public function index($id)
    {
        $product = Product::with('category', 'media')->findOrFail($id);
        // dd($product);
        return Inertia::render('Frontend/ProductView/Index', ['product' => $product]);
    }
}
