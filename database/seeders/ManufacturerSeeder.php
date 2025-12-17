<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManufacturerSeeder extends Seeder
{
    public function run(): void
    {
        $manufacturers = [

            /*
            |--------------------------------------------------------------------------
            | 🇧🇩 Bangladesh – Halal & Local Manufacturers
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'PRAN-RFL Group',
                'country' => 'Bangladesh',
                'location' => 'Dhaka',
                'phone' => '+8809612345678',
                'email' => 'info@prangroup.com',
                'is_active' => 1,
            ],
            [
                'name' => 'ACI Limited',
                'country' => 'Bangladesh',
                'location' => 'Dhaka',
                'phone' => '+8801712345678',
                'email' => 'info@aci-bd.com',
                'is_active' => 1,
            ],
            [
                'name' => 'Square Group',
                'country' => 'Bangladesh',
                'location' => 'Dhaka',
                'phone' => '+8801812345678',
                'email' => 'info@squaregroup.com',
                'is_active' => 1,
            ],
            [
                'name' => 'Bashundhara Group',
                'country' => 'Bangladesh',
                'location' => 'Dhaka',
                'phone' => '+8801912345678',
                'email' => 'info@bg.com.bd',
                'is_active' => 1,
            ],
            [
                'name' => 'Akij Group',
                'country' => 'Bangladesh',
                'location' => 'Dhaka',
                'phone' => '+8801612345678',
                'email' => 'info@akij.net',
                'is_active' => 1,
            ],
            [
                'name' => 'Fresh (Meghna Group)',
                'country' => 'Bangladesh',
                'location' => 'Narayanganj',
                'phone' => '+8801512345678',
                'email' => 'info@meghnagroup.com',
                'is_active' => 1,
            ],
            [
                'name' => 'Kazi Farms Group',
                'country' => 'Bangladesh',
                'location' => 'Dhaka',
                'phone' => '+8801412345678',
                'email' => 'info@kazifarms.com',
                'is_active' => 1,
            ],
            [
                'name' => 'Ispahani Group',
                'country' => 'Bangladesh',
                'location' => 'Dhaka',
                'phone' => '+8801312345678',
                'email' => 'info@ispahanigroup.com',
                'is_active' => 1,
            ],

            /*
            |--------------------------------------------------------------------------
            | 🇯🇵 Japan Manufacturers
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'Sony Corporation',
                'country' => 'Japan',
                'location' => 'Tokyo',
                'phone' => null,
                'email' => null,
                'is_active' => 1,
            ],
            [
                'name' => 'Panasonic Corporation',
                'country' => 'Japan',
                'location' => 'Osaka',
                'phone' => null,
                'email' => null,
                'is_active' => 1,
            ],
            [
                'name' => 'Toyota Industries',
                'country' => 'Japan',
                'location' => 'Aichi',
                'phone' => null,
                'email' => null,
                'is_active' => 1,
            ],
            [
                'name' => 'Sharp Corporation',
                'country' => 'Japan',
                'location' => 'Osaka',
                'phone' => null,
                'email' => null,
                'is_active' => 1,
            ],

            /*
            |--------------------------------------------------------------------------
            | 🇨🇳 China Manufacturers
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'Huawei Technologies',
                'country' => 'China',
                'location' => 'Shenzhen',
                'phone' => null,
                'email' => null,
                'is_active' => 1,
            ],
            [
                'name' => 'Xiaomi Corporation',
                'country' => 'China',
                'location' => 'Beijing',
                'phone' => null,
                'email' => null,
                'is_active' => 1,
            ],
            [
                'name' => 'Haier Group',
                'country' => 'China',
                'location' => 'Qingdao',
                'phone' => null,
                'email' => null,
                'is_active' => 1,
            ],
            [
                'name' => 'Lenovo Group',
                'country' => 'China',
                'location' => 'Beijing',
                'phone' => null,
                'email' => null,
                'is_active' => 1,
            ],

        ];

        foreach ($manufacturers as $manufacturer) {
            DB::table('manufacturers')->insert([
                ...$manufacturer,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
