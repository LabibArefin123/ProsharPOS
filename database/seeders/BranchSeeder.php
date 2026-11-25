<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Dhaka Main Branch',
                'branch_code' => 'DHK-001',
                'phone' => '01700000001',
                'email' => 'dhaka@example.test',
                'address' => 'Dhanmondi, Dhaka, Bangladesh',
                'contact_person' => 'Rahim Ahmed',
                'contact_phone' => '01700000011',
            ],
            [
                'name' => 'Chattogram Branch',
                'branch_code' => 'CTG-001',
                'phone' => '01700000002',
                'email' => 'chattogram@example.test',
                'address' => 'GEC Circle, Chattogram, Bangladesh',
                'contact_person' => 'Karim Hasan',
                'contact_phone' => '01700000012',
            ],
            [
                'name' => 'Sylhet Branch',
                'branch_code' => 'SYL-001',
                'phone' => '01700000003',
                'email' => 'sylhet@example.test',
                'address' => 'Zindabazar, Sylhet, Bangladesh',
                'contact_person' => 'Nusrat Jahan',
                'contact_phone' => '01700000013',
            ],
        ];

        foreach ($branches as $branch) {
            Branch::updateOrCreate(
                ['branch_code' => $branch['branch_code']],
                $branch
            );
        }
    }
}
