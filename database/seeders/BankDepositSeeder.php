<?php

namespace Database\Seeders;

use App\Models\BankBalance;
use App\Models\BankDeposit;
use Illuminate\Database\Seeder;
use RuntimeException;

class BankDepositSeeder extends Seeder
{
    public function run(): void
    {
        $deposits = [
            [
                'username' => 'admin',
                'records' => [
                    ['date' => '2026-06-15', 'amount' => 25000, 'method' => 'cash'],
                    ['date' => '2026-08-20', 'amount' => 40000, 'method' => 'transfer'],
                ],
            ],
            [
                'username' => 'manager',
                'records' => [
                    ['date' => '2026-07-05', 'amount' => 10000, 'method' => 'cheque'],
                    ['date' => '2026-09-12', 'amount' => 15000, 'method' => 'bkash'],
                ],
            ],
            [
                'username' => 'cashier',
                'records' => [
                    ['date' => '2026-07-18', 'amount' => 5000, 'method' => 'cash'],
                    ['date' => '2026-10-05', 'amount' => 8000, 'method' => 'nagad'],
                ],
            ],
            [
                'username' => 'inventory_manager',
                'records' => [
                    ['date' => '2026-08-10', 'amount' => 7000, 'method' => 'transfer'],
                    ['date' => '2026-10-15', 'amount' => 12000, 'method' => 'cash'],
                ],
            ],
            [
                'username' => 'accountant',
                'records' => [
                    ['date' => '2026-09-01', 'amount' => 12000, 'method' => 'cheque'],
                    ['date' => '2026-11-01', 'amount' => 18000, 'method' => 'transfer'],
                ],
            ],
        ];

        foreach ($deposits as $userData) {
            $bankBalance = BankBalance::whereHas(
                'user',
                fn($query) => $query->where('username', $userData['username'])
            )->first();

            if (!$bankBalance) {
                throw new RuntimeException(
                    "Bank balance not found for {$userData['username']}."
                );
            }

            foreach ($userData['records'] as $index => $record) {
                $reference = 'DEP-' . strtoupper($userData['username'])
                    . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

                BankDeposit::updateOrCreate(
                    ['reference_no' => $reference],
                    [
                        'bank_balance_id' => $bankBalance->id,
                        'user_id' => $bankBalance->user_id,
                        'deposit_date' => $record['date'],
                        'amount' => $record['amount'],
                        'amount_in_dollar' => round($record['amount'] / 120, 2),
                        'deposit_method' => $record['method'],
                        'note' => 'Sample bank deposit transaction.',
                    ]
                );
            }
        }

        $this->command->info('Bank deposits seeded successfully.');
    }
}
