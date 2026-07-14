<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function aboutus()
    {

        return Inertia::render('Frontend/AboutUs/Index');
    }
    public function categoryPage()
    {

        $categories = ProductCategory::where('status', 1)->get();

        return Inertia::render('Frontend/Categories/Index', ['categories' => $categories]);
    }
    public function findProduct($id)
    {
        $category_name = ProductCategory::where('id', $id)->value('name');
        $products = Product::where('product_category_id', $id)
            ->with('media', 'category')
            ->get();

        // dd($products);
        return Inertia::render('Frontend/Categories/ProductList', ['products' => $products, 'category_name' => $category_name]);
    }
}
