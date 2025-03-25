<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas\Expenses;
use App\Http\Controllers\Controller;
use App\Models\Aktivitas\Income;
use App\Models\Assets\Saving;
use App\Models\Financial\Bill;
use App\Models\Financial\Debt;
use App\Models\Financial\Loan;
use App\Models\MasterData\AccountBank;
use App\Models\MasterData\Category;
use App\Models\MasterData\Debit;
use App\Models\MasterData\Source;
use App\Models\MasterData\SubCategory;
use App\Models\MasterData\SubSource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $excludedNames = ['Fund Transfer']; // Nama-nama kategori yang ingin dikecualikan
        $expenses = Expenses::where('user_id', Auth::id())
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->with(['category', 'subCategory', 'accountBank'])
            ->whereHas('category', function ($query) use ($excludedNames) {
                $query->whereNotIn('name', $excludedNames);
            })
            ->latest()
            ->get();

        $categories = Category::where('user_id', Auth::id())
            ->where('name', '!=', 'Fund Transfer')
            ->get();
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

        // Ambil data Bills untuk dijadikan referensi amount
        $bills = Bill::where('user_id', Auth::id())->get();
        // Ambil data Debt untuk dijadikan referensi amount
        $debts  = Debt::where('user_id', Auth::id())->get();

        return inertia('Aktivitas/Expense/Index', [
            'expenses' => $expenses,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'accountBanks' => $accountBanks,
            'savingSubCategories' => $savingSubCategories,
            'settings' => $settings,
            'bills' => $bills, // Kirim data bills ke frontend
            'debts ' => $debts, // Kirim data Debt ke frontend
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
    //         'sub_kategori_id' => 'required|exists:sub_categories,id',
    //         'payment' => 'required|in:Transfer,Tunai',
    //         'account_id' => 'nullable',
    //     ], [
    //         'date.required' => 'Tanggal wajib diisi.',
    //         'date.date' => 'Format tanggal tidak valid.',
    //         'amount.required' => 'Nominal uang wajib diisi.',
    //         'amount.numeric' => 'Nominal uang harus berupa angka.',
    //         'amount.min' => 'Nominal uang tidak boleh negatif.',
    //         'category_id.required' => 'Kategori wajib dipilih.',
    //         'category_id.exists' => 'Kategori yang dipilih tidak valid.',
    //         'sub_kategori_id.required' => 'Sub kategori wajib dipilih.',
    //         'sub_kategori_id.exists' => 'Sub kategori yang dipilih tidak valid.',
    //         'payment.required' => 'Metode pembayaran wajib dipilih.',
    //         'payment.in' => 'Metode pembayaran hanya boleh "Transfer" atau "Tunai".'
    //     ]);

    //     try {
    //         DB::beginTransaction();

    //         $settings = Setting::where('user_id', Auth::id())->first();
    //         $accountId = $request->payment === 'Tunai' ? null : $request->account_id;

    //         $category = Category::where('id', $request->category_id)
    //             ->where('is_active', true)
    //             ->where('user_id', Auth::id())
    //             ->firstOrFail();

    //         if (str_starts_with($request->account_id, 'subcategory_')) {
    //             if (!$settings || !$settings->account_id) {
    //                 throw new \Exception('Bank untuk tabungan belum dipilih. Silakan pilih bank terlebih dahulu di pengaturan.');
    //             }

    //             $subCategoryId = (int) str_replace('subcategory_', '', $request->account_id);
    //             $neoBankId = $settings->account_id;

    //             $savingLast = Saving::where('user_id', Auth::id())
    //                 ->where('sub_category_id', $subCategoryId)
    //                 ->latest()
    //                 ->first();

    //             if (!$savingLast) {
    //                 throw new \Exception("Data " . $savingLast->subCategory->name . " Belum tersedia.");
    //             }

    //             if ($request->amount > $savingLast->balance) {
    //                 throw new \Exception("Saldo " . $savingLast->subCategory->name . " Tidak cukup.");
    //             }

    //             $balance = $savingLast->balance - $request->amount;

    //             Saving::create([
    //                 'user_id' => Auth::id(),
    //                 'date' => $request->date,
    //                 'amount' => -$request->amount,
    //                 'note' => 'Pengeluaran dari Saving',
    //                 'category_id' => $request->category_id,
    //                 'sub_category_id' => $subCategoryId,
    //                 'balance' => $balance,
    //             ]);

    //             $accountId = $neoBankId;
    //         } elseif (str_starts_with($request->account_id, 'account_')) {
    //             $accountId = (int) str_replace('account_', '', $request->account_id);
    //         }

    //         if ($category->name == "Saving (Tabungan)") {
    //             if (!$settings || !$settings->account_id) {
    //                 throw new \Exception('Bank untuk tabungan belum dipilih. Silakan pilih bank terlebih dahulu di pengaturan.');
    //             }

    //             $lastSaving = Saving::where('user_id', Auth::id())
    //                 ->where('category_id', $request->category_id)
    //                 ->where('sub_category_id', $request->sub_kategori_id)
    //                 ->latest()
    //                 ->first();

    //             $lastBalance = $lastSaving ? $lastSaving->balance : 0;
    //             $balance = $lastBalance + $request->amount;

    //             Saving::create([
    //                 'user_id' => Auth::id(),
    //                 'date' => $request->date,
    //                 'amount' => $request->amount,
    //                 'note' => 'Pemasukan dari Expenses',
    //                 'category_id' => $request->category_id,
    //                 'sub_category_id' => $request->sub_kategori_id,
    //                 'balance' => $balance,
    //             ]);
    //         }
    //         // Cek apakah sub_category_id ada di Debt
    //         $debt = Debt::where('sub_category_id', $request->sub_kategori_id)
    //             ->where('user_id', Auth::id())
    //             ->first();

    //         if ($debt) {
    //             $debIs_active = SubCategory::find($request->sub_kategori_id);
    //             if ($debt->type == 'personal') {
    //                 $debt->amount -= $request->amount;
    //                 $debt->paid_amount += $request->amount;
    //                 if ($debt->amount <= 0) {
    //                     $debt->status = 'Paid';

    //                     // Untuk update subcategory
    //                     $debIs_active->is_active = false;
    //                     $debIs_active->update();
    //                 }
    //                 $debt->save();
    //             } elseif ($debt->type == 'installment') {
    //                 // Ambil total expenses berdasarkan sub_kategori_id dan user_id
    //                 $totalExpenses = Expenses::where('sub_kategori_id', $request->sub_kategori_id)
    //                     ->where('user_id', Auth::id())
    //                     ->count();

    //                 // Periksa apakah totalExpenses sudah sama dengan tenor_month
    //                 if ($totalExpenses + 1 >= $debt->tenor_months) {
    //                     // Jika sama, update status hutang menjadi "Paid"
    //                     $debt->status = 'Paid';

    //                     // Nonaktifkan subkategori terkait
    //                     $debIs_active->is_active = false;
    //                     $debIs_active->update();
    //                 }
    //                 $debt->paid_amount += $request->amount;
    //                 $debt->save();
    //             }
    //         }


    //         if ($accountId) {
    //             $saldo = AccountBank::find($accountId);

    //             if ($request->amount > $saldo->amount) {
    //                 throw new \Exception("Saldo " . $saldo->name . " (Rp. " . number_format($saldo->amount) . ") Tidak cukup.");
    //             }

    //             if ($accountId == $settings->account_id) {

    //                 // Ambil kategori tabungan berdasarkan user_id yang login
    //                 $savingCategory = Category::where('user_id', Auth::id())
    //                     ->where('name', 'Saving (Tabungan)')
    //                     ->first();

    //                 if (!$savingCategory) {
    //                     return redirect()->back()->with('error', 'Tabungan harus ditambahkan dengan cara diaktifkan terlebih dahulu.');
    //                 }

    //                 if ($savingCategory) {
    //                     $subCategories = SubCategory::where('category_id', $savingCategory->id)
    //                         ->pluck('id'); // Mengambil hanya ID dalam bentuk array

    //                     // Ambil transaksi terbaru untuk setiap sub_category_id
    //                     $latestTransactions = Saving::whereIn('sub_category_id', $subCategories)
    //                         ->where('user_id', Auth::id())
    //                         ->orderBy('sub_category_id') // Urutkan berdasarkan sub_category_id
    //                         ->orderByDesc('created_at') // Urutkan terbaru berdasarkan waktu
    //                         ->get()
    //                         ->unique('sub_category_id'); // Ambil hanya satu transaksi terbaru dari setiap sub_category_id

    //                     // Hitung total amount dari transaksi terbaru masing-masing sub_category
    //                     $totalSavingAmount = $latestTransactions->sum('balance');
    //                 }

    //                 $saldoBank = $saldo->amount - $totalSavingAmount;

    //                 if ($request->amount > $saldoBank) {
    //                     throw new \Exception("Saldo " . $saldo->name . " yang Free (Rp. " . number_format($saldoBank) . ") Tidak cukup.");
    //                 }
    //             }
    //         }

    //         Expenses::create([
    //             'user_id' => Auth::id(),
    //             'date' => $request->date,
    //             'amount' => $request->amount,
    //             'category_id' => $request->category_id,
    //             'sub_kategori_id' => $request->sub_kategori_id,
    //             'payment' => $request->payment,
    //             'account_id' => $accountId,
    //         ]);

    //         if ($request->payment === 'Tunai') {
    //             $latestDebit = Debit::where('user_id', Auth::id())->latest()->first();
    //             $balance = $latestDebit ? $latestDebit->balance : 0;
    //             $amount = -abs($request->amount);

    //             if (abs($amount) > $balance) {
    //                 throw new \Exception('Saldo Tunai tidak cukup, tersisa Rp ' . number_format($balance, 2, ',', '.'));
    //             }

    //             $subCategoryTunai = SubCategory::find($request->sub_kategori_id);
    //             $categoryTunai = Category::find($request->category_id);

    //             Debit::create([
    //                 'user_id' => Auth::id(),
    //                 'amount' => $amount,
    //                 'type' => 'Expense',
    //                 'note' => $categoryTunai->name . " untuk " . $subCategoryTunai->name,
    //                 'balance' => $balance + $amount,
    //             ]);
    //         }

    //         if ($accountId) {
    //             $amountBank = AccountBank::find($accountId);
    //             $amountBank->amount -= $request->amount;
    //             $amountBank->update();

    //             if ($category->name == "Saving (Tabungan)" && $settings && $settings->account_id) {
    //                 $savingAccount = AccountBank::find($settings->account_id);
    //                 $savingAccount->amount += $request->amount;
    //                 $savingAccount->update();
    //             }
    //         }

    //         DB::commit();
    //         return redirect()->back()->with('success', 'Transaksi berhasil disimpan.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'nullable|date',
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'sub_kategori_id' => 'required', // Sub kategori bisa berupa ID atau nama (jika kategori adalah "Loan (Pinjaman)")
            'payment' => 'required|in:Transfer,Tunai',
            'account_id' => 'nullable',
            'description' => 'nullable',
        ], [
            'date.required' => 'Tanggal wajib diisi.',
            'date.date' => 'Format tanggal tidak valid.',
            'amount.required' => 'Nominal uang wajib diisi.',
            'amount.numeric' => 'Nominal uang harus berupa angka.',
            'amount.min' => 'Nominal uang tidak boleh negatif.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'sub_kategori_id.required' => 'Sub kategori wajib diisi.',
            'payment.required' => 'Metode pembayaran wajib dipilih.',
            'payment.in' => 'Metode pembayaran hanya boleh "Transfer" atau "Tunai".'
        ]);

        try {
            DB::beginTransaction();

            $settings = Setting::where('user_id', Auth::id())->first();
            $accountId = $request->payment === 'Tunai' ? null : $request->account_id;

            $category = Category::where('id', $request->category_id)
                ->where('is_active', true)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Jika kategori adalah "Loan (Pinjaman)", buat sub kategori baru dan data loan
            // if ($category->name == "Loan (Pinjaman)") {
            //     // Buat sub kategori baru
            //     $subCategory = SubCategory::create([
            //         'category_id' => $request->category_id,
            //         'name' => $request->sub_kategori_id, // sub_kategori_id berisi nama dari input text
            //         'is_active' => true,
            //         'user_id' => Auth::id(),
            //     ]);

            //     // Buat data loan baru
            //     $loan = Loan::create([
            //         'name' => $request->sub_kategori_id, // Nama loan sama dengan nama sub kategori
            //         'sub_category_id' => $subCategory->id,
            //         'amount' => $request->amount,
            //         'status' => 'active',
            //         'user_id' => Auth::id(),
            //     ]);

            //     // Set sub_kategori_id untuk expenses
            //     $request->merge(['sub_kategori_id' => $subCategory->id]);
            // }
            $date = $request->date ?? now()->toDateString();

            if ($category->name == "Loan (Pinjaman)") {
                // Cari atau buat Source dengan nama "Loan (Pinjaman)"
                $source = Source::firstOrCreate(
                    ['name' => 'Loan (Pinjaman)', 'user_id' => Auth::id()],
                    ['is_active' => true]
                );

                // Buat sub kategori baru
                $subCategory = SubCategory::create([
                    'category_id' => $request->category_id,
                    'name' => $request->sub_kategori_id, // sub_kategori_id berisi nama dari input text
                    'is_active' => true,
                    'user_id' => Auth::id(),
                ]);

                // Buat sub source baru
                $subSource = SubSource::create([
                    'source_id' => $source->id,
                    'name' => $request->sub_kategori_id, // sub_kategori_id berisi nama dari input text
                    'is_active' => true,
                    'user_id' => Auth::id(),
                ]);

                // Buat data loan baru
                $loan = Loan::create([
                    'name' => $request->sub_kategori_id, // Nama loan sama dengan nama sub kategori
                    'sub_category_id' => $subCategory->id,
                    'amount' => $request->amount,
                    'status' => 'active',
                    'user_id' => Auth::id(),
                ]);

                // Set sub_kategori_id untuk expenses
                $request->merge(['sub_kategori_id' => $subCategory->id]);
            }

            // Lanjutkan proses seperti biasa
            if (str_starts_with($request->account_id, 'subcategory_')) {
                if (!$settings || !$settings->account_id) {
                    throw new \Exception('Bank untuk tabungan belum dipilih. Silakan pilih bank terlebih dahulu di pengaturan.');
                }

                $subCategoryId = (int) str_replace('subcategory_', '', $request->account_id);
                $neoBankId = $settings->account_id;

                $savingLast = Saving::where('user_id', Auth::id())
                    ->where('sub_category_id', $subCategoryId)
                    ->latest()
                    ->first();

                if (!$savingLast) {
                    throw new \Exception("Data " . $savingLast->subCategory->name . " Belum tersedia.");
                }

                if ($request->amount > $savingLast->balance) {
                    throw new \Exception("Saldo " . $savingLast->subCategory->name . " Tidak cukup.");
                }

                $balance = $savingLast->balance - $request->amount;

                Saving::create([
                    'user_id' => Auth::id(),
                    'date' => $date,
                    'amount' => -$request->amount,
                    'note' => 'Pengeluaran dari Saving',
                    'category_id' => $request->category_id,
                    'sub_category_id' => $subCategoryId,
                    'balance' => $balance,
                ]);

                $accountId = $neoBankId;
            } elseif (str_starts_with($request->account_id, 'account_')) {
                $accountId = (int) str_replace('account_', '', $request->account_id);
            }

            if ($category->name == "Saving (Tabungan)") {
                if (!$settings || !$settings->account_id) {
                    throw new \Exception('Bank untuk tabungan belum dipilih. Silakan pilih bank terlebih dahulu di pengaturan.');
                }

                $lastSaving = Saving::where('user_id', Auth::id())
                    ->where('category_id', $request->category_id)
                    ->where('sub_category_id', $request->sub_kategori_id)
                    ->latest()
                    ->first();

                $lastBalance = $lastSaving ? $lastSaving->balance : 0;
                $balance = $lastBalance + $request->amount;

                Saving::create([
                    'user_id' => Auth::id(),
                    'date' => $date,
                    'amount' => $request->amount,
                    'note' => 'Pemasukan dari Expenses',
                    'category_id' => $request->category_id,
                    'sub_category_id' => $request->sub_kategori_id,
                    'balance' => $balance,
                ]);


                if ($category && $category->name === 'Saving (Tabungan)') {
                    // 3. Cari source dengan name yang sama dengan category
                    $source = Source::where('name', $category->name)->first();

                    if ($source) {
                        $sub_category = SubCategory::Find($request->sub_kategori_id);
                        // Gunakan getOriginal() untuk mendapatkan nama sebelum diupdate
                        $originalName = $sub_category->name;
                        // Cari sub source berdasarkan nama sebelum diubah
                        $subSource = SubSource::where('name', $originalName)
                            ->where('source_id', $source->id)
                            ->first();

                        // Jika sub source tidak ditemukan, buat baru
                        if (!$subSource) {
                            throw new \Exception("Sub Source Belum Ada di data , Tambahkan dulu data nya .");
                        }

                        // Simpan data Income
                        Income::create([
                            'user_id' => Auth::id(),
                            'date' => $date,
                            'amount' => $request->amount,
                            'source_id' => $source->id,
                            'sub_source_id' => $subSource->id,
                            'description' => $request->description,
                            'payment' => $request->payment,
                            'account_id' =>  $settings->account_id,
                        ]);
                    }
                }
            }

            // Cek apakah sub_category_id ada di Debt
            $debt = Debt::where('sub_category_id', $request->sub_kategori_id)
                ->where('user_id', Auth::id())
                ->first();

            if ($debt) {
                $debIs_active = SubCategory::find($request->sub_kategori_id);
                if ($debt->type == 'personal') {
                    $debt->amount -= $request->amount;
                    $debt->paid_amount += $request->amount;
                    if ($debt->amount <= 0) {
                        $debt->status = 'Paid';

                        // Untuk update subcategory
                        $debIs_active->is_active = false;
                        $debIs_active->update();
                    }
                    $debt->save();
                } elseif ($debt->type == 'installment') {
                    // Ambil total expenses berdasarkan sub_kategori_id dan user_id
                    $totalExpenses = Expenses::where('sub_kategori_id', $request->sub_kategori_id)
                        ->where('user_id', Auth::id())
                        ->count();

                    // Periksa apakah totalExpenses sudah sama dengan tenor_month
                    if ($totalExpenses + 1 >= $debt->tenor_months) {
                        // Jika sama, update status hutang menjadi "Paid"
                        $debt->status = 'Paid';

                        // Nonaktifkan subkategori terkait
                        $debIs_active->is_active = false;
                        $debIs_active->update();
                    }
                    $debt->paid_amount += $request->amount;
                    $debt->save();
                }
            }

            if ($accountId) {
                $saldo = AccountBank::find($accountId);

                if ($request->amount > $saldo->amount) {
                    throw new \Exception("Saldo " . $saldo->name . " (Rp. " . number_format($saldo->amount) . ") Tidak cukup.");
                }

                if ($accountId == $settings->account_id) {

                    // Ambil kategori tabungan berdasarkan user_id yang login
                    $savingCategory = Category::where('user_id', Auth::id())
                        ->where('name', 'Saving (Tabungan)')
                        ->first();

                    if (!$savingCategory) {
                        return redirect()->back()->with('error', 'Tabungan harus ditambahkan dengan cara diaktifkan terlebih dahulu.');
                    }

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
                    }

                    $saldoBank = $saldo->amount - $totalSavingAmount;

                    if ($request->amount > $saldoBank) {
                        throw new \Exception("Saldo " . $saldo->name . " yang Free (Rp. " . number_format($saldoBank) . ") Tidak cukup.");
                    }
                }
            }


            // Simpan data ke expenses
            Expenses::create([
                'user_id' => Auth::id(),
                'date' => $date,
                'amount' => $request->amount,
                'category_id' => $request->category_id,
                'sub_kategori_id' => $request->sub_kategori_id,
                'description' => $request->description,
                'payment' => $request->payment,
                'account_id' => $accountId,
            ]);

            if ($request->payment === 'Tunai') {
                $latestDebit = Debit::where('user_id', Auth::id())->latest()->first();
                $balance = $latestDebit ? $latestDebit->balance : 0;
                $amount = -abs($request->amount);

                if (abs($amount) > $balance) {
                    throw new \Exception('Saldo Tunai tidak cukup, tersisa Rp ' . number_format($balance, 2, ',', '.'));
                }

                $subCategoryTunai = SubCategory::find($request->sub_kategori_id);
                $categoryTunai = Category::find($request->category_id);

                Debit::create([
                    'user_id' => Auth::id(),
                    'amount' => $amount,
                    'type' => 'Expense',
                    'note' => $categoryTunai->name . " untuk " . $subCategoryTunai->name,
                    'balance' => $balance + $amount,
                ]);
            }

            if ($accountId) {
                $amountBank = AccountBank::find($accountId);
                $amountBank->amount -= $request->amount;
                $amountBank->update();

                if ($category->name == "Saving (Tabungan)" && $settings && $settings->account_id) {
                    $savingAccount = AccountBank::find($settings->account_id);
                    $savingAccount->amount += $request->amount;
                    $savingAccount->update();
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
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
            'account_id' => 'nullable', // Bisa null jika payment adalah "Tunai"
            'description' => 'nullable',
        ]);

        // Jika payment adalah "Tunai", set account_id ke null
        $settings = Setting::where('user_id', Auth::id())->first();
        $accountId = $request->payment === 'Tunai' ? null : $request->account_id;

        // Lanjutkan proses seperti biasa
        if (str_starts_with($request->account_id, 'subcategory_')) {
            if (!$settings || !$settings->account_id) {
                throw new \Exception('Bank untuk tabungan belum dipilih. Silakan pilih bank terlebih dahulu di pengaturan.');
            }

            $subCategoryId = (int) str_replace('subcategory_', '', $request->account_id);
            $neoBankId = $settings->account_id;

            $accountId = $neoBankId;
        } elseif (str_starts_with($request->account_id, 'account_')) {
            $accountId = (int) str_replace('account_', '', $request->account_id);
        }

        $date = $request->date ?? now()->toDateString();

        $expense->update([
            'user_id' => Auth::id(),
            'date' => $date,
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'sub_kategori_id' => $request->sub_kategori_id,
            'description' => $request->description,
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