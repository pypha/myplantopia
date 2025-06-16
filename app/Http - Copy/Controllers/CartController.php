<?php
namespace App\Http\Controllers;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{  
    public function index()
    {
        return Cart::with('product')->where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $validated['product_id']],
            ['quantity' => $validated['quantity']]
        );

        return response()->json($cart->load('product'), 201);
    }

    public function show($id)
    {
        $cart = Cart::with('product')->findOrFail($id);
        if ($cart->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return $cart;
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        if ($cart->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->update($validated);
        return response()->json($cart->load('product'));
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        if ($cart->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $cart->delete();
        return response()->json(null, 204);
    }
}