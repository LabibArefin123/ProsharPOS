<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $units = [
            // Weight units
            ['name' => 'Gram', 'short_name' => 'gm'],
            ['name' => 'Milligram', 'short_name' => 'mg'],
            ['name' => 'Pound', 'short_name' => 'lb'],
            ['name' => 'Ton', 'short_name' => 'ton'],

            // Liquid units
            ['name' => 'Litre', 'short_name' => 'ltr'],
            ['name' => 'Millilitre', 'short_name' => 'ml'],
            ['name' => 'Gallon', 'short_name' => 'gal'],
            ['name' => 'Bottle', 'short_name' => 'btl'],

            // Count units
            ['name' => 'Piece', 'short_name' => 'pcs'],
            ['name' => 'Dozen', 'short_name' => 'dz'],
            ['name' => 'Pack', 'short_name' => 'pk'],
            ['name' => 'Packet', 'short_name' => 'pkt'],
            ['name' => 'Tray', 'short_name' => 'tray'],
            ['name' => 'Roll', 'short_name' => 'roll'],
            ['name' => 'Set', 'short_name' => 'set'],
            ['name' => 'Carton', 'short_name' => 'ctn'],
            ['name' => 'Box', 'short_name' => 'box'],
            ['name' => 'Bundle', 'short_name' => 'bdl'],
            ['name' => 'Can', 'short_name' => 'can'],

            // Length units
            ['name' => 'Meter', 'short_name' => 'm'],
            ['name' => 'Centimeter', 'short_name' => 'cm'],
            ['name' => 'Millimeter', 'short_name' => 'mm'],
            ['name' => 'Inch', 'short_name' => 'inch'],
            ['name' => 'Foot', 'short_name' => 'ft'],
            ['name' => 'Yard', 'short_name' => 'yd'],

            // Cooking units
            ['name' => 'Teaspoon', 'short_name' => 'tsp'],
            ['name' => 'Tablespoon', 'short_name' => 'tbsp'],
            ['name' => 'Cup', 'short_name' => 'cup'],
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(
                ['name' => $unit['name']],
                ['short_name' => $unit['short_name'], 'created_by' => 1]
            );
        }
    }
}
