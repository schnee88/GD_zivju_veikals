<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Fish;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    //Admin panelis
    public function index()
    {
        $batches = Batch::with('fishes')
            ->orderBy('batch_date', 'desc')
            ->get();

        return view('admin.batches.index', compact('batches'));
    }

    public function publicIndex()
    {
        $batches = Batch::activeForPublic()
            ->with('fishes')
            ->orderBy('batch_date', 'desc')
            ->get();

        return view('batches.public', compact('batches'));
    }

    public function create()
    {
        $fishes = Fish::orderBy('name')->get();
        return view('admin.batches.create', compact('fishes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'batch_date' => 'required|date_format:d/m/Y H:i',
            'description' => 'nullable|string',
            'fishes' => 'required|array|min:1',
            'fishes.*.fish_id' => 'required|exists:fishes,id',
            'fishes.*.quantity' => 'required|numeric|min:0.1',
            'fishes.*.unit' => 'required|in:kg,pieces'
        ]);

        // Izveidot partiju caur modeli
        $batch = Batch::createWithFishes(
            $validated['name'],
            $validated['batch_date'],
            $validated['fishes'],
            $validated['description'] ?? null
        );

        return redirect()
            ->route('admin.batches.index')
            ->with('success', 'Partija veiksmīgi izveidota!');
    }

    public function updateStatus(Batch $batch, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:available,sold_out,preparing'
        ]);

        $batch->updateStatus($validated['status']);

        return back()->with('success', 'Partijas statuss atjaunināts!');
    }

    public function edit(Batch $batch)
    {
        $fishes = Fish::orderBy('name')->get();
        return view('admin.batches.edit', compact('batch', 'fishes'));
    }

    public function update(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'batch_date' => 'required|date_format:d/m/Y H:i',
            'fishes' => 'nullable|array',
            'fishes.*.fish_id' => 'required|exists:fishes,id',
            'fishes.*.quantity' => 'required|numeric|min:0',
            'fishes.*.unit' => 'required|in:kg,pieces'
        ]);

        try {
            $batch->updateWithFishes(
                $validated['name'],
                $validated['batch_date'],
                $validated['fishes'] ?? [],
                $validated['description'] ?? null
            );

            return redirect()
                ->route('admin.batches.index')
                ->with('success', 'Partija veiksmīgi atjaunināta!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Kļūda atjauninot partiju: ' . $e->getMessage())
                ->withInput(); // saglabā ievadītos datus
        }
    }

    public function destroy(Batch $batch)
    {
        $batch->deleteWithRelations();

        return redirect()
            ->route('admin.batches.index')
            ->with('success', 'Partija veiksmīgi izdzēsta!');
    }
}