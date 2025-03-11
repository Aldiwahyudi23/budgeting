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
use Inertia\Inertia;

class MenuController extends Controller
{
    public function home()
    {
        // ------------------------------------------Transaksi------------------
        // Dapatkan bulan & tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Hitung total pemasukan berdasarkan user_id, bulan, dan tahun saat ini
        $totalIncome = Income::where('user_id', Auth::id())
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        // Hitung total pengeluaran berdasarkan user_id, bulan, dan tahun saat ini
        $totalExpenses = Expenses::where('user_id', Auth::id())
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');
        // --------------------------------Transaksi baru- Belum berfungsi---------------------
        // Ambil 3 transaksi terbaru dari Income
        $incomes = Income::where('user_id', Auth::id())
            ->latest('date')
            ->take(3)
            ->get()
            ->map(function ($income) {
                return [
                    'name' => 'coba', // Nama kategori pemasukan
                    'date' => Carbon::parse($income->date)->format('d M Y'), // Konversi ke format tanggal
                    'amount' => $income->amount,
                    'type' => 'income', // Tandai sebagai pemasukan
                ];
            });

        // Ambil 3 transaksi terbaru dari Expenses
        $expenses = Expenses::where('user_id', Auth::id())
            ->latest('date')
            ->take(3)
            ->get()
            ->map(function ($expense) {
                return [
                    'name' => 'ok', // Nama kategori pengeluaran
                    'date' => Carbon::parse($expense->date)->format('d M Y'), // Konversi ke format tanggal
                    'amount' => $expense->amount,
                    'type' => 'expense', // Tandai sebagai pengeluaran
                ];
            });

        // Gabungkan dan urutkan berdasarkan tanggal terbaru
        $transactions = $incomes->merge($expenses)->sortByDesc('date')->take(3);
        // DD($transactions);
        // --------------------------Untuk jumlah saldo------------------------
        // Hitung total saldo dari AccountBank
        $totalBankBalance = AccountBank::where('user_id', Auth::id())->sum('amount');

        // Ambil saldo terbaru dari Debit
        $latestDebit = Debit::where('user_id', Auth::id())->latest()->first();
        $totalCashBalance = $latestDebit ? $latestDebit->balance : 0;

        // Hitung saldo bersih (total saldo bank + saldo tunai)
        $totalBalance = $totalBankBalance + $totalCashBalance;


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
                'transactions' => $transactions, //belum berfungsi
            ]
        );
    }
    public function aset()
    {
        // Ambil kategori tabungan berdasarkan user_id yang login
        $savingCategory = Category::where('user_id', Auth::id())
            ->where('name', 'Saving (Tabungan)')
            ->first();

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
        return Inertia::render('Menu/Aset', compact('totalSavingAmount'));
    }
    public function laporan()
    {

        return Inertia::render('Menu/Laporan');
    }
    public function setupData()
    {

        return Inertia::render('Menu/SetupData');
    }
}
