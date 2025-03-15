<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas\Expenses;
use App\Models\Aktivitas\Income;
use App\Models\Alokasi\AllocationEx;
use App\Models\Alokasi\AllocationIn;
use App\Models\Assets\Saving;
use App\Models\MasterData\Category;
use App\Models\MasterData\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LaporanController extends Controller
{
    public function laporan(Request $request)
    {
        // $year = $request->input('year', now()->year);
        // $month = $request->input('month', now()->month);

        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));

        $user = Auth::user();

        // Ambil kategori tabungan berdasarkan user_id yang login
        $savingCategory = Category::where('user_id', $user->id)
            ->where('name', 'Saving (Tabungan)')
            ->first();

        // Ambil data pengeluaran
        $expensesQuery = Expenses::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month);

        if ($savingCategory) {
            $expensesQuery->where('category_id', '!=', $savingCategory->id);
        }

        $expenses = $expensesQuery->get();

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
        $totalExpenses = $expenses->sum('amount') ?? 0;
        $totalIncome = $incomes->sum('amount') ?? 0;
        $totalSavings = $savings->sum('amount') ?? 0;
        $netBalance = $totalIncome - $totalExpenses;

        // Gabungkan transaksi
        $transactions = collect()
            ->merge($expenses->map(function ($expense) {
                return [
                    'id' => $expense->id,
                    'date' => $expense->date,
                    'category' => $expense->category->name ?? 'Unknown',
                    'description' => $expense->subCategory->name ?? 'Unknown',
                    'amount' => $expense->amount ?? 0,
                    'type' => 'expense',
                ];
            }))
            ->merge($incomes->map(function ($income) {
                return [
                    'id' => $income->id,
                    'date' => $income->date,
                    'category' => $income->source->name ?? 'Unknown',
                    'description' => $income->subSource->name ?? 'Unknown',
                    'amount' => $income->amount ?? 0,
                    'type' => 'income',
                ];
            }))
            ->sortByDesc('date')
            ->values(); // Reset keys

        // --------------------------Untuk perbandingan alocasi ex -----------------------

        // Ambil data kategori dengan relasi allocation dan expenses
        $categories = Category::with(['allocation', 'expenses' => function ($query) use ($year, $month) {
            // Filter expenses berdasarkan tahun dan bulan
            $query->whereYear('date', $year)
                ->whereMonth('date', $month);
        }])
            ->where('user_id', $user->id)
            ->get();

        // Ambil data kategori dengan relasi allocation dan expenses
        $categories = Category::with(['allocation', 'expenses' => function ($query) use ($year, $month) {
            // Filter expenses berdasarkan tahun dan bulan
            $query->whereYear('date', $year)
                ->whereMonth('date', $month);
        }])
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->get();

        // Hitung total alokasi, aktual, dan selisih
        $report = $categories->map(function ($category) use ($year, $month, $user) {
            // Format date menjadi YYYY-MM
            $date = sprintf('%04d-%02d', $year, $month); // Memastikan format YYYY-MM

            // Filter allocation berdasarkan tahun dan bulan (format string YYYY-MM)
            $alokasi = $category->allocation()
                ->where('user_id', $user->id)
                ->where('date', $date) // Filter berdasarkan format YYYY-MM
                ->value('amount') ?? 0; // Ambil nilai amount, default ke 0 jika tidak ada

            // Aktual diambil dari expenses yang sudah difilter
            $aktual = $category->expenses ? $category->expenses->sum('amount') : 0;
            // Hitung selisih
            $selisih = $aktual - $alokasi;

            // -------------------Untuk perbandingan alocasi in------------------------------------------

            return [
                'name' => $category->name,
                'alokasi' => $alokasi,
                'aktual' => $aktual,
                'selisih' => $selisih,
            ];
        });
        // Ambil data kategori dengan relasi allocation dan expenses
        $sources = Source::with(['allocationIn', 'income' => function ($query) use ($year, $month) {
            // Filter expenses berdasarkan tahun dan bulan
            $query->whereYear('date', $year)
                ->whereMonth('date', $month);
        }])
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->get();

        // Hitung total alokasi, aktual, dan selisih
        $reportIn = $sources->map(function ($source) use ($year, $month, $user) {
            // Format date menjadi YYYY-MM
            $date = sprintf('%04d-%02d', $year, $month); // Memastikan format YYYY-MM

            // Filter allocation berdasarkan tahun dan bulan (format string YYYY-MM)
            $alokasi = $source->allocationIn()
                ->where('user_id', $user->id)
                ->where('date', $date) // Filter berdasarkan format YYYY-MM
                ->value('amount') ?? 0; // Ambil nilai amount, default ke 0 jika tidak ada

            // Aktual diambil dari expenses yang sudah difilter
            $aktual = $source->income ? $source->income->sum('amount') : 0;
            // Hitung selisih
            $selisih = $aktual - $alokasi;


            // -------------------Untuk------------------------------------------

            return [
                'name' => $source->name,
                'alokasi' => $alokasi,
                'aktual' => $aktual,
                'selisih' => $selisih,
            ];
        });


        // dd($reportIn);

        // Kirim data ke frontend
        return Inertia::render('Menu/Laporan', [
            'report' => [
                'total_expenses' => $totalExpenses,
                'total_income' => $totalIncome,
                'total_savings' => $totalSavings,
                'net_balance' => $netBalance,
                'transactions' => $transactions,
                'report' => $report,
                'reportIn' => $reportIn,
            ],
        ]);
    }
}
