<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockMovement;
use App\Models\Storage;
use Illuminate\Support\Facades\DB;

class StockMovementSeeder extends Seeder
{
    public function run(): void
    {
        $storages = Storage::all();

        $movementTypes = ['IN', 'OUT', 'ADJUSTMENT'];

        foreach ($storages as $storage) {

            // create 3–8 random movements per product
            $movementsCount = rand(3, 8);

            for ($i = 0; $i < $movementsCount; $i++) {

                $type = $movementTypes[array_rand($movementTypes)];
                $qty  = rand(1, 20);

                // Adjust stock depending on movement type
                if ($type === 'IN') {

                    $storage->stock_quantity += $qty;
                } elseif ($type === 'OUT') {

                    // Prevent negative stock
                    if ($storage->stock_quantity < $qty) {
                        continue;
                    }

                    $storage->stock_quantity -= $qty;
                } else {

                    // Adjustment (random add or subtract)
                    if (rand(0, 1)) {
                        $storage->stock_quantity += $qty;
                    } else {
                        if ($storage->stock_quantity >= $qty) {
                            $storage->stock_quantity -= $qty;
                        }
                    }
                }

                $storage->save();

                StockMovement::create([
                    'storage_id' => $storage->id,
                    'movement_type' => $type,
                    'quantity' => $qty,
                    'reference_no' => 'REF-' . rand(1000, 9999),
                    'note' => 'Auto generated movement',
                    'created_by' => 1,
                ]);
            }
        }
    }
}
