<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas\Expenses;
use App\Http\Controllers\Controller;
use App\Models\Assets\Saving;
use App\Models\MasterData\AccountBank;
use App\Models\MasterData\Category;
use App\Models\MasterData\Debit;
use App\Models\MasterData\SubCategory;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $settings = Setting::where('user_id', Auth::id())->first();
        $year = $request->input('year', date('Y')); // Default: Tahun saat ini
        $month = $request->input('month', date('m')); // Default: Bulan saat ini

        $expenses = Expenses::where('user_id', Auth::id())
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->with(['category', 'subCategory', 'accountBank'])
            ->get();

        $categories = Category::where('user_id', Auth::id())->get();
        $subCategories = SubCategory::all();
        $accountBanks = AccountBank::where('user_id', Auth::id())->get();

        // Ambil data SubCategory berdasarkan kategori Saving (jika saving_expense aktif)
        $savingSubCategories = [];
        if ($settings && $settings->saving_expense) {
            $savingCategory = Category::where('name', 'Saving (Tabungan)')
                ->where('user_id', Auth::id())
                ->first();

            if ($savingCategory) {
                $savingSubCategories = SubCategory::where('category_id', $savingCategory->id)
                    ->get();
            }
        }

        return inertia('Aktivitas/Expense/Index', [
            'expenses' => $expenses,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'accountBanks' => $accountBanks,
            'savingSubCategories' => $savingSubCategories,
            'settings' => $settings,
            'filters' => [
                'year' => $year,
                'month' => $month,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'date' => 'required|date',
    //         'amount' => 'required|numeric|min:0',
    //         'category_id' => 'required|exists:categories,id',
    //         'sub_kategori_id' => 'nullable|exists:sub_categories,id',
    //         'payment' => 'required|in:Transfer,Tunai', // Hanya menerima "Transfer" atau "Tunai"
    //         'account_id' => 'nullable', // Bisa null jika payment adalah "Tunai" atau memilih SubCategory
    //     ]);

    //     // Jika payment adalah "Tunai", set account_id ke null
    //     $accountId = $request->payment === 'Tunai' ? null : $request->account_id;

    //     // Jika memilih SubCategory (nilai account_id diawali dengan "subcategory_")
    //     $category = Category::where('id', $request->category_id)->where('user_id', Auth::id())->first();

    //     if (str_starts_with($request->account_id, 'subcategory_') && $category->name "Saving (Tabungan)") {
    //         // Ambil ID SubCategory
    //         $subCategoryId = (int) str_replace('subcategory_', '', $request->account_id);

    //         $saving_account = Setting::where('user_id', Auth::id())->first();

    //         // Simpan data ke tabel savings
    //         $lastSaving = Saving::where('user_id', Auth::id())->latest()->first();
    //         if ($category->name "Saving (Tabungan)") {
    //             $balance = $lastSaving ? $lastSaving->balance + $request->amount : $request->amount;
    //         }
    //         if (str_starts_with($request->account_id, 'subcategory_')) {
    //             $balance = $lastSaving ? $lastSaving->balance - $request->amount : -$request->amount;
    //         }

    //         Saving::create([
    //             'user_id' => Auth::id(),
    //             'date' => $request->date,
    //             'amount' => -$request->amount, // Amount bernilai negatif (uang keluar)
    //             'note' => 'Pengeluaran dari SubCategory',
    //             'category_id' => $request->category_id,
    //             'sub_category_id' => $subCategoryId,
    //             'balance' => $balance,
    //         ]);

    //         // Set account_id ke ID Neo Bank
    //         $accountId = $saving_account->account_id;
    //     } elseif (str_starts_with($request->account_id, 'account_')) {
    //         // Jika memilih AccountBank, ambil ID murni
    //         $accountId = (int) str_replace('account_', '', $request->account_id);
    //     }

    //     // Simpan data ke tabel expenses
    //     Expenses::create([
    //         'user_id' => Auth::id(),
    //         'date' => $request->date,
    //         'amount' => $request->amount,
    //         'category_id' => $request->category_id,
    //         'sub_kategori_id' => $request->sub_kategori_id,
    //         'payment' => $request->payment,
    //         'account_id' => $accountId, // Gunakan nilai yang sudah diproses
    //     ]);

    //     // Jika account_id ada (baik dari AccountBank atau Neo Bank), perbarui amount di AccountBank

    //     if ($accountId) {
    //         $amountBank = AccountBank::find($accountId);
    //         $amountBank->amount -= $request->amount;
    //         $amountBank->update();

    //         if ($category->name "Saving (Tabungan)") {
    //             $amountSaving = AccountBank::find($accountId);
    //             $amountSaving->amount += $request->amount;
    //             $amountSaving->update();
    //         }
    //     }

    //     return redirect()->route('expense.index')->with('success', 'Pengeluaran berhasil ditambahkan.');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'sub_kategori_id' => 'nullable|exists:sub_categories,id',
            'payment' => 'required|in:Transfer,Tunai', // Hanya menerima "Transfer" atau "Tunai"
            'account_id' => 'nullable', // Bisa null jika payment adalah "Tunai" atau memilih SubCategory
        ]);

        // Ambil data settings untuk user yang sedang login
        $settings = Setting::where('user_id', Auth::id())->first();

        // Jika payment adalah "Tunai", set account_id ke null
        $accountId = $request->payment === 'Tunai' ? null : $request->account_id;

        // Ambil data kategori
        $category = Category::where('id', $request->category_id)
            ->where('is_active', true)
            ->where('user_id', Auth::id())
            ->first();

        // Jika memilih SubCategory (nilai account_id diawali dengan "subcategory_")
        if (str_starts_with($request->account_id, 'subcategory_')) {

            // Cek apakah account_id di settings sudah dipilih
            if (!$settings || !$settings->account_id) {
                return redirect()->back()->with('error', 'Bank untuk tabungan belum dipilih. Silakan pilih bank terlebih dahulu di pengaturan.');
            }
            // Ambil ID SubCategory
            $subCategoryId = (int) str_replace('subcategory_', '', $request->account_id);

            // Ambil account_id dari settings
            $neoBankId = $settings->account_id;

            // Simpan data ke tabel savings
            $savingLast = Saving::where('user_id', Auth::id())
                ->where('sub_category_id', $subCategoryId)
                ->latest()
                ->first();

            $subCategoryName = $savingLast->subCategory->name; // Ambil nama sub kategori

            // Jika tidak ada data savingLast, tampilkan alert bahwa tabungan belum tersedia
            if (!$savingLast) {
                return back()->with('error', "Data $subCategoryName Belum tersedia.");
            }

            // Jika amount lebih besar dari savingLast->balance, tampilkan alert bahwa saldo tidak cukup
            if ($request->amount > $savingLast->balance) {
                return back()->with('error', "Saldo $subCategoryName Tidak cukup.");
            }

            // Jika amount kurang dari atau sama dengan savingLast->balance, lanjutkan proses pengurangan dan simpan data
            $balance = $savingLast->balance - $request->amount;

            Saving::create([
                'user_id' => Auth::id(),
                'date' => $request->date,
                'amount' => -$request->amount, // Amount bernilai negatif (uang keluar)
                'note' => 'Pengeluaran dari Saving',
                'category_id' => $request->category_id,
                'sub_category_id' => $subCategoryId,
                'balance' => $balance,
            ]);

            // Set account_id ke ID dari settings
            $accountId = $neoBankId;
        } elseif (str_starts_with($request->account_id, 'account_')) {
            // Jika memilih AccountBank, ambil ID murni
            $accountId = (int) str_replace('account_', '', $request->account_id);
        }

        if ($category->name == "Saving (Tabungan)") {
            // Cek apakah account_id di settings sudah dipilih
            if (!$settings || !$settings->account_id) {
                return redirect()->back()->with('error', 'Bank untuk tabungan belum dipilih. Silakan pilih bank terlebih dahulu di pengaturan.');
            }

            // Simpan data ke tabel savings
            $lastSaving = Saving::where('user_id', Auth::id())
                ->where('category_id', $request->category_id)
                ->where('sub_category_id', $request->sub_kategori_id)
                ->latest()
                ->first();

            // Jika $lastSaving tidak ada, set balance ke 0
            $lastBalance = $lastSaving ? $lastSaving->balance : 0;

            // Hitung balance baru
            $balance = $lastBalance + $request->amount;

            Saving::create([
                'user_id' => Auth::id(),
                'date' => $request->date,
                'amount' => $request->amount, // Amount bernilai negatif (uang keluar)
                'note' => 'Pemasukan dari Expenses',
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_kategori_id,
                'balance' => $balance,
            ]);
        }

        if ($accountId) {
            // Ambil ID kategori "Saving"
            $savingCategory = Category::where('user_id', Auth::id())
                ->where('name', 'Saving (Tabungan)')->first();

            // Ambil semua sub_category berdasarkan category_id yang telah ditemukan
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
            $totalBalance = $latestTransactions->sum('balance');

            $saldo = AccountBank::find($accountId);
            // Jika amount lebih besar dari savingLast->balance, tampilkan alert bahwa saldo tidak cukup
            if ($request->amount > $saldo->amount) {
                $Rpalert = number_format($saldo->amount);
                return back()->with('error', "Saldo $saldo->name (Rp. $Rpalert) Tidak cukup.");
            }
            // Cek apakah id account sama dengan account_id di setting jika sama maka saldo yang bisa di pakai adalah sisa dari pengurangan saldo saving
            if ($accountId == $settings->account_id) {
                $saldoBank = $saldo->amount - $totalBalance;
                if ($request->amount > $saldoBank) {
                    $Rp = number_format($saldoBank);
                    return back()->with('error', "Saldo $saldo->name yang Free (Rp. $Rp) Tidak cukup, karena Saldo yang ada adalah saldo Saving (Tabungan).");
                }
            }
        }
        // Simpan data ke tabel expenses
        Expenses::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'sub_kategori_id' => $request->sub_kategori_id,
            'payment' => $request->payment,
            'account_id' => $accountId, // Gunakan nilai yang sudah diproses
        ]);

        if ($request->payment === 'Tunai') {
            $latestDebit = Debit::where('user_id', Auth::id())->latest()->first();
            $balance = $latestDebit ? $latestDebit->balance : 0;
            $amount = -abs($request->amount);

            if (abs($amount) > $balance) {
                return redirect()->back()->with(
                    'error',
                    'Saldo Tunai tidak cukup, tersisa Rp ' . number_format($balance, 2, ',', '.')
                );
            }

            $subCategoryTunai = SubCategory::find($request->sub_kategori_id);
            $categoryTunai = Category::find($request->category_id);
            $note = $categoryTunai->name . " untuk " . $subCategoryTunai->name;

            $debit = new Debit();
            $debit->user_id = Auth::id();
            $debit->amount = $amount;
            $debit->type = 'Expense';
            $debit->note =  $note;
            $debit->balance = $balance + $amount; // Mengurangi saldo
            $debit->save();
        }

        // Jika account_id ada (baik dari AccountBank atau Neo Bank), perbarui amount di AccountBank
        if ($accountId) {
            $amountBank = AccountBank::find($accountId);
            $amountBank->amount -= $request->amount;
            $amountBank->update();

            // Jika kategori adalah "Saving", tambahkan amount ke account_id di settings
            if ($category->name == "Saving (Tabungan)" && $settings && $settings->account_id) {
                $savingAccount = AccountBank::find($settings->account_id);
                $savingAccount->amount += $request->amount;
                $savingAccount->update();
            }
        }

        return redirect()->route('expense.index')->with('success', 'Pengeluaran berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Expenses $expenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expenses $expenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expenses $expense)
    {
        // Validasi input
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'sub_kategori_id' => 'nullable|exists:sub_categories,id',
            'payment' => 'required|in:Transfer,Tunai', // Hanya menerima "Transfer" atau "Tunai"
            'account_id' => 'nullable|exists:account_banks,id', // Bisa null jika payment adalah "Tunai"
        ]);

        // Jika payment adalah "Tunai", set account_id ke null
        $accountId = $request->payment === 'Tunai' ? null : $request->account_id;

        $expense->update([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'sub_kategori_id' => $request->sub_kategori_id,
            'payment' => $request->payment,
            'account_id' => $accountId, // Gunakan nilai yang sudah diproses
        ]);

        logger('Flash message: Tabungan Belum tersedia.'); // Log pesan
        return redirect()->route('expense.index')->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenses $expense)
    {
        // Pastikan pengeluaran milik pengguna yang sedang login
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus pengeluaran
        $expense->delete();

        return redirect()->back()->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
