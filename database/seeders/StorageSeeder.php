<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Storage;
use App\Models\Manufacturer;
use Illuminate\Database\Seeder;

class StorageSeeder extends Seeder
{
    public function run(): void
    {
        $storageData = [
            [
                'sku' => 'LAP-DELL-3530-I5',
                'manufacturer' => 'Dell',
                'stock_quantity' => 8,
                'alert_quantity' => 2,
                'minimum_stock_level' => 3,
                'maximum_stock_level' => 15,
                'reorder_quantity' => 5,
                'rack_number' => 1,
                'box_number' => 1,
            ],
            [
                'sku' => 'LAP-DELL-3520-I5',
                'manufacturer' => 'Dell',
                'stock_quantity' => 6,
                'alert_quantity' => 2,
                'minimum_stock_level' => 2,
                'maximum_stock_level' => 12,
                'reorder_quantity' => 4,
                'rack_number' => 1,
                'box_number' => 2,
            ],
            [
                'sku' => 'LAP-DELL-3440-I5',
                'manufacturer' => 'Dell',
                'stock_quantity' => 4,
                'alert_quantity' => 1,
                'minimum_stock_level' => 2,
                'maximum_stock_level' => 10,
                'reorder_quantity' => 3,
                'rack_number' => 1,
                'box_number' => 3,
            ],
            [
                'sku' => 'LAP-HP-15S-I5',
                'manufacturer' => 'HP',
                'stock_quantity' => 7,
                'alert_quantity' => 2,
                'minimum_stock_level' => 3,
                'maximum_stock_level' => 15,
                'reorder_quantity' => 5,
                'rack_number' => 2,
                'box_number' => 1,
            ],
            [
                'sku' => 'LAP-HP-PB450-G10',
                'manufacturer' => 'HP',
                'stock_quantity' => 3,
                'alert_quantity' => 1,
                'minimum_stock_level' => 2,
                'maximum_stock_level' => 8,
                'reorder_quantity' => 3,
                'rack_number' => 2,
                'box_number' => 2,
            ],
            [
                'sku' => 'LAP-HP-250-G10-I3',
                'manufacturer' => 'HP',
                'stock_quantity' => 9,
                'alert_quantity' => 3,
                'minimum_stock_level' => 3,
                'maximum_stock_level' => 18,
                'reorder_quantity' => 6,
                'rack_number' => 2,
                'box_number' => 3,
            ],
            [
                'sku' => 'LAP-LEN-SLIM3-I5',
                'manufacturer' => 'Lenovo',
                'stock_quantity' => 6,
                'alert_quantity' => 2,
                'minimum_stock_level' => 2,
                'maximum_stock_level' => 12,
                'reorder_quantity' => 4,
                'rack_number' => 3,
                'box_number' => 1,
            ],
            [
                'sku' => 'LAP-LEN-E14-G5',
                'manufacturer' => 'Lenovo',
                'stock_quantity' => 4,
                'alert_quantity' => 1,
                'minimum_stock_level' => 2,
                'maximum_stock_level' => 10,
                'reorder_quantity' => 3,
                'rack_number' => 3,
                'box_number' => 2,
            ],
            [
                'sku' => 'LAP-LEN-V15-G4-I3',
                'manufacturer' => 'Lenovo',
                'stock_quantity' => 10,
                'alert_quantity' => 3,
                'minimum_stock_level' => 4,
                'maximum_stock_level' => 20,
                'reorder_quantity' => 6,
                'rack_number' => 3,
                'box_number' => 3,
            ],
            [
                'sku' => 'LAP-ASUS-X1504-I5',
                'manufacturer' => 'ASUS',
                'stock_quantity' => 5,
                'alert_quantity' => 2,
                'minimum_stock_level' => 2,
                'maximum_stock_level' => 12,
                'reorder_quantity' => 4,
                'rack_number' => 4,
                'box_number' => 1,
            ],
            [
                'sku' => 'LAP-ASUS-B1-I5',
                'manufacturer' => 'ASUS',
                'stock_quantity' => 3,
                'alert_quantity' => 1,
                'minimum_stock_level' => 2,
                'maximum_stock_level' => 8,
                'reorder_quantity' => 3,
                'rack_number' => 4,
                'box_number' => 2,
            ],
            [
                'sku' => 'LAP-ACER-A515-I5',
                'manufacturer' => 'Acer',
                'stock_quantity' => 5,
                'alert_quantity' => 2,
                'minimum_stock_level' => 2,
                'maximum_stock_level' => 12,
                'reorder_quantity' => 4,
                'rack_number' => 4,
                'box_number' => 3,
            ],
        ];

        foreach ($storageData as $item) {
            $product = Product::where('sku', $item['sku'])->first();

            if (!$product) {
                $this->command->warn(
                    "Storage skipped: Product SKU {$item['sku']} was not found."
                );

                continue;
            }

            $manufacturer = Manufacturer::where(
                'name',
                $item['manufacturer']
            )->first();

            $rackNumber = $item['rack_number'];
            $boxNumber = $item['box_number'];

            Storage::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'product_id' => $product->id,
                    'manufacturer_id' => $manufacturer?->id,
                    'supplier_id' => null,

                    'rack_number' => $rackNumber,
                    'box_number' => $boxNumber,
                    'rack_no' => 'RACK-' . str_pad($rackNumber, 2, '0', STR_PAD_LEFT),
                    'box_no' => 'BOX-' . str_pad($boxNumber, 2, '0', STR_PAD_LEFT),

                    'rack_location' => 'Main Warehouse - Rack ' . $rackNumber,
                    'box_location' => 'Rack ' . $rackNumber . ' - Box ' . $boxNumber,

                    'stock_quantity' => $item['stock_quantity'],
                    'alert_quantity' => $item['alert_quantity'],
                    'minimum_stock_level' => $item['minimum_stock_level'],
                    'maximum_stock_level' => $item['maximum_stock_level'],
                    'reorder_quantity' => $item['reorder_quantity'],

                    'image_path' => $product->image,
                    'is_active' => true,
                    'is_damaged' => false,
                    'is_expired' => false,
                ]
            );
        }

        $this->command->info('Laptop storage records seeded successfully.');
    }
}
