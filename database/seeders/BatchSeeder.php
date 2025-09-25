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
                'name' => 'Rīta žāvējums',
                'batch_date' => Carbon::today()->setTime(8, 0),
                'status' => 'available',
                'description' => 'Svaigi nožāvētas zivis no rīta nozvejas',
            ],
            [
                'name' => 'Vakara partija',
                'batch_date' => Carbon::today()->setTime(18, 0),
                'status' => 'preparing',
                'description' => 'Vakara žāvējums, gatavs nākamajā dienā',
            ],
            [
                'name' => 'Nedēļas nogāzes partija',
                'batch_date' => Carbon::parse('next friday')->setTime(12, 0),
                'status' => 'sold_out',
                'description' => 'Īpašais nedēļas nogāzes žāvējums',
            ],
            [
                'name' => 'Jaunais žāvējums',
                'batch_date' => Carbon::tomorrow()->setTime(10, 0),
                'status' => 'available',
                'description' => 'Svaigi žāvētas zivis ar īpašu garšu',
            ]
        ];

        foreach ($batches as $batch) {
            Batch::create($batch);
        }
    }
}
