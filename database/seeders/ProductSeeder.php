<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Warranty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::where('name', 'Computer & Laptop')->first();

        if (!$category) {
            throw new RuntimeException(
                'Computer & Laptop category is missing. Run CategorySeeder first.'
            );
        }

        $unit = Unit::query()->first();

        if (!$unit) {
            throw new RuntimeException(
                'No unit found. Run UnitSeeder before ProductSeeder.'
            );
        }

        $warranty = Warranty::where('name', '1 Year Warranty')->first();

        if (!$warranty) {
            throw new RuntimeException(
                '1 Year Warranty not found. Run WarrantySeeder first.'
            );
        }

        $products = [
            [
                'brand' => 'Dell (Computer)',
                'name' => 'Dell Inspiron 15 3530 Core i5',
                'sku' => 'LAP-DELL-3530-I5',
                'model' => 'Inspiron 15 3530',
                'part_number' => 'DELL-3530-I5',
                'purchase' => 68000,
                'sell' => 73500,
                'stock' => 8,
            ],
            [
                'brand' => 'Dell (Computer)',
                'name' => 'Dell Vostro 3520 Core i5',
                'sku' => 'LAP-DELL-3520-I5',
                'model' => 'Vostro 3520',
                'part_number' => 'DELL-3520-I5',
                'purchase' => 62000,
                'sell' => 67500,
                'stock' => 6,
            ],
            [
                'brand' => 'Dell (Computer)',
                'name' => 'Dell Latitude 3440 Core i5',
                'sku' => 'LAP-DELL-3440-I5',
                'model' => 'Latitude 3440',
                'part_number' => 'DELL-3440-I5',
                'purchase' => 79000,
                'sell' => 84900,
                'stock' => 4,
            ],
            [
                'brand' => 'HP (Computer)',
                'name' => 'HP 15s-fq5000 Core i5',
                'sku' => 'LAP-HP-15S-I5',
                'model' => '15s-fq5000',
                'part_number' => 'HP-15S-I5',
                'purchase' => 65000,
                'sell' => 70900,
                'stock' => 7,
            ],
            [
                'brand' => 'HP (Computer)',
                'name' => 'HP ProBook 450 G10 Core i5',
                'sku' => 'LAP-HP-PB450-G10',
                'model' => 'ProBook 450 G10',
                'part_number' => 'HP-PB450-G10',
                'purchase' => 92000,
                'sell' => 98500,
                'stock' => 3,
            ],
            [
                'brand' => 'HP (Computer)',
                'name' => 'HP 250 G10 Core i3',
                'sku' => 'LAP-HP-250-G10-I3',
                'model' => '250 G10',
                'part_number' => 'HP-250-G10-I3',
                'purchase' => 49000,
                'sell' => 53500,
                'stock' => 9,
            ],
            [
                'brand' => 'Lenovo (Computer)',
                'name' => 'Lenovo IdeaPad Slim 3 Core i5',
                'sku' => 'LAP-LEN-SLIM3-I5',
                'model' => 'IdeaPad Slim 3',
                'part_number' => 'LEN-SLIM3-I5',
                'purchase' => 64000,
                'sell' => 69900,
                'stock' => 6,
            ],
            [
                'brand' => 'Lenovo (Computer)',
                'name' => 'Lenovo ThinkPad E14 Gen 5',
                'sku' => 'LAP-LEN-E14-G5',
                'model' => 'ThinkPad E14 Gen 5',
                'part_number' => 'LEN-E14-G5',
                'purchase' => 89000,
                'sell' => 95900,
                'stock' => 4,
            ],
            [
                'brand' => 'Lenovo (Computer)',
                'name' => 'Lenovo V15 G4 Core i3',
                'sku' => 'LAP-LEN-V15-G4-I3',
                'model' => 'V15 G4',
                'part_number' => 'LEN-V15-G4-I3',
                'purchase' => 47000,
                'sell' => 51500,
                'stock' => 10,
            ],
            [
                'brand' => 'Asus (Computer)',
                'name' => 'Asus VivoBook 15 X1504 Core i5',
                'sku' => 'LAP-ASUS-X1504-I5',
                'model' => 'VivoBook 15 X1504',
                'part_number' => 'ASUS-X1504-I5',
                'purchase' => 67000,
                'sell' => 72900,
                'stock' => 5,
            ],
            [
                'brand' => 'Asus (Computer)',
                'name' => 'Asus ExpertBook B1 Core i5',
                'sku' => 'LAP-ASUS-B1-I5',
                'model' => 'ExpertBook B1',
                'part_number' => 'ASUS-B1-I5',
                'purchase' => 72000,
                'sell' => 78500,
                'stock' => 3,
            ],
            [
                'brand' => 'Acer (Computer)',
                'name' => 'Acer Aspire 5 A515 Core i5',
                'sku' => 'LAP-ACER-A515-I5',
                'model' => 'Aspire 5 A515',
                'part_number' => 'ACER-A515-I5',
                'purchase' => 63000,
                'sell' => 68900,
                'stock' => 5,
            ],
        ];

        DB::transaction(function () use ($products, $category, $unit, $warranty) {
            foreach ($products as $item) {
                $brand = Brand::where('name', $item['brand'])
                    ->where('category_id', $category->id)
                    ->first();

                if (!$brand) {
                    throw new RuntimeException(
                        "Brand {$item['brand']} not found. Run BrandSeeder first."
                    );
                }

                $purchase = $item['purchase'];
                $sell = $item['sell'];

                $product = Product::withTrashed()
                    ->firstOrNew(['sku' => $item['sku']]);

                $product->forceFill([
                    'name' => $item['name'],
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'unit_id' => $unit->id,
                    'part_number' => $item['part_number'],
                    'type_model' => $item['model'],
                    'origin' => 'Imported',
                    'purchase_price' => $purchase,
                    'handling_charge' => 0,
                    'maintenance_charge' => 0,
                    'sell_price' => $sell,
                    'using_place' => 'Office / Personal',
                    'profit_amount' => $sell - $purchase,
                    'description' => $item['name'] . ' laptop product.',
                    'status' => true,
                    'warranty_id' => $warranty->id,
                ]);

                // Restore previously soft-deleted seeded products.
                if ($product->exists && $product->trashed()) {
                    $product->restore();
                }

                $product->save();
            }
        });

        $this->command->info('Laptop products seeded successfully.');
    }
}
