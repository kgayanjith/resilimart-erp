<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesController extends Controller
{
    public function index()
    {

        $sales = Order::with(['customer', 'items.product', 'items.product.media'])->get();

        return Inertia::render('Backend/Sales/Index', ['sales' => $sales]);
    }

    public function view($id)
    {
        $sale = Order::with(['customer', 'items.product', 'items.product.media'])->findOrFail($id);
        // dd($sale);
        return Inertia::render('Backend/Sales/View', ['sale' => $sale]);
    }

    public function update(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            $validated = $request->validate([
                'status' => ['required'],
            ]);

            $order->update($validated);

            return back()->with('success', 'Order status updated.');
        } catch (\Exception $e) {
            report($e);

            return back()->with('error', 'Failed to update order status. ' . $e->getMessage());
        }
    }

    // public function updatePayment(Request $request, $id)
    // {
    //     try {
    //         $order = Order::findOrFail($id);

    //         $validated = $request->validate([
    //             'status' => ['required'],
    //         ]);

    //         $order->update($validated);

    //         return back()->with('success', 'Order status updated.');
    //     } catch (\Exception $e) {
    //         report($e);

    //         return back()->with('error', 'Failed to update order status. ' . $e->getMessage());
    //     }
    // }
}
