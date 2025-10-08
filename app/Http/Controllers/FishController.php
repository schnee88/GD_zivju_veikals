<?php

namespace App\Http\Controllers;

use App\Models\Fish;
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

    public function adminIndex()
    {
        $fishes = Fish::with('availabilityDays')->get();
        return view('admin.fish.index', compact('fishes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fish.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
            'is_orderable' => 'boolean' // ← pievienojam validāciju
        ]);

        // Pārveidojam checkbox vērtību
        $validated['is_orderable'] = $request->has('is_orderable');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('fish_images', 'public');
            $validated['image'] = basename($path);
        }

        $fish = Fish::create($validated);

        return redirect()->route('admin.fish.index')->with('success', 'Zivs veiksmīgi pievienota!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fish = Fish::findOrFail($id);
        return view('admin.fish.edit', compact('fish'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fish = Fish::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_orderable' => 'boolean' // ← pievienojam validāciju
        ]);

        // Pārveidojam checkbox vērtību
        $validated['is_orderable'] = $request->has('is_orderable');

        if ($request->hasFile('image')) {
            if ($fish->image) {
                Storage::disk('public')->delete('fish_images/' . $fish->image);
            }

            $path = $request->file('image')->store('fish_images', 'public');
            $validated['image'] = basename($path);
        }

        $fish->update($validated);

        return redirect()->route('admin.fish.index')->with('success', 'Zivs veiksmīgi atjaunināta!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fish = Fish::findOrFail($id);

        // Dzēst bildi
        if ($fish->image) {
            Storage::disk('public')->delete('fish_images/' . $fish->image);
        }

        $fish->delete();

        return redirect()->route('admin.fish.index')->with('success', 'Zivs veiksmīgi dzēsta!');
    }

    // Jaunas metodes pasūtāmajām zivīm
    public function orderable()
    {
        $fishes = Fish::orderable()->with('availabilityDays')->get();
        return view('fishes.orderable', compact('fishes'));
    }

    public function notOrderable()
    {
        $fishes = Fish::notOrderable()->with('availabilityDays')->get();
        return view('fishes.catalog', compact('fishes'));
    }
}
