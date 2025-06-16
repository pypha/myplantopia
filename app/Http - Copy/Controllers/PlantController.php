<?php
namespace App\Http\Controllers;
use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index()
    {
        return Plant::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'light' => 'nullable|string',
            'watering' => 'nullable|string',
            'temperature' => 'nullable|string',
            'humidity' => 'nullable|string',
            'planting_guide' => 'nullable|string',
            'locations' => 'nullable|array',
            'image_url' => 'nullable|string',
        ]);

        $plant = Plant::create($validated);
        return response()->json($plant, 201);
    }

    public function show($id)
    {
        return Plant::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $plant = Plant::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'light' => 'nullable|string',
            'watering' => 'nullable|string',
            'temperature' => 'nullable|string',
            'humidity' => 'nullable|string',
            'planting_guide' => 'nullable|string',
            'locations' => 'nullable|array',
            'image_url' => 'nullable|string',
        ]);

        $plant->update($validated);
        return response()->json($plant);
    }

    public function destroy($id)
    {
        Plant::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}