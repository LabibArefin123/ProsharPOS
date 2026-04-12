<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDamage;
use App\Models\ProductExpiry;
use App\Models\StockMovement;
use App\Models\Invoice;
use App\Models\PettyCash;
use App\Models\Challan;
use App\Models\ChallanItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Default values (avoid undefined errors in Blade)
        $data = [
            'total_invoices' => 0,
            'salesAmount' => 0,
            'receiveAmount' => 0,
            'dueAmount' => 0,
            'totalPayment' => 0,
            'totalPaymentInDollar' => 0,

            'total_challans' => 0,
            'total_challan_bill' => 0,
            'total_challan_unbill' => 0,
            'total_challan_foc' => 0,

            'totalPettyCashReceive' => 0,
            'totalPettyCashExpense' => 0,
            'totalPettyCashDollarReceive' => 0,
            'totalPettyCashDollarExpense' => 0,

            'totalPettyCashReceivePending' => 0,
            'totalPettyCashExpensePending' => 0,
            'totalPettyCashDollarReceivePending' => 0,
            'totalPettyCashDollarExpensePending' => 0,

            'totalPettyCashReceiveApproved' => 0,
            'totalPettyCashExpenseApproved' => 0,
            'totalPettyCashDollarReceiveApproved' => 0,
            'totalPettyCashDollarExpenseApproved' => 0,

            'totalPettyCashReceiveRejected' => 0,
            'totalPettyCashExpenseRejected' => 0,
            'totalPettyCashDollarReceiveRejected' => 0,
            'totalPettyCashDollarExpenseRejected' => 0,

            // Inventory
            'total_products' => 0,
            'total_stock_movements' => 0,
            'damaged_products' => 0,
            'expired_products' => 0,
        ];

        /*
    |--------------------------------------------------------------------------
    | ADMIN & MANAGER
    |--------------------------------------------------------------------------
    */
        if ($user->hasRole(['admin', 'manager'])) {

            $data['total_invoices'] = Invoice::count();
            $data['salesAmount'] = Invoice::sum('total');
            $data['receiveAmount'] = Invoice::sum('paid_amount');

            $data['totalPayment'] = Payment::sum('paid_amount');
            $data['totalPaymentInDollar'] = Payment::sum('dollar_amount');

            $data['dueAmount'] = Invoice::where('status', 0)
                ->selectRaw('SUM(total - paid_amount) as due')
                ->value('due');

            // Challan
            $data['total_challans'] = Challan::count();
            $data['total_challan_bill'] = ChallanItem::sum('challan_bill');
            $data['total_challan_unbill'] = ChallanItem::sum('challan_unbill');
            $data['total_challan_foc'] = ChallanItem::sum('challan_foc');

            // Petty Cash (ALL)
            $this->loadPettyCashData($data);
        }

        /*
    |--------------------------------------------------------------------------
    | CASHIER
    |--------------------------------------------------------------------------
    */ elseif ($user->hasRole('cashier')) {

            $data['total_invoices'] = Invoice::count();
            $data['salesAmount'] = Invoice::sum('total');
        }

        /*
    |--------------------------------------------------------------------------
    | INVENTORY MANAGER
    |--------------------------------------------------------------------------
    */ elseif ($user->hasRole('inventory_manager')) {

            $data['total_products'] = Product::count();
            $data['total_stock_movements'] = StockMovement::count();
            $data['damaged_products'] = ProductDamage::count();
            $data['expired_products'] = ProductExpiry::count();
        }

        /*
    |--------------------------------------------------------------------------
    | ACCOUNTANT
    |--------------------------------------------------------------------------
    */ elseif ($user->hasRole('accountant')) {

            $data['salesAmount'] = Invoice::sum('total');
            $data['receiveAmount'] = Invoice::sum('paid_amount');

            $data['dueAmount'] = Invoice::where('status', 0)
                ->selectRaw('SUM(total - paid_amount) as due')
                ->value('due');

            $data['totalPayment'] = Payment::sum('paid_amount');

            // Petty Cash
            $this->loadPettyCashData($data);
        }

        return view('backend.dashboard_section.dashboard', $data);
    }

    private function loadPettyCashData(&$data)
    {
        // MAIN
        $data['totalPettyCashReceive'] = PettyCash::where('type', 'receive')->where('currency', 'BDT')->where('status', 'approved')->sum('amount');
        $data['totalPettyCashExpense'] = PettyCash::where('type', 'expense')->where('currency', 'BDT')->where('status', 'approved')->sum('amount');

        $data['totalPettyCashDollarReceive'] = PettyCash::where('type', 'receive')->where('currency', 'USD')->where('status', 'approved')->sum('amount_in_dollar');
        $data['totalPettyCashDollarExpense'] = PettyCash::where('type', 'expense')->where('currency', 'USD')->where('status', 'approved')->sum('amount_in_dollar');

        // PENDING
        $data['totalPettyCashReceivePending'] = PettyCash::where('type', 'receive')->where('currency', 'BDT')->where('status', 'pending')->count();
        $data['totalPettyCashExpensePending'] = PettyCash::where('type', 'expense')->where('currency', 'BDT')->where('status', 'pending')->count();

        $data['totalPettyCashDollarReceivePending'] = PettyCash::where('type', 'receive')->where('currency', 'USD')->where('status', 'pending')->count();
        $data['totalPettyCashDollarExpensePending'] = PettyCash::where('type', 'expense')->where('currency', 'USD')->where('status', 'pending')->count();

        // APPROVED
        $data['totalPettyCashReceiveApproved'] = PettyCash::where('type', 'receive')->where('currency', 'BDT')->where('status', 'approved')->count();
        $data['totalPettyCashExpenseApproved'] = PettyCash::where('type', 'expense')->where('currency', 'BDT')->where('status', 'approved')->count();

        $data['totalPettyCashDollarReceiveApproved'] = PettyCash::where('type', 'receive')->where('currency', 'USD')->where('status', 'approved')->count();
        $data['totalPettyCashDollarExpenseApproved'] = PettyCash::where('type', 'expense')->where('currency', 'USD')->where('status', 'approved')->count();

        // REJECTED
        $data['totalPettyCashReceiveRejected'] = PettyCash::where('type', 'receive')->where('currency', 'BDT')->where('status', 'rejected')->count();
        $data['totalPettyCashExpenseRejected'] = PettyCash::where('type', 'expense')->where('currency', 'BDT')->where('status', 'rejected')->count();

        $data['totalPettyCashDollarReceiveRejected'] = PettyCash::where('type', 'receive')->where('currency', 'USD')->where('status', 'rejected')->count();
        $data['totalPettyCashDollarExpenseRejected'] = PettyCash::where('type', 'expense')->where('currency', 'USD')->where('status', 'rejected')->count();
    }

    public function system_index()
    {
        // -----------------------------
        // Total Users
        // -----------------------------
        $totalUsers = User::count();

        // -----------------------------
        // Table Row Counts + Last Updated Time
        // -----------------------------
        $dbName = DB::getDatabaseName();

        $tables = DB::select("
            SELECT 
                TABLE_NAME,
                UPDATE_TIME
            FROM information_schema.tables
            WHERE table_schema = ?
        ", [$dbName]);

        $tableCounts = [];
        $totalRecords = 0;

        foreach ($tables as $table) {
            $tableName = $table->TABLE_NAME;

            if (in_array($tableName, ['migrations', 'failed_jobs'])) {
                continue;
            }

            $count = DB::table($tableName)->count();

            $tableCounts[$tableName] = [
                'count' => $count,
                'updated_at' => $table->UPDATE_TIME
                    ? date('Y-m-d H:i:s', strtotime($table->UPDATE_TIME))
                    : null,
            ];

            $totalRecords += $count;
        }


        // -----------------------------
        // Database Size
        // -----------------------------
        $dbSize = DB::selectOne("
            SELECT 
                ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size
            FROM information_schema.tables
            WHERE table_schema = ?
        ", [$dbName]);

        $databaseSize = $dbSize->size ?? 0;

        // -----------------------------
        // Last Backup Time
        // -----------------------------
        $backupPath = storage_path('app');
        $lastBackupTime = 'No backup found';

        if (File::exists($backupPath)) {
            $files = collect(File::files($backupPath))
                ->filter(fn($file) => $file->getExtension() === 'sql');

            if ($files->isNotEmpty()) {
                $latestFile = $files->sortByDesc(fn($f) => $f->getMTime())->first();
                $lastBackupTime = date('Y-m-d H:i:s', $latestFile->getMTime());
            }
        }

        return view('backend.dashboard_section.system_dashboard', compact(
            'totalUsers',
            'totalRecords',
            'tableCounts',
            'databaseSize',
            'lastBackupTime'
        ));
    }

        public function viewTable($table)
        {
            if (!Schema::hasTable($table)) {
                abort(404);
            }

            if (request()->ajax()) {
                $query = DB::table($table)->latest();

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->make(true);
            }

            return view('backend.dashboard_section.table_view', compact('table'));
        }

    public function truncateTable(Request $request)
    {
        $table = $request->table;

        // ❌ Prevent dangerous tables
        $protected = ['users', 'migrations', 'password_resets'];

        if (in_array($table, $protected)) {
            return response()->json([
                'message' => 'This table is protected!'
            ], 403);
        }

        if (!Schema::hasTable($table)) {
            return response()->json([
                'message' => 'Invalid table!'
            ], 404);
        }

        DB::table($table)->truncate();

        return response()->json([
            'message' => "Table '$table' truncated successfully!"
        ]);
    }
}
