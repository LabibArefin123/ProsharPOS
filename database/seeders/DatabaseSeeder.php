<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // PermissionSeeder::class,
            // UserSeeder::class,
            // UnitSeeder::class,
            // WarrantySeeder::class,
            // CategorySeeder::class,
            // BrandSeeder::class,
            ProductSeeder::class,
            // ViewPermissionSeeder::class,
        ]);
    }
}
