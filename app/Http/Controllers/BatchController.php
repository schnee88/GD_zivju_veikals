<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Fish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchController extends Controller
{
     // ADMIN PANELIS
     public function index()
     {
          $batches = Batch::with('fishes')->orderBy('batch_date', 'desc')->get();
          return view('admin.batches.index', compact('batches'));
     }

     public function publicIndex()
     {
          $batches = Batch::whereIn('status', ['available', 'preparing'])
               ->whereHas('fishes', function ($query) {
                    $query->where('available_quantity', '>', 0)
                         ->where('status', 'available');
               })
               ->with([
                    'fishes' => function ($query) {
                         $query->where('available_quantity', '>', 0)
                              ->where('status', 'available');
                    }
               ])
               ->orderBy('batch_date', 'desc')
               ->get();

          // Kārtojam: vispirms gatavojamie, tad gatavie
          $sortedBatches = $batches->sortBy(function ($batch) {
               return $batch->status == 'preparing' ? 1 : 2;
          });

          return view('batches.public', compact('batches'));
     }


     public function create()
     {
          $fishes = Fish::all();
          return view('admin.batches.create', compact('fishes'));
     }

     public function store(Request $request)
     {
          $request->validate([
               'name' => 'required|string|max:255',
               'batch_date' => 'required|date_format:d/m/Y H:i',
               'description' => 'nullable|string',
               'fishes' => 'required|array|min:1',
               'fishes.*.fish_id' => 'required|exists:fishes,id',
               'fishes.*.quantity' => 'required|numeric|min:0.1',
               'fishes.*.unit' => 'required|in:kg,pieces'
          ]);

          $batchDate = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->batch_date);

          $batch = Batch::create([
               'name' => $request->name,
               'batch_date' => $batchDate,
               'description' => $request->description,
               'status' => 'preparing'
          ]);

          foreach ($request->fishes as $fishData) {
               if (!empty($fishData['fish_id']) && !empty($fishData['quantity'])) {
                    $batch->fishes()->attach($fishData['fish_id'], [
                         'quantity' => $fishData['quantity'],
                         'unit' => $fishData['unit'],
                         'available_quantity' => $fishData['quantity']
                    ]);
               }
          }

          return redirect()->route('admin.batches.index')->with('success', 'Žāvējums veiksmīgi izveidots!');
     }

     public function updateStatus(Batch $batch, Request $request)
     {
          $request->validate(['status' => 'required|in:available,sold_out,preparing']);

          $batch->update(['status' => $request->status]);
          return back()->with('success', 'Žāvējuma statuss atjaunināts!');
     }

     public function edit(Batch $batch)
     {
          $fishes = Fish::all();
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
               'fishes.*.available_quantity' => 'required|numeric|min:0',
               'fishes.*.unit' => 'required|in:kg,pieces'
          ]);

          try {
               DB::beginTransaction();

               $batchDate = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $validated['batch_date']);

               $batch->update([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'batch_date' => $batchDate
               ]);

               if (isset($validated['fishes'])) {
                    $batch->fishes()->detach();

                    foreach ($validated['fishes'] as $fishData) {
                         if (!empty($fishData['fish_id']) && !empty($fishData['quantity'])) {
                              $availableQuantity = min($fishData['available_quantity'], $fishData['quantity']);

                              $batch->fishes()->attach($fishData['fish_id'], [
                                   'quantity' => $fishData['quantity'],
                                   'available_quantity' => $availableQuantity,
                                   'unit' => $fishData['unit']
                              ]);
                         }
                    }
               }

               DB::commit();

               return redirect()->route('admin.batches.index')
                    ->with('success', 'Žāvējums veiksmīgi atjaunināts!');
          } catch (\Exception $e) {
               DB::rollBack();

               return back()->with('error', 'Kļūda atjauninot žāvējumu: ' . $e->getMessage())
                    ->withInput();
          }
     }

     public function destroy(Batch $batch)
     {
          $batch->fishes()->detach();
          $batch->delete();
          return redirect()->route('admin.batches.index')->with('success', 'Žāvējums veiksmīgi izdzēsts!');
     }
}
