<?php

namespace Database\Seeders;

use App\Models\Batch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batches = [
            [
                'name' => 'Rīta kūpinājums',
                'batch_date' => Carbon::today()->setTime(8, 0),
                'status' => 'available',
                'description' => 'Svaigi nožāvētas zivis',
            ],
            [
                'name' => 'Vakara kūpinājums',
                'batch_date' => Carbon::today()->setTime(18, 0),
                'status' => 'preparing',
                'description' => 'Vakara kūpinājums, gatavs nākamajai dienai',
            ],
            [
                'name' => 'Nedēļas nogales kūpinājums',
                'batch_date' => Carbon::parse('next friday')->setTime(12, 0),
                'status' => 'sold_out',
                'description' => 'Īpašais nedēļas nogales kūpinājums',
            ],
            [
                'name' => 'Jaunais kūpinājums',
                'batch_date' => Carbon::tomorrow()->setTime(10, 0),
                'status' => 'available',
                'description' => 'Svaigi žāvētas zivis ar īpašu recepti',
            ]
        ];

        foreach ($batches as $batch) {
            Batch::create($batch);
        }
    }
}
