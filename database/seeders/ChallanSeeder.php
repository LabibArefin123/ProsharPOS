<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Challan;
use App\Models\ChallanItem;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warranty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ChallanSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::query()
            ->orderBy('id')
            ->take(5)
            ->get();

        $branches = Branch::query()
            ->orderBy('id')
            ->get();

        $warranty = Warranty::where('name', '1 Year Warranty')->first();

        if ($suppliers->count() < 5) {
            throw new RuntimeException(
                'At least 5 suppliers are required. Run SupplierSeeder first.'
            );
        }

        if ($branches->isEmpty()) {
            throw new RuntimeException(
                'At least one branch is required. Run BranchSeeder first.'
            );
        }

        if (!$warranty) {
            throw new RuntimeException(
                '1 Year Warranty not found. Run WarrantySeeder first.'
            );
        }

        $productSkus = [
            'LAP-DELL-3530-I5',
            'LAP-DELL-3520-I5',
            'LAP-DELL-3440-I5',
            'LAP-HP-15S-I5',
            'LAP-HP-PB450-G10',
            'LAP-HP-250-G10-I3',
            'LAP-LEN-SLIM3-I5',
            'LAP-LEN-E14-G5',
            'LAP-LEN-V15-G4-I3',
            'LAP-ASUS-X1504-I5',
            'LAP-ASUS-B1-I5',
            'LAP-ACER-A515-I5',
        ];

        $products = Product::whereIn('sku', $productSkus)
            ->get()
            ->keyBy('sku');

        if ($products->count() !== count($productSkus)) {
            throw new RuntimeException(
                'Some laptop products are missing. Run ProductSeeder first.'
            );
        }

        $challans = [
            [
                'challan_no' => 'CH-2026-0001',
                'challan_date' => '2026-10-05',
                'supplier_index' => 0,
                'branch_index' => 0,
                'challan_ref' => 'SUP-INV-1001',
                'out_ref' => 'OUT-1001',
                'valid_until' => '2027-10-05',
                'lines' => [
                    [
                        'sku' => 'LAP-DELL-3530-I5',
                        'challan_total' => 10,
                        'challan_bill' => 8,
                        'challan_unbill' => 1,
                        'challan_foc' => 1,
                    ],
                    [
                        'sku' => 'LAP-HP-15S-I5',
                        'challan_total' => 8,
                        'challan_bill' => 6,
                        'challan_unbill' => 2,
                        'challan_foc' => 0,
                    ],
                ],
            ],
            [
                'challan_no' => 'CH-2026-0002',
                'challan_date' => '2026-10-12',
                'supplier_index' => 1,
                'branch_index' => 1,
                'challan_ref' => 'SUP-INV-1002',
                'out_ref' => 'OUT-1002',
                'valid_until' => '2027-10-12',
                'lines' => [
                    [
                        'sku' => 'LAP-LEN-SLIM3-I5',
                        'challan_total' => 9,
                        'challan_bill' => 7,
                        'challan_unbill' => 1,
                        'challan_foc' => 1,
                    ],
                    [
                        'sku' => 'LAP-ASUS-X1504-I5',
                        'challan_total' => 6,
                        'challan_bill' => 6,
                        'challan_unbill' => 0,
                        'challan_foc' => 0,
                    ],
                ],
            ],
            [
                'challan_no' => 'CH-2026-0003',
                'challan_date' => '2026-10-19',
                'supplier_index' => 2,
                'branch_index' => 2,
                'challan_ref' => 'SUP-INV-1003',
                'out_ref' => 'OUT-1003',
                'valid_until' => '2027-10-19',
                'lines' => [
                    [
                        'sku' => 'LAP-HP-PB450-G10',
                        'challan_total' => 5,
                        'challan_bill' => 4,
                        'challan_unbill' => 1,
                        'challan_foc' => 0,
                    ],
                    [
                        'sku' => 'LAP-DELL-3440-I5',
                        'challan_total' => 4,
                        'challan_bill' => 3,
                        'challan_unbill' => 0,
                        'challan_foc' => 1,
                    ],
                ],
            ],
            [
                'challan_no' => 'CH-2026-0004',
                'challan_date' => '2026-10-25',
                'supplier_index' => 3,
                'branch_index' => 0,
                'challan_ref' => 'SUP-INV-1004',
                'out_ref' => 'OUT-1004',
                'valid_until' => '2027-10-25',
                'lines' => [
                    [
                        'sku' => 'LAP-HP-250-G10-I3',
                        'challan_total' => 12,
                        'challan_bill' => 10,
                        'challan_unbill' => 1,
                        'challan_foc' => 1,
                    ],
                    [
                        'sku' => 'LAP-LEN-E14-G5',
                        'challan_total' => 3,
                        'challan_bill' => 3,
                        'challan_unbill' => 0,
                        'challan_foc' => 0,
                    ],
                ],
            ],
            [
                'challan_no' => 'CH-2026-0005',
                'challan_date' => '2026-11-02',
                'supplier_index' => 4,
                'branch_index' => 1,
                'challan_ref' => 'SUP-INV-1005',
                'out_ref' => 'OUT-1005',
                'valid_until' => '2027-11-02',
                'lines' => [
                    [
                        'sku' => 'LAP-LEN-V15-G4-I3',
                        'challan_total' => 10,
                        'challan_bill' => 8,
                        'challan_unbill' => 1,
                        'challan_foc' => 1,
                    ],
                    [
                        'sku' => 'LAP-ACER-A515-I5',
                        'challan_total' => 7,
                        'challan_bill' => 5,
                        'challan_unbill' => 2,
                        'challan_foc' => 0,
                    ],
                ],
            ],
        ];

        DB::transaction(function () use (
            $challans,
            $suppliers,
            $branches,
            $warranty,
            $products
        ) {
            foreach ($challans as $data) {
                $items = [];

                foreach ($data['lines'] as $line) {
                    $product = $products->get($line['sku']);

                    if (!$product) {
                        throw new RuntimeException(
                            "Product not found: {$line['sku']}"
                        );
                    }

                    $total = (int) $line['challan_total'];
                    $bill = (int) $line['challan_bill'];
                    $unbill = (int) $line['challan_unbill'];
                    $foc = (int) $line['challan_foc'];

                    if ($total !== ($bill + $unbill + $foc)) {
                        throw new RuntimeException(
                            "Invalid quantity breakdown for {$line['sku']}."
                        );
                    }

                    $items[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'sku' => $product->sku,
                        'challan_total' => $total,
                        'challan_bill' => $bill,
                        'challan_unbill' => $unbill,
                        'challan_foc' => $foc,
                    ];
                }

                $challan = Challan::withTrashed()->updateOrCreate(
                    [
                        'challan_no' => $data['challan_no'],
                    ],
                    [
                        'supplier_id' => $suppliers
                            ->values()
                            ->get($data['supplier_index'])->id,

                        'branch_id' => $branches
                            ->values()
                            ->get($data['branch_index'] % $branches->count())->id,

                        'challan_date' => $data['challan_date'],
                        'items' => $items,
                        'challan_ref' => $data['challan_ref'],
                        'out_ref' => $data['out_ref'],
                        'warranty_id' => $warranty->id,
                        'valid_until' => $data['valid_until'],
                        'note' => 'Sample laptop inventory challan.',
                    ]
                );

                if ($challan->trashed()) {
                    $challan->restore();
                }

                // Remove previous items before recreating them.
                $challan->citems()->delete();

                foreach ($items as $item) {
                    ChallanItem::create([
                        'challan_id' => $challan->id,
                        'product_id' => $item['product_id'],
                        'challan_total' => $item['challan_total'],
                        'challan_bill' => $item['challan_bill'],
                        'challan_unbill' => $item['challan_unbill'],
                        'challan_foc' => $item['challan_foc'],
                        'warranty_id' => $warranty->id,
                    ]);
                }
            }
        });
    }
}
