<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
       
        // Add your FishSeeder here
        $this->call([
            UserSeeder::class,
            FishSeeder::class,
            BatchSeeder::class,
            BatchFishSeeder::class,
        ]);
    }
}
