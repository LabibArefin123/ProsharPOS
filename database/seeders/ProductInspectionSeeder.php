<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductInspection;
use App\Models\Storage;
use App\Models\User;
use Carbon\Carbon;

class ProductInspectionSeeder extends Seeder
{
    public function run(): void
    {
        $storages = Storage::all();
        $users    = User::pluck('id')->toArray();

        if ($storages->isEmpty()) {
            return;
        }

        $inspectionTypes = ['purchase', 'routine', 'return'];
        $statuses        = ['passed', 'partial', 'failed'];

        // Date range: Feb 25 → March 5, 2026
        $startDate = Carbon::create(2026, 2, 25);
        $endDate   = Carbon::create(2026, 3, 5);

        // Generate between 100–120 inspections
        $totalInspections = rand(100, 120);

        for ($i = 0; $i < $totalInspections; $i++) {

            $storage = $storages->random();
            $checkedQty = rand(5, 100);

            // Ensure defective is not more than checked
            $defectiveQty = rand(0, $checkedQty);

            // Random date inside range
            $randomDate = Carbon::createFromTimestamp(
                rand($startDate->timestamp, $endDate->timestamp)
            );

            ProductInspection::create([
                'storage_id'         => $storage->id,
                'user_id'            => !empty($users) ? $users[array_rand($users)] : null,
                'inspection_type'    => $inspectionTypes[array_rand($inspectionTypes)],
                'status'             => $statuses[array_rand($statuses)],
                'checked_quantity'   => $checkedQty,
                'defective_quantity' => $defectiveQty,
                'notes'              => 'Auto generated inspection record.',
                'created_at'         => $randomDate,
                'updated_at'         => $randomDate,
            ]);
        }
    }
}
