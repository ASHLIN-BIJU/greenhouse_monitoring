<?php

namespace App\Http\Controllers;

use App\Models\GreenhousePlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlantController extends Controller
{
    public function index()
    {
        return response()->json(GreenhousePlant::where('user_id', Auth::id())->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $plant = GreenhousePlant::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'location' => $validated['location'],
            'description' => $validated['description'],
        ]);

        return response()->json([
            'message' => 'Plant created successfully',
            'plant' => $plant
        ], 201);
    }

    public function show($id)
    {
        $plant = GreenhousePlant::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($plant);
    }

    public function update(Request $request, $id)
    {
        $plant = GreenhousePlant::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $plant->update($validated);

        return response()->json([
            'message' => 'Plant updated successfully',
            'plant' => $plant
        ]);
    }

    public function destroy($id)
    {
        $plant = GreenhousePlant::where('user_id', Auth::id())->findOrFail($id);
        $plant->delete();

        return response()->json(['message' => 'Plant deleted successfully']);
    }
}
