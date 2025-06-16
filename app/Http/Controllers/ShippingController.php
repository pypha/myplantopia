<?php
namespace App\Http\Controllers;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        return Shipping::with('order')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string',
            'method' => 'required|string|in:REGULER,EXPRESS',
            'status' => 'required|string|in:Menunggu,Diproses,Dikirim,Terkirim',
        ]);

        $shipping = Shipping::create($validated);
        return response()->json($shipping, 201);
    }

    public function show($id)
    {
        return Shipping::with('order')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $shipping = Shipping::findOrFail($id);
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string',
            'method' => 'required|string|in:REGULER,EXPRESS',
            'status' => 'required|string|in:Menunggu,Diproses,Dikirim,Terkirim',
        ]);

        $shipping->update($validated);
        return response()->json($shipping);
    }

    public function destroy($id)
    {
        Shipping::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}