<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
   public function index()
   {

      $banners = Banner::where('status', 1)->with('media')->get();
      $categories = ProductCategory::where('status', 1)->with('media')->get();
      $latestproducts = Product::where('status', 1)->with('media', 'category')->latest()->take(8)->get();
      $featuredproducts = Product::where('status', 1)->with('media', 'category')->latest()->take(4)->get();
      $mostorderedproducts = Product::where('status', 1)->with('media', 'category')->take(4)->inRandomOrder()->get();
      $productsections = ProductCategory::where('status', 1)->with([
         'media',
         'products' => function ($query) {
            return $query->with('media', 'category')->limit(4);
         }
      ])->take(4)->get();
      $firstTwoProducts = $featuredproducts->slice(0, 2)->values();
      $lastTwoProducts = $featuredproducts->slice(2, 2)->values();

     
      // dd($orders);

      return Inertia::render('Frontend/Landing/Index', [
         'banners' => $banners,
         'categories' => $categories,
         'latestproducts' => $latestproducts,
         'featuredproducts' => $featuredproducts,
         'mostorderedproducts' => $mostorderedproducts,
         'productsections' => $productsections,
         'firstTwoProducts' => $firstTwoProducts,
         'lastTwoProducts' => $lastTwoProducts,
      ]);
   }
}
