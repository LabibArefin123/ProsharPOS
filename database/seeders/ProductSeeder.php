<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Warranty;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $units      = Unit::all();
        $warranties = Warranty::all();

        if ($categories->isEmpty() || $units->isEmpty() || $warranties->isEmpty()) {
            dd("Please seed Categories, Units & Warranties first.");
        }

        $productCount = 100;

        for ($i = 1; $i <= $productCount; $i++) {

            $category = $categories->random();
            $brand    = Brand::where('category_id', $category->id)->inRandomOrder()->first();

            if (!$brand) continue;

            Product::create([
                'name'              => $brand->name . ' ' . $category->name . ' Item ' . $i,
                'category_id'       => $category->id,
                'brand_id'          => $brand->id,
                'unit_id'           => $units->random()->id,
                'part_number'       => strtoupper(Str::random(8)),
                'type_model'        => 'Model-' . rand(100, 999),
                'origin'            => ['Bangladesh', 'China', 'Japan', 'Malaysia', 'India'][array_rand(['BD', 'CN', 'JP', 'MY', 'IN'])],
                'rack_number'       => rand(1, 30),
                'box_number'        => rand(1, 100),
                'purchase_price'    => rand(200, 15000),
                'handling_charge'   => rand(10, 300),
                'maintenance_charge' => rand(0, 200),
                'sell_price'        => rand(500, 20000),
                'stock_quantity'    => rand(1, 200),
                'alert_quantity'    => rand(1, 10),
                'image'             => null,
                'using_place'       => ['Store Room', 'Front Desk', 'Office', 'Warehouse'][rand(0, 3)],
                'warranty_id'       => $warranties->random()->id,
                'description'       => 'Auto-generated product seed data',
                'status'            => 1,
            ]);
        }
    }
}
