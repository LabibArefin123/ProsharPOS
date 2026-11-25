<?php

namespace Database\Seeders;

use App\Models\BankBalance;
use App\Models\BankWithdraw;
use Illuminate\Database\Seeder;
use RuntimeException;

class BankWithdrawSeeder extends Seeder
{
    public function run(): void
    {
        $withdrawals = [
            [
                'username' => 'admin',
                'records' => [
                    ['date' => '2026-07-10', 'amount' => 10000, 'method' => 'cash'],
                    ['date' => '2026-10-10', 'amount' => 15000, 'method' => 'transfer'],
                ],
            ],
            [
                'username' => 'manager',
                'records' => [
                    ['date' => '2026-07-20', 'amount' => 5000, 'method' => 'cash'],
                    ['date' => '2026-09-20', 'amount' => 8000, 'method' => 'cheque'],
                ],
            ],
            [
                'username' => 'cashier',
                'records' => [
                    ['date' => '2026-08-01', 'amount' => 2000, 'method' => 'cash'],
                    ['date' => '2026-10-20', 'amount' => 3000, 'method' => 'bkash'],
                ],
            ],
            [
                'username' => 'imanager',
                'records' => [
                    ['date' => '2026-08-25', 'amount' => 4000, 'method' => 'transfer'],
                    ['date' => '2026-10-25', 'amount' => 6000, 'method' => 'cash'],
                ],
            ],
            [
                'username' => 'accountant',
                'records' => [
                    ['date' => '2026-09-15', 'amount' => 5000, 'method' => 'cheque'],
                    ['date' => '2026-11-05', 'amount' => 7000, 'method' => 'transfer'],
                ],
            ],
        ];

        foreach ($withdrawals as $userData) {
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
                $reference = 'WDR-' . strtoupper($userData['username'])
                    . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

                BankWithdraw::updateOrCreate(
                    ['reference_no' => $reference],
                    [
                        'bank_balance_id' => $bankBalance->id,
                        'user_id' => $bankBalance->user_id,
                        'withdraw_date' => $record['date'],
                        'amount' => $record['amount'],
                        'withdraw_method' => $record['method'],
                        'note' => 'Sample bank withdrawal transaction.',
                    ]
                );
            }
        }

        $this->command->info('Bank withdrawals seeded successfully.');
    }
}
