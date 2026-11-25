<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::orderBy('id')->get();
        $branches = Branch::orderBy('id')->get();
        $products = Product::where('status', true)
            ->where('sell_price', '>', 0)
            ->orderBy('id')
            ->get();

        $cashier = User::where('username', 'cashier')->first();
        $admin = User::where('username', 'admin')->first();

        if ($customers->isEmpty() || $branches->isEmpty() || $products->count() < 2) {
            throw new RuntimeException(
                'Customers, branches and at least two products are required.'
            );
        }

        if (!$cashier || !$admin) {
            throw new RuntimeException(
                'Admin and cashier users are required. Run UserSeeder first.'
            );
        }

        $invoiceDates = [
            '2026-06-15',
            '2026-06-28',
            '2026-07-12',
            '2026-07-25',
            '2026-08-10',
            '2026-08-25',
            '2026-09-12',
            '2026-10-05',
            '2026-10-20',
            '2026-11-05',
        ];

        DB::transaction(function () use (
            $customers,
            $branches,
            $products,
            $cashier,
            $admin,
            $invoiceDates
        ) {
            foreach ($invoiceDates as $index => $date) {
                $firstProduct = $products->values()->get(($index * 2) % $products->count());
                $secondProduct = $products->values()->get(
                    (($index * 2) + 1) % $products->count()
                );

                $lines = [];

                foreach ([$firstProduct, $secondProduct] as $productIndex => $product) {
                    $quantity = (($index + $productIndex) % 3) + 1;
                    $price = (float) $product->sell_price;

                    $lines[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'sku' => $product->sku,
                        'quantity' => $quantity,
                        'price' => $price,
                        'discount' => 0,
                        'amount' => round($price * $quantity, 2),
                    ];
                }

                $subTotal = array_sum(array_column($lines, 'amount'));

                $discountType = $index % 2 === 0 ? 'percentage' : 'flat';
                $discountValue = $discountType === 'percentage'
                    ? 5
                    : 300;

                $discountAmount = $discountType === 'percentage'
                    ? $subTotal * ($discountValue / 100)
                    : $discountValue;

                $discountAmount = min($discountAmount, $subTotal);
                $total = round($subTotal - $discountAmount, 2);

                $paymentStatus = $index % 3;

                if ($paymentStatus === 0) {
                    $status = 'paid';
                    $paidAmount = $total;
                } elseif ($paymentStatus === 1) {
                    $status = 'partial';
                    $paidAmount = round($total / 2, 2);
                } else {
                    $status = 'unpaid';
                    $paidAmount = 0;
                }

                $paidBy = $paidAmount > 0
                    ? ($index % 2 === 0 ? $cashier->id : $admin->id)
                    : null;

                $invoiceNumber = 'INV-2026-' . str_pad(
                    $index + 1,
                    5,
                    '0',
                    STR_PAD_LEFT
                );

                $invoice = Invoice::updateOrCreate(
                    ['invoice_id' => $invoiceNumber],
                    [
                        'customer_id' => $customers
                            ->values()
                            ->get($index % $customers->count())->id,

                        'branch_id' => $branches
                            ->values()
                            ->get($index % $branches->count())->id,

                        'invoice_date' => $date,
                        'items' => $lines,
                        'discount_type' => $discountType,
                        'discount_value' => $discountValue,
                        'sub_total' => round($subTotal, 2),
                        'total' => $total,
                        'status' => $status,
                        'paid_amount' => (string) $paidAmount,
                        'dollar_amount' => (string) round($paidAmount / 120, 2),
                        'paid_by' => $paidBy ? (string) $paidBy : null,
                    ]
                );

                // Rebuild invoice items to keep reruns consistent.
                $invoice->invoiceItems()->delete();

                foreach ($lines as $line) {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $line['product_id'],
                        'quantity' => $line['quantity'],
                        'price' => $line['price'],
                        'discount' => $line['discount'],
                        'amount' => $line['amount'],
                    ]);
                }
            }
        });

        $this->command->info('10 sample invoices seeded successfully.');
    }
}
