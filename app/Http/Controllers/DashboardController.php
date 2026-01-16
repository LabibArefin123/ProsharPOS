<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\PettyCash;
use App\Models\Challan;
use App\Models\ChallanItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $total_invoices = Invoice::count();
        $salesAmount = Invoice::sum('total');
        $receiveAmount = Invoice::sum('paid_amount');
        $totalPayment = Payment::sum('paid_amount');
        $totalPaymentInDollar = Payment::sum('dollar_amount');
        $dueAmount = Invoice::where('status', 0)
            ->selectRaw('SUM(total - paid_amount) as due')
            ->value('due');

        //Challan part
        $total_challans = Challan::count();
        $total_challan_bill = ChallanItem::sum('challan_bill');
        $total_challan_unbill = ChallanItem::sum('challan_unbill');
        $total_challan_foc = ChallanItem::sum('challan_foc');

        //Petty cash part
        $totalPettyCashReceive = PettyCash::where('type', 'receive')
            ->where('currency', 'BDT')
            ->where('status', 'approved')
            ->sum('amount');

        // Petty Cash Expense (BDT)
        $totalPettyCashExpense = PettyCash::where('type', 'expense')
            ->where('currency', 'BDT')
            ->where('status', 'approved')
            ->sum('amount');

        // Dollar Receive
        $totalPettyCashDollarReceive = PettyCash::where('type', 'receive')
            ->where('currency', 'USD')
            ->where('status', 'approved')
            ->sum('amount_in_dollar');

        // Dollar Expense
        $totalPettyCashDollarExpense = PettyCash::where('type', 'expense')
            ->where('currency', 'USD')
            ->where('status', 'approved')
            ->sum('amount_in_dollar');

        //Petty cash part pending
        $totalPettyCashReceivePending = PettyCash::where('type', 'receive')
            ->where('currency', 'BDT')
            ->where('status', 'pending')
            ->count();

        // Petty Cash Expense (BDT)  pending
        $totalPettyCashExpensePending = PettyCash::where('type', 'expense')
            ->where('currency', 'BDT')
            ->where('status', 'pending')
            ->count();

        // Dollar Receive  pending
        $totalPettyCashDollarReceivePending = PettyCash::where('type', 'receive')
            ->where('currency', 'USD')
            ->where('status', 'pending')
            ->count();

        // Dollar Expense  pending
        $totalPettyCashDollarExpensePending = PettyCash::where('type', 'expense')
            ->where('currency', 'USD')
            ->where('status', 'pending')
            ->count();

        //Petty cash part approved
        $totalPettyCashReceiveApproved = PettyCash::where('type', 'receive')
            ->where('currency', 'BDT')
            ->where('status', 'approved')
            ->count();

        // Petty Cash Expense (BDT)  approved
        $totalPettyCashExpenseApproved = PettyCash::where('type', 'expense')
            ->where('currency', 'BDT')
            ->where('status', 'approved')
            ->count();

        // Dollar Receive  approved
        $totalPettyCashDollarReceiveApproved = PettyCash::where('type', 'receive')
            ->where('currency', 'USD')
            ->where('status', 'approved')
            ->count();

        // Dollar Expense  approved
        $totalPettyCashDollarExpenseApproved = PettyCash::where('type', 'expense')
            ->where('currency', 'USD')
            ->where('status', 'approved')
            ->count();

        //Petty cash part rejected
        $totalPettyCashReceiveRejected = PettyCash::where('type', 'receive')
            ->where('currency', 'BDT')
            ->where('status', 'rejected')
            ->count();

        // Petty Cash Expense (BDT)  rejected
        $totalPettyCashExpenseRejected = PettyCash::where('type', 'expense')
            ->where('currency', 'BDT')
            ->where('status', 'rejected')
            ->count();

        // Dollar Receive  rejected
        $totalPettyCashDollarReceiveRejected = PettyCash::where('type', 'receive')
            ->where('currency', 'USD')
            ->where('status', 'rejected')
            ->count();

        // Dollar Expense  rejected
        $totalPettyCashDollarExpenseRejected = PettyCash::where('type', 'expense')
            ->where('currency', 'USD')
            ->where('status', 'rejected')
            ->count();

        return view('backend.dashboard_section.dashboard', compact(
            'total_invoices',
            'salesAmount',
            'receiveAmount',
            'dueAmount',
            'totalPayment',
            'totalPaymentInDollar',
            'total_challans',
            'total_challan_bill',
            'total_challan_unbill',
            'total_challan_foc',
            'totalPettyCashReceive',
            'totalPettyCashExpense',
            'totalPettyCashDollarReceive',
            'totalPettyCashDollarExpense',
            'totalPettyCashReceiveApproved',
            'totalPettyCashExpenseApproved',
            'totalPettyCashDollarReceiveApproved',
            'totalPettyCashDollarExpenseApproved',
            'totalPettyCashExpenseRejected',
            'totalPettyCashReceiveRejected',
            'totalPettyCashDollarReceiveRejected',
            'totalPettyCashDollarExpenseRejected',
            'totalPettyCashReceivePending',
            'totalPettyCashExpensePending',
            'totalPettyCashDollarReceivePending',
            'totalPettyCashDollarExpensePending'
        ));
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
}
