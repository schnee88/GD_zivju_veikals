<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use App\Http\Requests\StoreFishRequest;
use App\Http\Requests\UpdateFishRequest;
use Illuminate\Support\Facades\Storage;

class FishController extends Controller
{
    public function index()
    {
        $fishes = Fish::all();
        return view('fishes.catalog', compact('fishes'));
    }

    public function catalog()
    {
        $fishes = Fish::all();
        return view('fishes.catalog', compact('fishes'));
    }

    /**
     * Parādīt veikala lapu (nopērkamēs zivis veikalā)
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

    // ADMIN PĀRVALDE

    public function adminIndex()
    {
        $fishes = Fish::all();
        return view('admin.fish.index', compact('fishes'));
    }

    public function create()
    {
        return view('admin.fish.create');
    }

    public function store(StoreFishRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        $fish = Fish::create($validated);

        return redirect()->route('admin.fish.index')->with('success', 'Zivs veiksmīgi pievienota!');
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
        //dzēš veco attēlu, pirms augšuplādē jauno att
        if ($request->hasFile('image')) {
            if ($fish->image) {
                $this->deleteImage($fish->image);
            }

            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        $fish->update($validated);

        return redirect()->route('admin.fish.index')->with('success', 'Zivs veiksmīgi atjaunināta!');
    }

    public function destroy(string $id)
    {
        $fish = Fish::findOrFail($id);

        if ($fish->image) {
            $this->deleteImage($fish->image);
        }

        $fish->delete();

        return redirect()->route('admin.fish.index')->with('success', 'Zivs veiksmīgi dzēsta!');
    }

    private function uploadImage($file): string
    {
        $path = $file->store('fish_images', 'public');
        //saglabā tikai faila nosaukumu
        return basename($path);
    }

    private function deleteImage(string $imageName): void
    {
        Storage::disk('public')->delete('fish_images/' . $imageName);
    }
}