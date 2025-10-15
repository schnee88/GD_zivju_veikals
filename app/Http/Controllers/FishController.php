<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FishController extends Controller
{
    public function catalog()
    {
        $fishes = Fish::all();
        return view('fishes.catalog', compact('fishes'));
    }
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

    public function create()
    {
        return view('admin.fish.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
            'is_orderable' => 'boolean',
            'stock_quantity' => 'nullable|integer|min:0',
            'stock_unit' => 'nullable|in:kg,pieces',
        ]);

        $validated['is_orderable'] = $request->has('is_orderable');

        // Ja nav pasūtāms, stock = 0
        if (!$validated['is_orderable']) {
            $validated['stock_quantity'] = 0;
            $validated['stock_unit'] = 'pieces';
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('fish_images', 'public');
            $validated['image'] = basename($path);
        }

        Fish::create($validated);

        return redirect()->route('admin.fish.index')->with('success', 'Zivs veiksmīgi pievienota!');
    }

    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    public function edit(string $id)
    {
        $fish = Fish::findOrFail($id);
        return view('admin.fish.edit', compact('fish'));
    }

    public function update(Request $request, string $id)
    {
        $fish = Fish::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_orderable' => 'nullable|boolean',
            'stock_quantity' => 'nullable|numeric|min:0',
            'stock_unit' => 'nullable|in:kg,pieces',
        ]);

        $validated['is_orderable'] = $request->has('is_orderable') && $request->is_orderable == '1' ? 1 : 0;

        if (!$validated['is_orderable']) {
            $validated['stock_quantity'] = 0;
            $validated['stock_unit'] = 'pieces';
        }

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
