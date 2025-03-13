<?php

namespace App\Http\Controllers\MasterData;

use App\Models\MasterData\AccountBank;
use App\Http\Controllers\Controller;
use App\Models\Assets\Saving;
use App\Models\MasterData\Category;
use App\Models\MasterData\Debit;
use App\Models\MasterData\SubCategory;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class AccountBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::where('user_id', Auth::id())->first();
        // Ambil data rekening bank milik pengguna yang sedang login
        $accountBanks = AccountBank::where('user_id', Auth::id())->latest()->get();
        // Ambil saldo terbaru dari tabel Debit
        $latestDebit = Debit::where('user_id', Auth::id())->latest()->first();
        $cashBalance = $latestDebit ? $latestDebit->balance : 0;
        return inertia('MasterData/AccountBank/Index', [
            'accountBanks' => $accountBanks,
            'settings' => $settings,
            'cashBalance' => $cashBalance,

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
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('account_banks')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })
            ],
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Bank harus diisi.',
            'name.string' => 'Bank harus berupa teks.',
            'name.max' => 'Bank tidak boleh lebih dari 50 karakter.',
            'name.unique' => 'Bank ini sudah digunakan. Silakan pilih Bank lain.',

            'description.string' => 'Deskripsi harus berupa teks.',

            'amount.numeric' => 'Nominal harus berupa angka.',
            'amount.min' => 'Nominal tidak boleh kurang dari 0.',

            'is_active.boolean' => 'Status aktif harus berupa nilai benar atau salah.',
        ]);

        // Simpan rekening bank dengan user_id dari pengguna yang login
        $accountBank = AccountBank::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount ?? 0,
            'is_active' => $request->is_active ?? true, // Default true jika tidak diisi
        ]);

        return redirect()->back()->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountBank $accountBank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountBank $accountBank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountBank $accountBank)
    {

        // Pastikan rekening bank milik pengguna yang sedang login
        if ($accountBank->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        // Validasi input
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('account_banks')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })->ignore($accountBank->id), // Abaikan record dengan ID yang sedang diperbarui
            ],
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Bank harus diisi.',
            'name.string' => 'Bank harus berupa teks.',
            'name.max' => 'Bank tidak boleh lebih dari 50 karakter.',
            'name.unique' => 'Bank ini sudah digunakan. Silakan pilih Bank lain.',

            'description.string' => 'Deskripsi harus berupa teks.',

            'amount.numeric' => 'Nominal harus berupa angka.',
            'amount.min' => 'Nominal tidak boleh kurang dari 0.',

            'is_active.boolean' => 'Status aktif harus berupa nilai benar atau salah.',
        ]);

        // Simpan rekening bank dengan user_id dari pengguna yang login
        $accountBank->update([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount ?? 0,
            'is_active' => $request->is_active ?? true, // Default true jika tidak diisi
        ]);

        return redirect()->back()->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountBank $accountBank)
    {

        // Pastikan rekening bank milik pengguna yang sedang login
        if ($accountBank->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $accountBank->delete();
        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }

    public function mutation(AccountBank $accountBank)
    {
        // Pastikan rekening bank milik pengguna yang sedang login
        if ($accountBank->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil data log activity untuk rekening bank ini
        $activities = Activity::where('subject_type', AccountBank::class)
            ->where('subject_id', $accountBank->id)
            ->whereJsonContains('properties->attributes', ['amount' => $accountBank->amount])
            ->latest()
            ->get();

        return inertia('AccountBank/Mutation', [
            'accountBank' => $accountBank,
            'activities' => $activities,
        ]);
    }

    // public function withdraw(Request $request)
    // {
    //     $request->validate([
    //         'amount' => ['required', 'numeric', 'gt:0'],
    //         'note' => ['nullable', 'string'],
    //         'bank_id' => ['required', 'exists:account_banks,id'],
    //     ], [
    //         'amount.required' => 'Nominal harus diisi.',
    //         'amount.numeric' => 'Nominal harus berupa angka.',
    //         'amount.gt' => 'Nominal tidak boleh kurang dari 0.',

    //         'note.string' => 'Catatan harus berupa teks.',

    //         'bank_id.required' => 'Bank harus dipilih.',
    //         'bank_id.exists' => 'Bank yang dipilih tidak valid.',
    //     ]);

    //     if ($request->bank_id) {
    //         // Ambil data settings untuk user yang sedang login
    //         $settings = Setting::where('user_id', Auth::id())->first();
    //         if ($request->bank_id == $settings->account_id) {
    //             // Ambil ID kategori "Saving"
    //             $savingCategory = Category::where('user_id', Auth::id())
    //                 ->where('name', 'Saving (Tabungan)')->first();

    //             // Ambil semua sub_category berdasarkan category_id yang telah ditemukan
    //             $subCategories = SubCategory::where('category_id', $savingCategory->id)
    //                 ->pluck('id'); // Mengambil hanya ID dalam bentuk array

    //             // Ambil transaksi terbaru untuk setiap sub_category_id
    //             $latestTransactions = Saving::whereIn('sub_category_id', $subCategories)
    //                 ->where('user_id', Auth::id())
    //                 ->orderBy('sub_category_id') // Urutkan berdasarkan sub_category_id
    //                 ->orderByDesc('created_at') // Urutkan terbaru berdasarkan waktu
    //                 ->get()
    //                 ->unique('sub_category_id'); // Ambil hanya satu transaksi terbaru dari setiap sub_category_id

    //             // Hitung total amount dari transaksi terbaru masing-masing sub_category
    //             $totalBalance = $latestTransactions->sum('balance');

    //             $saldo = AccountBank::find($request->bank_id);
    //             // Cek apakah id account sama dengan account_id di setting jika sama maka saldo yang bisa di pakai adalah sisa dari pengurangan saldo saving

    //             $saldoBank = $saldo->amount - $totalBalance;
    //             if ($request->amount > $saldoBank) {
    //                 $Rp = number_format($saldoBank);
    //                 return back()->with('error', "Saldo $saldo->name yang Free (Rp. $Rp) Tidak cukup, karena Saldo yang ada adalah saldo Saving (Tabungan).");
    //             }
    //         }
    //     }

    //     // Ambil data rekening bank
    //     $bank = AccountBank::find($request->bank_id);

    //     // Cek apakah saldo mencukupi
    //     if ($bank->amount < $request->amount) {
    //         return back()->with('error', 'Saldo tidak mencukupi.');
    //     }

    //     // Kurangi saldo rekening bank
    //     $bank->amount -= $request->amount;
    //     $bank->save();

    //     // Tambahkan data ke tabel Debit
    //     $latestDebit = Debit::where('user_id', Auth::id())->latest()->first();
    //     $balance = $latestDebit ? $latestDebit->balance : 0;

    //     Debit::create([
    //         'user_id' => Auth::id(),
    //         'type' => 'withdraw',
    //         'note' => $request->note ?? 'Tarik Tunai dari ' . $bank->name,
    //         'amount' => $request->amount,
    //         'balance' => $balance + $request->amount,
    //     ]);

    //     return back()->with('success', 'Tarik tunai berhasil.');
    // }

    public function withdraw(Request $request)
    {
        // Validasi input dengan pesan error dalam bahasa Indonesia
        $request->validate([
            'amount' => ['required', 'numeric', 'gt:0'],
            'note' => ['nullable', 'string'],
            'bank_id' => ['required', 'exists:account_banks,id'],
        ], [
            'amount.required' => 'Nominal harus diisi.',
            'amount.numeric' => 'Nominal harus berupa angka.',
            'amount.gt' => 'Nominal harus lebih dari 0.',

            'note.string' => 'Catatan harus berupa teks.',

            'bank_id.required' => 'Bank harus dipilih.',
            'bank_id.exists' => 'Bank yang dipilih tidak valid.',
        ]);

        // Gunakan transaction agar data tidak tersimpan jika ada error di salah satu proses
        DB::beginTransaction();

        try {
            $settings = Setting::where('user_id', Auth::id())->first();

            if ($request->bank_id == optional($settings)->account_id) {
                $savingCategory = Category::where('user_id', Auth::id())
                    ->where('name', 'Saving (Tabungan)')->first();

                if (!$savingCategory) {
                    throw new \Exception('Kategori "Saving (Tabungan)" tidak ditemukan.');
                }

                $subCategories = SubCategory::where('category_id', $savingCategory->id)
                    ->pluck('id');

                $latestTransactions = Saving::whereIn('sub_category_id', $subCategories)
                    ->where('user_id', Auth::id())
                    ->orderBy('sub_category_id')
                    ->orderByDesc('created_at')
                    ->get()
                    ->unique('sub_category_id');

                $totalBalance = $latestTransactions->sum('balance');

                $saldo = AccountBank::find($request->bank_id);

                if (!$saldo) {
                    throw new \Exception('Rekening bank tidak ditemukan.');
                }

                $saldoBank = $saldo->amount - $totalBalance;
                if ($request->amount > $saldoBank) {
                    throw new \Exception("Saldo {$saldo->name} yang Free (Rp. " . number_format($saldoBank) . ") tidak cukup, karena saldo yang ada adalah saldo Saving (Tabungan).");
                }
            }

            $bank = AccountBank::find($request->bank_id);
            if (!$bank) {
                throw new \Exception('Rekening bank tidak ditemukan.');
            }

            if ($bank->amount < $request->amount) {
                throw new \Exception('Saldo tidak mencukupi.');
            }

            // Kurangi saldo rekening bank
            $bank->amount -= $request->amount;
            $bank->save();

            // Simpan data ke tabel Debit
            $latestDebit = Debit::where('user_id', Auth::id())->latest()->first();
            $balance = $latestDebit ? $latestDebit->balance : 0;

            Debit::create([
                'user_id' => Auth::id(),
                'type' => 'withdraw',
                'note' => $request->note ?? 'Tarik Tunai dari ' . $bank->name,
                'amount' => $request->amount,
                'balance' => $balance + $request->amount,
            ]);

            // Commit transaksi jika semua proses berhasil
            DB::commit();

            return back()->with('success', 'Tarik tunai berhasil.');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada kesalahan
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    public function deposit(Request $request)
    {
        // Validasi input
        $request->validate([
            'amount' => ['required', 'numeric', 'gt:0'],
            'note' => ['nullable', 'string'],
            'bank_id' => ['required', 'exists:account_banks,id'],
        ], [
            'amount.required' => 'Nominal harus diisi.',
            'amount.numeric' => 'Nominal harus berupa angka.',
            'amount.gt' => 'Nominal harus lebih dari 0.',
            'note.string' => 'Catatan harus berupa teks.',
            'bank_id.required' => 'Bank harus dipilih.',
            'bank_id.exists' => 'Bank yang dipilih tidak valid.',
        ]);

        try {
            // Mulai transaksi database
            DB::beginTransaction();

            // Ambil data rekening bank
            $bank = AccountBank::findOrFail($request->bank_id);

            // Ambil saldo terakhir dari tabel Debit
            $latestDebit = Debit::where('user_id', Auth::id())->latest()->first();
            $currentBalance = $latestDebit ? $latestDebit->balance : 0;

            // Cek apakah saldo mencukupi
            if ($currentBalance < $request->amount) {
                throw new \Exception('Saldo tidak mencukupi untuk melakukan setor tunai.');
            }

            // Tambahkan saldo ke rekening bank
            $bank->amount += $request->amount;
            $bank->save();

            // Simpan transaksi ke tabel Debit
            Debit::create([
                'user_id' => Auth::id(),
                'type' => 'deposit',
                'note' => $request->note ?? 'Setor Tunai ke ' . $bank->name,
                'amount' => -$request->amount,
                'balance' => $currentBalance - $request->amount,
            ]);

            // Commit transaksi jika semua operasi sukses
            DB::commit();

            return redirect()->back()->with('success', 'Setor tunai berhasil.');
        } catch (\Exception $e) {
            // Rollback jika ada kesalahan
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}