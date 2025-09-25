<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\BatchFish;
use App\Models\Fish;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BatchFishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
         $batches = Batch::all();
        $fishes = Fish::all();

        $batchFishData = [
            // Batch 1 - Rīta žāvējums
            [
                'batch_id' => 1,
                'fish_id' => 1, // Salmon
                'quantity' => 50.5,
                'unit' => 'kg',
                'available_quantity' => 35.2,
                'status' => 'available'
            ],
            [
                'batch_id' => 1,
                'fish_id' => 2, // Goldfish
                'quantity' => 100,
                'unit' => 'pieces',
                'available_quantity' => 75,
                'status' => 'available'
            ],
            [
                'batch_id' => 1,
                'fish_id' => 3, // Tuna
                'quantity' => 25.0,
                'unit' => 'kg',
                'available_quantity' => 10.5,
                'status' => 'available'
            ],

            // Batch 2 - Vakara partija
            [
                'batch_id' => 2,
                'fish_id' => 4, // Cod
                'quantity' => 40.0,
                'unit' => 'kg',
                'available_quantity' => 40.0,
                'status' => 'available'
            ],
            [
                'batch_id' => 2,
                'fish_id' => 5, // Rainbow Fish
                'quantity' => 60,
                'unit' => 'pieces',
                'available_quantity' => 60,
                'status' => 'reserved'
            ],

            // Batch 3 - Nedēļas nogāzes partija
            [
                'batch_id' => 3,
                'fish_id' => 1, // Salmon
                'quantity' => 30.0,
                'unit' => 'kg',
                'available_quantity' => 0,
                'status' => 'sold'
            ],
            [
                'batch_id' => 3,
                'fish_id' => 3, // Tuna
                'quantity' => 15.0,
                'unit' => 'kg',
                'available_quantity' => 0,
                'status' => 'sold'
            ],

            // Batch 4 - Jaunais žāvējums
            [
                'batch_id' => 4,
                'fish_id' => 2, // Goldfish
                'quantity' => 80,
                'unit' => 'pieces',
                'available_quantity' => 80,
                'status' => 'available'
            ],
            [
                'batch_id' => 4,
                'fish_id' => 6, // Koi
                'quantity' => 25,
                'unit' => 'pieces',
                'available_quantity' => 25,
                'status' => 'available'
            ]
        ];

        foreach ($batchFishData as $data) {
            BatchFish::create($data);
        }
    }
}
