<?php

namespace Database\Seeders;

use App\Models\BankBalance;
use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class BankBalanceSeeder extends Seeder
{
    public function run(): void
    {
        $balances = [
            'admin' => 500000,
            'manager' => 100000,
            'cashier' => 30000,
            'inventory_manager' => 50000,
            'accountant' => 75000,
        ];

        foreach ($balances as $username => $balance) {
            $user = User::where('username', $username)->first();

            if (!$user) {
                throw new RuntimeException(
                    "User '{$username}' not found. Run UserSeeder first."
                );
            }

            BankBalance::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'balance' => $balance,
                    'balance_in_dollars' => 0,
                    'currency' => 'BDT',
                ]
            );
        }

        $this->command->info('User bank balances seeded successfully.');
    }
}
