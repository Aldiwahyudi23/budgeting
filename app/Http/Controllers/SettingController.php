<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Models\Assets\Saving;
use App\Models\MasterData\AccountBank;
use App\Models\MasterData\Category;
use App\Models\MasterData\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    // Menampilkan halaman settings
    public function index()
    {
        // Ambil data settings berdasarkan user yang sedang login
        $settings = Setting::firstOrCreate(
            ['user_id' => Auth::id()], // Cari berdasarkan user_id
            [
                'btn_edit' => false,
                'btn_delete' => false,
                'expense_saving' => false,
                'saving_expense' => false,
                'income_saving' => false,
            ]
        );
        $accounts = AccountBank::where('user_id', Auth::id())->get();

        return inertia('Settings', [
            'settings' => $settings,
            'accounts' => $accounts,
        ]);
    }

    // Menyimpan atau memperbarui settings



    public function update(Request $request, $key)
    {
        // Validasi input
        $request->validate([
            'value' => 'required|boolean',
        ]);

        // Ambil atau buat data settings untuk user yang sedang login
        $settings = Setting::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'btn_edit' => false,
                'btn_delete' => false,
                'expense_saving' => false,
                'saving_expense' => false,
                'income_saving' => false,
            ]
        );

        // Perbarui nilai setting berdasarkan key yang dikirim
        $settings->update([$key => $request->value]);

        // Jika key yang diupdate adalah expense_saving, saving_expense, atau income_saving
        if (in_array($key, ['expense_saving', 'saving_expense', 'income_saving'])) {
            // Cek apakah kategori dengan nama "Saving" sudah ada
            $category = Category::where('name', 'Saving')
                ->where('user_id', Auth::id())
                ->first();

            // Jika kategori "Saving" belum ada, buat baru
            if (!$category) {
                Category::create([
                    'user_id' => Auth::id(),
                    'name' => 'Saving',
                    'description' => 'Kategori untuk menyimpan uang.',
                    'is_active' => true,
                ]);
            } elseif ($category) {
                // Jika kategori "Saving" sudah ada, perbarui is_active sesuai dengan value
                $category->update(['is_active' => $request->value]);
            }
        }

        return redirect()->back()->with('success', 'Berhasil Diperbaharui');
    }

    public function update_accountBank(Request $request, $key)
    {
        // Validasi input
        $request->validate([
            'account_id' => 'required|exists:account_banks,id',
        ], [
            'account_id.required' => "Pilihan bank harus diisi",
            'account_id.exists' => "Bank yang dipilih tidak valid",
        ]);

        // Ambil data setting berdasarkan ID
        $setting = Setting::findOrFail($key);
        // Ambil account_id lama
        $oldAccountId = $setting->account_id;

        // Ambil account_id baru dari request
        $newAccountId = $request->account_id;

        // Jika account_id tidak berubah, tidak perlu melakukan apa-apa
        if ($oldAccountId == $newAccountId) {
            return redirect()->back()->with('success', 'Tidak ada perubahan pada akun bank.');
        }
        // Ambil data AccountBank lama dan baru
        $oldAccountBank = AccountBank::find($oldAccountId);
        $newAccountBank = AccountBank::find($newAccountId);

        // Jika AccountBank lama atau baru tidak ditemukan
        if (!$oldAccountBank || !$newAccountBank) {
            return redirect()->back()->with('error', 'Data bank tidak valid.');
        }

        // Ambil kategori tabungan berdasarkan user_id yang login
        $savingCategory = Category::where('user_id', Auth::id())
            ->where('name', 'Saving')
            ->first();

        if (!$savingCategory) {
            return redirect()->back()->with('error', 'Kategori tabungan tidak ditemukan.');
        }

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
        $totalSavingAmount = $latestTransactions->sum('balance');
        // Update saldo di AccountBank lama dan baru
        DB::transaction(function () use ($oldAccountBank, $newAccountBank, $totalSavingAmount, $setting, $newAccountId) {
            // Kurangi saldo di AccountBank lama
            $oldAccountBank->amount -= $totalSavingAmount;
            $oldAccountBank->save();

            // Tambahkan saldo di AccountBank baru
            $newAccountBank->amount += $totalSavingAmount;
            $newAccountBank->save();

            // Update account_id di Setting
            $setting->account_id = $newAccountId;
            $setting->update();
        });

        if ($totalSavingAmount == 0) {
            $pesan = "Akun Bank berhasil diubah";
        }
        if ($totalSavingAmount > 0) {
            $saldo = number_format($totalSavingAmount);
            $pesan = "Akun bank berhasil diubah dan saldo Rp. $saldo  dipindahkan.";
        }
        return redirect()->back()->with('success', "$pesan");
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}