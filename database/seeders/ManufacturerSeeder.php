<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use Illuminate\Database\Seeder;

class ManufacturerSeeder extends Seeder
{
    public function run(): void
    {
        $manufacturers = [
            [
                'name'      => 'Dell',
                'country'   => 'United States',
                'location'  => 'Round Rock, Texas',
                'is_active' => true,
            ],
            [
                'name'      => 'HP',
                'country'   => 'United States',
                'location'  => 'Palo Alto, California',
                'is_active' => true,
            ],
            [
                'name'      => 'Lenovo',
                'country'   => 'China',
                'location'  => 'Beijing',
                'is_active' => true,
            ],
            [
                'name'      => 'ASUS',
                'country'   => 'Taiwan',
                'location'  => 'Taipei',
                'is_active' => true,
            ],
            [
                'name'      => 'Acer',
                'country'   => 'Taiwan',
                'location'  => 'New Taipei City',
                'is_active' => true,
            ],
        ];

        foreach ($manufacturers as $manufacturer) {
            Manufacturer::updateOrCreate(
                ['name' => $manufacturer['name']],
                $manufacturer
            );
        }
    }
}
