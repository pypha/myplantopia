<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with('user', 'products', 'shipping')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_date' => 'required|date',
            'customer_name' => 'required|string|max:255',
            'total' => 'required|numeric',
            'status' => 'required|string|in:Pending,Diproses,Selesai,Dibatalkan',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => $validated['user_id'],
            'order_date' => $validated['order_date'],
            'customer_name' => $validated['customer_name'],
            'total' => $validated['total'],
            'status' => $validated['status'],
        ]);

        $order->products()->sync(
            collect($validated['products'])->mapWithKeys(function ($product) {
                return [$product['id'] => ['quantity' => $product['quantity']]];
            })
        );

        return response()->json($order->load('products'), 201);
    }

    public function show($id)
    {
        return Order::with('user', 'products', 'shipping')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_date' => 'required|date',
            'customer_name' => 'required|string|max:255',
            'total' => 'required|numeric',
            'status' => 'required|string|in:Pending,Diproses,Selesai,Dibatalkan',
            'products' => 'sometimes|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order->update([
            'user_id' => $validated['user_id'],
            'order_date' => $validated['order_date'],
            'customer_name' => $validated['customer_name'],
            'total' => $validated['total'],
            'status' => $validated['status'],
        ]);

        if (isset($validated['products'])) {
            $order->products()->sync(
                collect($validated['products'])->mapWithKeys(function ($product) {
                    return [$product['id'] => ['quantity' => $product['quantity']]];
                })
            );
        }

        return response()->json($order->load('products'));
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}