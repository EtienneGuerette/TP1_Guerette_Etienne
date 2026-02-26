<?php

namespace Database\Seeders;

use App\Models\Rental;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorieSeeder::class,
            EquipmentSeeder::class,
            SportSeeder::class,
            EquipmentSportSeeder::class,
        ]);

        User::factory(10)->create();
        Rental::factory(10)->create();
        Review::factory(10)->create();
    }
}
