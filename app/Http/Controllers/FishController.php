<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use App\Http\Requests\StoreFishRequest;
use App\Http\Requests\UpdateFishRequest;
use Illuminate\Support\Facades\Storage;

class FishController extends Controller
{
    // PUBLIC VIEWS

    public function catalog()
    {
        $fishes = Fish::all();
        return view('fishes.catalog', compact('fishes'));
    }

    /**
     * Show shop page (orderable fish in stock)
     */
    public function orderable()
    {
        $fishes = Fish::orderable()->inStock()->get();
        return view('fishes.orderable', compact('fishes'));
    }

    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    // ADMIN MANAGEMENT

    public function adminIndex()
    {
        $fishes = Fish::with('availabilityDays')->get();
        return view('admin.fish.index', compact('fishes'));
    }

    public function create()
    {
        return view('admin.fish.create');
    }

    public function store(StoreFishRequest $request)
    {
        $validated = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        Fish::create($validated);

        return redirect()
            ->route('admin.fish.index')
            ->with('success', 'Zivs veiksmīgi pievienota!');
    }

    public function edit(string $id)
    {
        $fish = Fish::findOrFail($id);
        return view('admin.fish.edit', compact('fish'));
    }

    public function update(UpdateFishRequest $request, string $id)
    {
        $fish = Fish::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($fish->image) {
                $this->deleteImage($fish->image);
            }
            
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        $fish->update($validated);

        return redirect()
            ->route('admin.fish.index')
            ->with('success', 'Zivs veiksmīgi atjaunināta!');
    }

    public function destroy(string $id)
    {
        $fish = Fish::findOrFail($id);

        if ($fish->image) {
            $this->deleteImage($fish->image);
        }

        $fish->delete();

        return redirect()
            ->route('admin.fish.index')
            ->with('success', 'Zivs veiksmīgi dzēsta!');
    }

    // PRIVATE HELPERS

    private function uploadImage($file): string
    {
        $path = $file->store('fish_images', 'public');
        return basename($path);
    }

    private function deleteImage(string $imageName): void
    {
        Storage::disk('public')->delete('fish_images/' . $imageName);
    }
}