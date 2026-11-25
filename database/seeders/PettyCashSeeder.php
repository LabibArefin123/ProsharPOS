<?php

namespace Database\Seeders;

use App\Models\BankBalance;
use App\Models\Customer;
use App\Models\PettyCash;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PettyCashSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereIn('username', [
            'admin',
            'manager',
            'cashier',
            'inventory_manager',
            'accountant',
        ])->get()->keyBy('id');

        $bankBalances = BankBalance::whereIn('user_id', $users->keys())
            ->get()
            ->keyBy('user_id');

        $productIds = Product::pluck('id')->all();
        $supplierIds = Supplier::pluck('id')->all();
        $customerIds = Customer::pluck('id')->all();

        if (
            $users->isEmpty() ||
            $bankBalances->isEmpty() ||
            empty($productIds) ||
            empty($supplierIds) ||
            empty($customerIds)
        ) {
            throw new RuntimeException(
                'Required users, bank balances, products, suppliers or customers are missing.'
            );
        }

        $notes = [
            'Office stationery purchase',
            'Product stock adjustment',
            'Customer cash receive',
            'Supplier payment',
            'Transport and logistics cost',
            'Internet and utility bill',
            'Snacks for office',
            'Emergency maintenance',
            'Miscellaneous petty expense',
        ];

        $userList = $users->values();

        DB::transaction(function () use (
            $userList,
            $bankBalances,
            $productIds,
            $supplierIds,
            $customerIds,
            $notes
        ) {
            for ($i = 1; $i <= 20; $i++) {
                $user = $userList->get(($i - 1) % $userList->count());
                $bankBalance = $bankBalances->get($user->id);

                if (!$bankBalance) {
                    throw new RuntimeException(
                        "Bank balance missing for user {$user->username}."
                    );
                }

                $type = $i % 2 === 0 ? 'receive' : 'expense';
                $isDollar = $i % 10 === 0;

                if ($isDollar) {
                    $currency = 'USD';
                    $amountDollar = random_int(5, 100);
                    $exchangeRate = 120;
                    $amountBDT = $amountDollar * $exchangeRate;
                } else {
                    $currency = 'BDT';
                    $amountBDT = random_int(200, 6000);
                    $amountDollar = null;
                    $exchangeRate = null;
                }

                $date = Carbon::create(2026, 6, 10)
                    ->addDays(($i * 7) % 154)
                    ->setTime(10 + ($i % 8), ($i * 5) % 60);

                $reference = 'PC-SEED-' . str_pad(
                    $i,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

                PettyCash::updateOrCreate(
                    ['reference_no' => $reference],
                    [
                        'bank_balance_id' => $bankBalance->id,
                        'product_id' => $productIds[($i - 1) % count($productIds)],
                        'supplier_id' => $supplierIds[($i - 1) % count($supplierIds)],
                        'customer_id' => $customerIds[($i - 1) % count($customerIds)],
                        'category_id' => null,
                        'user_id' => $user->id,
                        'type' => $type,
                        'reference_type' => 'petty_cash',
                        'amount' => $amountBDT,
                        'amount_in_dollar' => $amountDollar,
                        'exchange_rate' => $exchangeRate,
                        'currency' => $currency,
                        'payment_method' => ['cash', 'bank', 'bkash'][$i % 3],
                        'note' => $notes[($i - 1) % count($notes)],
                        'attachment' => null,
                        'status' => $i % 4 === 0 ? 'approved' : 'pending',
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]
                );
            }
        });

        $this->command->info('20 petty cash records seeded successfully.');
    }
}
