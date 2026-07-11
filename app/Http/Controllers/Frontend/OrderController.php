<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validated = $request->validate([
            'payment' => 'required|in:cod,card,bank_transfer',
            'cartItems' => 'required|array|min:1',
            'cartItems.*.id' => 'required|exists:products,id',
            'cartItems.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            $products = Product::whereIn('id', collect($validated['cartItems'])->pluck('id'))
                ->get()
                ->keyBy('id');

            $order = DB::transaction(function () use ($validated, $products, $customer) {
                $subtotal = 0;
                $orderItemsData = [];

                foreach ($validated['cartItems'] as $item) {
                    $product = $products->get($item['id']);

                    if (!$product) {
                        throw new \Exception("One of the items in your cart is no longer available.");
                    }

                    $lineTotal = $product->price * $item['quantity'];
                    $subtotal += $lineTotal;

                    $orderItemsData[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'unit_price' => $product->price,
                        'quantity' => $item['quantity'],
                        'line_total' => $lineTotal,
                    ];
                }

                $vatAmount = round($subtotal * 0.18, 2);
                $total = $subtotal + $vatAmount;

                $order = Order::create([
                    'customer_id' => $customer->id,
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'payment_method' => $validated['payment'],
                    'payment_status' => 'pending',
                    'status' => 'placed',
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'address' => $customer->address,
                    'subtotal' => $subtotal,
                    'vat_amount' => $vatAmount,
                    'total' => $total,
                ]);

                $order->items()->createMany($orderItemsData);

                return $order;
            });

            return back()->with('success', true);
        } catch (\Exception $e) {
            report($e);

            $message = $e->getMessage() === "One of the items in your cart is no longer available."
                ? $e->getMessage()
                : 'Something went wrong while placing your order. Please try again.';

            return back()->with([
                'success' => false,
                'error' => $message,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
         $customer = Auth::guard('customer')->user();

        $orders = Order::with(['customer', 'items.product', 'items.product.media'])
            ->where('customer_id', $customer->id)
            ->latest()
            ->orderBy('created_at', 'desc')->get();

        return Inertia::render('Frontend/Orders/Index', ['orders' => $orders]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function trackOrder($id)
    {
      $customer = Auth::guard('customer')->user();

        $order = Order::with(['customer', 'items.product', 'items.product.media'])
            ->where('customer_id', $customer->id)
            ->findOrFail($id);

        return Inertia::render('Frontend/Orders/TrackOrder', ['order' => $order]);
    }


    public function cancelOrder($id){
        // dd($id);

        $customer = Auth::guard('customer')->user();

        $order = Order::where('customer_id', $customer->id)->findOrFail($id);

        if ($order->status !== 'placed') {
            return back()->with('error', 'This order can no longer be cancelled.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
