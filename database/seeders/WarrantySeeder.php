<?php

namespace Database\Seeders;

use App\Models\Warranty;
use Illuminate\Database\Seeder;

class WarrantySeeder extends Seeder
{
    public function run(): void
    {
        $warranties = [
            [
                'name' => 'No Warranty',
                'duration_type' => 'days',
                'day_count' => 0,
                'description' => 'No warranty applicable.',
            ],
            [
                'name' => '7 Days Replacement',
                'duration_type' => 'days',
                'day_count' => 7,
                'description' => '7 days replacement warranty.',
            ],
            [
                'name' => '1 Month Warranty',
                'duration_type' => 'months',
                'day_count' => 1,
                'description' => '1 month service warranty.',
            ],
            [
                'name' => '1 Year Warranty',
                'duration_type' => 'years',
                'day_count' => 1,
                'description' => '1 year manufacturer warranty.',
            ],
            [
                'name' => '2 Years Warranty',
                'duration_type' => 'years',
                'day_count' => 2,
                'description' => '2 years manufacturer warranty.',
            ],
        ];

        foreach ($warranties as $warranty) {
            Warranty::updateOrCreate(
                ['name' => $warranty['name']],
                array_merge($warranty, ['created_by' => null])
            );
        }
    }
}
