<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warranty;

class WarrantySeeder extends Seeder
{
    public function run(): void
    {
        $createdBy = 1; // Admin user ID

        $warranties = [

            [
                'name' => 'No Warranty',
                'duration_type' => 'days',
                'day_count' => 0,
                'description' => 'This product has no warranty.',
            ],
            [
                'name' => '7 Days Replacement',
                'duration_type' => 'days',
                'day_count' => 7,
                'description' => '7-day replacement warranty.',
            ],
            [
                'name' => '14 Days Replacement',
                'duration_type' => 'days',
                'day_count' => 14,
                'description' => '14-day replacement warranty.',
            ],
            [
                'name' => '6 Months Service Warranty',
                'duration_type' => 'months',
                'day_count' => 180, // 6 months = 180 days
                'description' => '6 months service warranty.',
            ],
            [
                'name' => '1 Year Warranty',
                'duration_type' => 'years',
                'day_count' => 365,
                'description' => 'One year service warranty.',
            ],
            [
                'name' => '2 Years Warranty',
                'duration_type' => 'years',
                'day_count' => 730, // 365 * 2
                'description' => 'Two years warranty.',
            ],
            [
                'name' => '3 Years Warranty',
                'duration_type' => 'years',
                'day_count' => 1095, // 365 * 3
                'description' => 'Three years warranty.',
            ],
        ];

        foreach ($warranties as $warranty) {
            Warranty::create(array_merge($warranty, [
                'created_by' => $createdBy,
            ]));
        }
    }
}
