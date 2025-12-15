<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PettyCash;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PettyCashSeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::create(2025, 12, 10);
        $endDate   = Carbon::create(2026, 3, 10);

        $totalRecords = rand(50, 75);

        // Fetch existing IDs (important)
        $productIds  = Product::pluck('id')->toArray();
        $supplierIds = Supplier::pluck('id')->toArray();
        $customerIds = Customer::pluck('id')->toArray();

        // Safety check
        if (empty($productIds) || empty($supplierIds) || empty($customerIds)) {
            $this->command->error('Product, Supplier or Customer table is empty!');
            return;
        }

        $paymentMethods = ['cash', 'bank', 'bkash'];
        $statuses = ['pending', 'pending', 'pending', 'approved']; // rare approved
        $types = ['expense', 'receive'];

        $notes = [
            'Office stationery purchase',
            'Product stock adjustment',
            'Customer cash receive',
            'Supplier payment',
            'Transport and logistics cost',
            'Internet & utility bill',
            'Snacks for office',
            'Emergency maintenance',
            'Miscellaneous petty expense',
        ];

        for ($i = 1; $i <= $totalRecords; $i++) {

            $date = Carbon::createFromTimestamp(
                rand($startDate->timestamp, $endDate->timestamp)
            );

            // Decide type
            $type = $types[array_rand($types)];

            // Currency logic (Mostly BDT)
            $isDollar = rand(1, 10) === 10; // ~10% USD

            if ($isDollar) {
                $currency = 'USD';
                $amountDollar = rand(5, 100);
                $exchangeRate = rand(108, 120);
                $amountBDT = $amountDollar * $exchangeRate;
            } else {
                $currency = 'BDT';
                $amountBDT = rand(200, 6000);
                $amountDollar = null;
                $exchangeRate = null;
            }

            PettyCash::create([
                'bank_balance_id'  => 1,

                // Non-null relations
                'product_id'       => $productIds[array_rand($productIds)],
                'supplier_id'      => $supplierIds[array_rand($supplierIds)],
                'customer_id'      => $customerIds[array_rand($customerIds)],

                'category_id'      => null, // keep optional
                'user_id'          => 1, // admin

                'reference_no'     => 'PC-' . strtoupper(Str::random(8)),
                'type'             => $type,
                'reference_type'   => 'petty_cash',

                'amount'           => $amountBDT,
                'amount_in_dollar' => $amountDollar,
                'exchange_rate'    => $exchangeRate,
                'currency'         => $currency,

                'payment_method'   => $paymentMethods[array_rand($paymentMethods)],
                'note'             => $notes[array_rand($notes)],
                'attachment'       => null,
                'status'           => $statuses[array_rand($statuses)],

                'created_at'       => $date,
                'updated_at'       => $date,
            ]);
        }
    }
}
