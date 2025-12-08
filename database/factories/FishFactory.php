<?php

namespace Database\Factories;

use App\Models\Fish;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fish>
 */
class FishFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Fish::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fishNames = [
            'Lasis',
            'Forele',
            'Siļķe',
            'Makrele',
            'Zutis',
            'Plaudis',
            'Karpas',
            'Līdaka',
            'Asaris',
            'Mencas'
        ];

        $descriptions = [
            'Svaigs no Baltijas jūras',
            'Audzēts ekoloģiskās fermās',
            'Nokerts šodien no vietējiem zvejniekiem',
            'Augstākās kvalitātes produkts',
            'Ieteicams cept vai vārīt',
            'Lieliski piemērots ceptai zivij',
            'Bagāts ar omega-3 taukskābēm'
        ];

        return [
            'name' => fake()->randomElement($fishNames),
            'description' => fake()->randomElement($descriptions),
            'price' => fake()->randomFloat(2, 3.99, 29.99),
            'stock_quantity' => fake()->numberBetween(10, 100),
            // 'image_path' => 'fish_images/default.jpg', // Izkomentēts
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the fish is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock_quantity' => 0,
        ]);
    }

    /**
     * Indicate that the fish has low stock.
     */
    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock_quantity' => fake()->numberBetween(1, 5),
        ]);
    }

    /**
     * Indicate that the fish is premium (expensive).
     */
    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => fake()->randomFloat(2, 25.00, 50.00),
        ]);
    }
}