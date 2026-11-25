<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            [
                'name'     => 'Main Warehouse',
                'code'     => 'WH-DHK-001',
                'location' => 'Dhaka, Bangladesh',
                'manager'  => 'Warehouse Manager',
                'status'   => true,
                'created_by' => null,
            ],
            [
                'name'     => 'Secondary Warehouse',
                'code'     => 'WH-DHK-002',
                'location' => 'Dhaka, Bangladesh',
                'manager'  => 'Assistant Warehouse Manager',
                'status'   => true,
                'created_by' => null,
            ],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::updateOrCreate(
                ['code' => $warehouse['code']],
                $warehouse
            );
        }
    }
}
