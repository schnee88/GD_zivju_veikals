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
                'name' => 'Salmon',
                'price' => 24.99,
                'description' => 'Fresh Atlantic salmon, perfect for grilling or baking.',
                'image' => 'salmon.png'
            ],
            [
                'name' => 'Goldfish',
                'price' => 8.99,
                'description' => 'Beautiful ornamental goldfish for your aquarium.',
                'image' => 'gold_fish.png'
            ],
            [
                'name' => 'Tuna',
                'price' => 32.50,
                'description' => 'Premium bluefin tuna, great for sushi and sashimi.',
                'image' => 'salmon.png'
            ],
            [
                'name' => 'Cod',
                'price' => 18.75,
                'description' => 'White flaky cod, ideal for fish and chips.',
                'image' => 'salmon.png'
            ],
            [
                'name' => 'Rainbow Fish',
                'price' => 22.00,
                'description' => 'Colorful tropical fish for aquariums.',
                'image' => 'gold_fish.png'
            ],
            [
                'name' => 'Koi',
                'price' => 45.00,
                'description' => 'Japanese ornamental pond fish.',
                'image' => 'gold_fish.png'
            ]
        ];

        foreach ($fishes as $fish) {
            Fish::create($fish);
        }
    }
}