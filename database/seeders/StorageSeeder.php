<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Storage;
use App\Models\Product;
use App\Models\Supplier;

class StorageSeeder extends Seeder
{
    public function run(): void
    {
        $products  = Product::all();
        $suppliers = Supplier::pluck('id')->toArray();

        $rackLocations = [
            'Store Room – Left Side',
            'Store Room – Right Side',
            'Main Godown – Front',
            'Main Godown – Back',
            'Shop Floor – Behind Counter',
        ];

        $boxLocations = [
            'Top Shelf',
            'Middle Shelf',
            'Bottom Shelf',
            'Drawer Section',
            'Plastic Box',
        ];

        foreach ($products as $product) {

            $rackNumber = rand(1, 20);
            $boxNumber  = rand(1, 20);

            Storage::firstOrCreate(
                [
                    'product_id' => $product->id,
                ],
                [
                    // Random supplier (fallback safe)
                    'supplier_id'   => !empty($suppliers)
                        ? $suppliers[array_rand($suppliers)]
                        : null,

                    // Rack & Box numbering
                    'rack_number'   => $rackNumber,
                    'box_number'    => $boxNumber,
                    'rack_no'       => 'R-' . str_pad($rackNumber, 2, '0', STR_PAD_LEFT),
                    'box_no'        => 'B-' . str_pad($boxNumber, 2, '0', STR_PAD_LEFT),

                    // Bangladesh-style locations
                    'rack_location' => $rackLocations[array_rand($rackLocations)],
                    'box_location'  => $boxLocations[array_rand($boxLocations)],

                    // Stock (sync from product if exists)
                    'stock_quantity' => $product->stock_quantity ?? rand(1, 200),

                    // Media
                    'image_path'    => null,
                    'barcode_path'  => null,

                    // Status
                    'is_active'     => 0, // Inactive
                ]
            );
        }
    }
}
