<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Users and permissions
            // PermissionSeeder::class,
            // UserSeeder::class,

            // Basic product dependencies
            // UnitSeeder::class,
            // WarrantySeeder::class,
            // CategorySeeder::class,
            // BrandSeeder::class,

            // Business setup
            // SupplierSeeder::class,
            // BranchSeeder::class,

            // WarehouseSeeder::class,
            // ManufacturerSeeder::class,
            // Inventory
            // ProductSeeder::class,
            // StorageSeeder::class,
            // Bank balances and transactions
            BankBalanceSeeder::class,
            BankDepositSeeder::class,
            BankWithdrawSeeder::class,

            // Business transactions
            ChallanSeeder::class,
            InvoiceSeeder::class,
            PettyCashSeeder::class,

            // Other modules - enable when needed
            // CustomerSeeder::class,
            // PettyCashSeeder::class,
            // StorageSeeder::class,
            // StockMovementSeeder::class,
            // ManufacturerSeeder::class,
            // ProductInspectionSeeder::class,
            // ViewPermissionSeeder::class,
        ]);
    }
}
