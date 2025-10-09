<?php

namespace Database\Seeders;

use App\Models\Fish;
use Illuminate\Database\Seeder;

class FishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fishes = [
            [
                'name' => 'Sīļķu fileja marinādē bez ādas (1kg spainītis)',
                'price' => 12.00,
                'description' => 'Augstākās kvalitātes sīļķu fileja marinādē bez ādas. Ideāli piemērota salātiem un uzkodām.',
                'image' => 'gold_fish.png',
                'is_orderable' => true,
                'stock_quantity' => 6,
                'stock_unit' => 'pieces',
            ],
            [
                'name' => 'Sīļķu fileja marinādē ar ādu (1kg spainītis)',
                'price' => 10.50,
                'description' => 'Tradicionāla sīļķu fileja marinādē ar ādu. Saglabājuši autentisko garšu un tekstūru.',
                'image' => 'salmon.png',
                'is_orderable' => true,
                'stock_quantity' => 10,
                'stock_unit' => 'pieces',
            ],
            [
                'name' => 'Sīļķu fileja marinādē ar ādu eļļā (1kg spainītis)',
                'price' => 11.80,
                'description' => 'Ella firmas recepte - īpaši garšīga sīļķu fileja ar ādu un unikālu marinādi.',
                'image' => 'salmon.png',
                'is_orderable' => true,
                'stock_quantity' => 9,
                'stock_unit' => 'pieces',
            ],
            [
                'name' => 'Kūpināts lasis',
                'price' => 13.80,
                'description' => 'Karsti kūpināts lasis',
                'image' => 'salmon.png',
                'is_orderable' => false,
                'stock_quantity' => 1,
                'stock_unit' => 'kg',
            ],
        ];

        foreach ($fishes as $fishData) {
            Fish::create($fishData);
        }
    }
}