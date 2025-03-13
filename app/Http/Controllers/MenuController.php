<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas\Expenses;
use App\Models\Aktivitas\Income;
use App\Models\Assets\Saving;
use App\Models\MasterData\AccountBank;
use App\Models\MasterData\Category;
use App\Models\MasterData\Debit;
use App\Models\MasterData\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function home()
    {
        // ====Jumlah tabungan --------------------------------------------------------
        // Ambil kategori tabungan berdasarkan user_id yang login
        $savingCategory = Category::where('user_id', Auth::id())
            ->where('name', 'Saving (Tabungan)')
            ->first();
        if ($savingCategory) {
            $subCategories = SubCategory::where('category_id', $savingCategory->id)
                ->pluck('id'); // Mengambil hanya ID dalam bentuk array

            // Ambil transaksi terbaru untuk setiap sub_category_id
            $latestTransactions = Saving::whereIn('sub_category_id', $subCategories)
                ->where('user_id', Auth::id())
                ->orderBy('sub_category_id') // Urutkan berdasarkan sub_category_id
                ->orderByDesc('created_at') // Urutkan terbaru berdasarkan waktu
                ->get()
                ->unique('sub_category_id'); // Ambil hanya satu transaksi terbaru dari setiap sub_category_id

            // Hitung total amount dari transaksi terbaru masing-masing sub_category
            $totalSavingAmount = $latestTransactions->sum('balance');
        } else {
            $totalSavingAmount = 0;
        }
        // ------------------------------------------Transaksi------------------
        // Dapatkan bulan & tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Hitung total pemasukan berdasarkan user_id, bulan, dan tahun saat ini
        $totalIncome = Income::where('user_id', Auth::id())
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        if ($savingCategory) {
            // Hitung total pengeluaran berdasarkan user_id, bulan, dan tahun saat ini
            $totalExpenses = Expenses::where('user_id', Auth::id())
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->where('category_id', '!=', $savingCategory->id)
                ->sum('amount');
        } else {
            $totalExpenses = 0;
        }
        // --------------------------------Transaksi baru- Belum berfungsi---------------------


        // // Ambil data dari tabel Income
        // $income = Income::where('user_id', Auth::id())
        //     ->select(
        //         'id',
        //         'amount',
        //         'date',
        //         'source_id AS category_id',
        //         'sub_source_id AS sub_kategori_id',
        //         DB::raw("'income' AS type")
        //     );

        // // Ambil data dari tabel Expenses dan gabungkan dengan Income
        // $transactions = Expenses::where('user_id', Auth::id())
        //     ->select(
        //         'id',
        //         'amount',
        //         'date',
        //         'category_id',
        //         'sub_kategori_id',
        //         DB::raw("'expense' AS type")
        //     )
        //     ->union($income) // Gabungkan data Income & Expenses

        $expenses = Expenses::where('user_id', Auth::id())
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->get();
        // Ambil data pendapatan
        $incomes = Income::where('user_id', Auth::id())
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->get();
        // Gabungkan transaksi
        $transactions = collect()
            ->merge($expenses->map(fn($expense) => [
                'id' => $expense->id,
                'date' => $expense->date,
                'category' => $expense->category->name,
                'description' => $expense->subCategory->name,
                'amount' => $expense->amount,
                'type' => 'expense',
            ]))
            ->merge($incomes->map(fn($income) => [
                'id' => $income->id,
                'date' => $income->date,
                'category' => $income->source->name,
                'description' => $income->subSource->name,
                'amount' => $income->amount,
                'type' => 'income',
            ]))
            ->sortByDesc('date')
            ->take(5) // Ambil 5 transaksi terbaru
        ;
        // DD($transactions);
        // --------------------------Untuk jumlah saldo------------------------
        // Hitung total saldo dari AccountBank
        $totalBankBalance = AccountBank::where('user_id', Auth::id())->sum('amount');

        // Ambil saldo terbaru dari Debit
        $latestDebit = Debit::where('user_id', Auth::id())->latest()->first();
        $totalCashBalance = $latestDebit ? $latestDebit->balance : 0;

        // Hitung saldo bersih (total saldo bank + saldo tunai)
        $totalBalance = $totalBankBalance + $totalCashBalance;

        // ==========--------------------------------------------------------
        return Inertia::render(
            'Menu/Home',
            [
                'totalIncome' => $totalIncome,
                'totalExpenses' => $totalExpenses,
                'totalSavingAmount' => $totalSavingAmount,
                'totalBalance' => $totalBalance, // Saldo bersih
                'totalBankBalance' => $totalBankBalance, // Saldo bank
                'totalCashBalance' => $totalCashBalance, // Saldo tunai
                'latestTransactions' => $transactions, //belum berfungsi
            ]
        );
    }
    public function aset()
    {
        // Ambil kategori tabungan berdasarkan user_id yang login
        $savingCategory = Category::where('user_id', Auth::id())
            ->where('name', 'Saving (Tabungan)')
            ->first();
        if ($savingCategory) {
            $subCategories = SubCategory::where('category_id', $savingCategory->id)
                ->pluck('id'); // Mengambil hanya ID dalam bentuk array

            // Ambil transaksi terbaru untuk setiap sub_category_id
            $latestTransactions = Saving::whereIn('sub_category_id', $subCategories)
                ->where('user_id', Auth::id())
                ->orderBy('sub_category_id') // Urutkan berdasarkan sub_category_id
                ->orderByDesc('created_at') // Urutkan terbaru berdasarkan waktu
                ->get()
                ->unique('sub_category_id'); // Ambil hanya satu transaksi terbaru dari setiap sub_category_id

            // Hitung total amount dari transaksi terbaru masing-masing sub_category
            $totalSavingAmount = $latestTransactions->sum('balance');
        } else {
            $totalSavingAmount = 0;
        }
        return Inertia::render('Menu/Aset', compact('totalSavingAmount'));
    }

    public function laporan(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $user = Auth::user();

        // Ambil kategori tabungan berdasarkan user_id yang login
        $savingCategory = Category::where('user_id', Auth::id())
            ->where('name', 'Saving (Tabungan)')
            ->first();
        if ($savingCategory) {
            // Ambil data pengeluaran
            $expenses = Expenses::where('user_id', $user->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('category_id', '!=', $savingCategory->id)
                ->get();
        } else {
            $expenses = 0;
        }


        // Ambil data pendapatan
        $incomes = Income::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        // Ambil data tabungan
        $savings = Saving::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        // Hitung total
        $totalExpenses = $expenses->sum('amount');
        $totalIncome = $incomes->sum('amount');
        $totalSavings = $savings->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;

        // Gabungkan transaksi
        $transactions = collect()
            ->merge($expenses->map(fn($expense) => [
                'id' => $expense->id,
                'date' => $expense->date,
                'category' => $expense->category->name,
                'description' => $expense->subCategory->name,
                'amount' => $expense->amount,
                'type' => 'expense',
            ]))
            ->merge($incomes->map(fn($income) => [
                'id' => $income->id,
                'date' => $income->date,
                'category' => $income->source->name,
                'description' => $income->subSource->name,
                'amount' => $income->amount,
                'type' => 'income',
            ]))
            ->sortByDesc('date');

        // dd([
        //     'total_expenses' => $totalExpenses,
        //     'total_income' => $totalIncome,
        //     'total_savings' => $totalSavings,
        //     'net_balance' => $netBalance,
        //     'transactions' => $transactions,
        // ]);

        return Inertia::render('Menu/Laporan', [
            'report' => [
                'total_expenses' => $totalExpenses,
                'total_income' => $totalIncome,
                'total_savings' => $totalSavings,
                'net_balance' => $netBalance,
                'transactions' => $transactions,
            ],
        ]);
    }
    public function setupData()
    {

        return Inertia::render('Menu/SetupData');
    }

    public function getFinanceSummary()
    {
        $currentMonth = now()->format('Y-m');

        $expenses = Expenses::where('date', 'like', "$currentMonth%")->sum('amount');
        $income = Income::where('date', 'like', "$currentMonth%")->sum('amount');

        return response()->json([
            'expenses' => $expenses,
            'income' => $income
        ]);
    }
}
