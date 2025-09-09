<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FishSeeder extends Seeder
{
    public function run()
    {
        // Izslēdzam ārzemju atslēgu pārbaudi
        DB::statement("PRAGMA foreign_keys = OFF");

        $fishes = [
            [
                'name' => 'Lasis',
                'price' => 12.50,
                'description' => 'Svaigs Norvēģijas lasis',
                'image' => 'lasis.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Reņģe',
                'price' => 8.00,
                'description' => 'Baltijas jūras reņģes',
                'image' => 'renge.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Karpis',
                'price' => 7.50,
                'description' => 'Vietējais karpis',
                'image' => 'karpis.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($fishes as $fishData) {
            $fishId = DB::table('fishes')->insertGetId($fishData);
            
            // Pievieno pieejamības dienas
            for ($i = 1; $i <= 7; $i++) {
                DB::table('availability_days')->insert([
                    'fish_id' => $fishId,
                    'date' => Carbon::now()->addDays($i),
                    'quantity_available' => rand(5, 20),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        // Atkal ieslēdzam ārzemju atslēgu pārbaudi
        DB::statement("PRAGMA foreign_keys = ON");
    }
}