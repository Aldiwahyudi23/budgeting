<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas\Expenses;
use App\Models\Aktivitas\Income;
use App\Models\Assets\Saving;
use App\Models\MasterData\AccountBank;
use App\Models\MasterData\Category;
use App\Models\MasterData\Debit;
use App\Models\MasterData\SubCategory;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeContorller extends Controller
{
    public function home()
    {
        $settings = Setting::where('user_id', Auth::id())->first();
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

        $excludedNames = ['Fund Transfer', 'Saving (Tabungan)']; // Nama-nama kategori yang ingin dikecualikan

        $totalIncome = Income::where('user_id', Auth::id())
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->whereHas('source', function ($query) use ($excludedNames) {
                $query->whereNotIn('name', $excludedNames);
            })
            ->sum('amount');


        if ($savingCategory) {
            // Hitung total pengeluaran berdasarkan user_id, bulan, dan tahun saat ini
            $totalExpenses = Expenses::where('user_id', Auth::id())
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->where('category_id', '!=', $savingCategory->id)
                ->whereHas('category', function ($query) use ($excludedNames) {
                    $query->whereNotIn('name', $excludedNames);
                })
                ->sum('amount');
        } else {
            // Hitung total pengeluaran berdasarkan user_id, bulan, dan tahun saat ini
            $totalExpenses = Expenses::where('user_id', Auth::id())
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->whereHas('category', function ($query) use ($excludedNames) {
                    $query->whereNotIn('name', $excludedNames);
                })
                ->sum('amount');
        }
        // --------------------------------Transaksi baru- Belum berfungsi---------------------

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
            ->values(); // Reset keys
        ;
        // DD($transactions);
        // --------------------------Untuk jumlah saldo------------------------
        // Hitung total saldo dari AccountBank
        $totalBankBalance = AccountBank::where('user_id', Auth::id())->sum('amount');

        // Ambil saldo terbaru dari Debit
        $latestDebit = Debit::where('user_id', Auth::id())->latest()->first();
        $totalCashBalance = $latestDebit ? $latestDebit->balance : 0;

        // Hitung saldo bank dan saldo tunai berdasarkan setting
        $totalBank = $settings->bank ? $totalBankBalance : 0;
        $totalCash = $settings->cash ? $totalCashBalance : 0;

        // Hitung saldo bersih (total saldo bank + saldo tunai)
        $totalBalance = $totalBank + $totalCash;

        // ==========--------------------------------------------------------


        return Inertia::render(
            'Menu/Home',
            [
                'settings' => $settings,
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