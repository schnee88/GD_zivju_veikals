<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fish;

class FishSeeder extends Seeder
{
    public function run(): void
    {
        $fishes = [
            [
                'name' => 'Lasis',
                'price' => 13.99,
                'description' => 'Svaigs Atlantijas lasis',
                'image' => 'salmon.png'
            ],
            [
                'name' => 'Zelta zivs',
                'price' => 50,
                'description' => 'Skaista dekoratīva zelta zivs',
                'image' => 'gold_fish.png'
            ],
            [
                'name' => 'Sīļķe',
                'price' => 6.50,
                'description' => 'Augstākās kvalitātes sīļķes, ar slepeno recepti!',
                'image' => 'salmon.png'
            ],
            [
                'name' => 'Menca',
                'price' => 10.75,
                'description' => 'Balta, maiga menca, lieliski piemērota fish & chips pagatavošanai.',
                'image' => 'salmon.png'
            ],
            [
                'name' => 'Skumbrija',
                'price' => 12.00,
                'description' => 'Atlantijas makrele',
                'image' => 'gold_fish.png'
            ],
            [
                'name' => 'Zutis',
                'price' => 45.00,
                'description' => 'Čūskveida zivs, delekatese',
                'image' => 'gold_fish.png'
            ]
        ];

        foreach ($fishes as $fish) {
            Fish::create($fish);
        }
    }
}
