<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use App\Models\AvailabilityDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fishes = Fish::with('availabilityDays')->get();
        return view('fishes.index', compact('fishes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('fish_images', 'public');
            $validated['image'] = $path;
        }

        $fish = Fish::create($validated);

        return redirect()->route('fish.index')->with('success', 'Zivs veiksmīgi pievienota!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fish $fish) // Instead of string $id
    {
        return view('fishes.show', compact('fish'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fish = Fish::findOrFail($id);
        return view('fishes.edit', compact('fish'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fish = Fish::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Dzēst veco bildi
            if ($fish->image) {
                Storage::disk('public')->delete($fish->image);
            }
            
            $path = $request->file('image')->store('fish_images', 'public');
            $validated['image'] = $path;
        }

        $fish->update($validated);

        return redirect()->route('fish.index')->with('success', 'Zivs veiksmīgi atjaunināta!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fish = Fish::findOrFail($id);
        
        // Dzēst bildi
        if ($fish->image) {
            Storage::disk('public')->delete($fish->image);
        }
        
        $fish->delete();

        return redirect()->route('fish.index')->with('success', 'Zivs veiksmīgi dzēsta!');
    }
}