<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Models\Assets\Saving;
use App\Models\Auth\Job;
use App\Models\MasterData\AccountBank;
use App\Models\MasterData\Category;
use App\Models\MasterData\Source;
use App\Models\MasterData\SubCategory;
use App\Models\User;
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
                'bank' => false,
                'cash' => false,
                'date_in' => false,
                'date_ex' => false,
            ]
        );
        $accounts = AccountBank::where('user_id', Auth::id())->get();

        // Ambil ID user yang login
        $userId = Auth::id();
        $user = User::find($userId);
        // Cek apakah user sudah memiliki job
        $job = Job::where('user_id', $userId)->first();

        return inertia('Settings', [
            'settings' => $settings,
            'accounts' => $accounts,
            'job' => $job,
            'userId' => $userId,
            'user' => $user,

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
                'bank' => false,
                'cash' => false,
                'date_in' => false,
                'date_ex' => false,
            ]
        );

        // Perbarui nilai setting berdasarkan key yang dikirim
        $settings->update([$key => $request->value]);

        // Jika key yang diupdate adalah expense_saving, saving_expense, atau income_saving
        if (in_array($key, ['expense_saving', 'saving_expense'])) {
            // Cek apakah kategori dengan nama "Saving" sudah ada
            $category = Category::where('name', 'Saving (Tabungan)')
                ->where('user_id', Auth::id())
                ->first();

            // Jika kategori "Saving" belum ada, buat baru
            if (!$category) {
                Category::create([
                    'user_id' => Auth::id(),
                    'name' => 'Saving (Tabungan)',
                    'description' => 'Kategori Untuk Tabungan.',
                    'is_active' => true,
                ]);
            } elseif ($category) {
                // Jika kategori "Saving" sudah ada, perbarui is_active sesuai dengan value
                $category->update(['is_active' => $request->value]);
            }
        }
        // Jika key yang diupdate adalah expense_saving, saving_expense, atau income_saving
        if (in_array($key, ['income_saving'])) {
            // Cek apakah kategori dengan nama "Saving" sudah ada
            $source = Source::where('name', 'Saving (Tabungan)')
                ->where('user_id', Auth::id())
                ->first();

            // Jika kategori "Saving" belum ada, buat baru
            if (!$source) {
                Source::create([
                    'user_id' => Auth::id(),
                    'name' => 'Saving (Tabungan)',
                    'description' => 'Kategori Untuk Tabungan.',
                    'is_active' => true,
                ]);
            } elseif ($source) {
                // Jika kategori "Saving" sudah ada, perbarui is_active sesuai dengan value
                $source->update(['is_active' => $request->value]);
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
            'account_id.exists' => "Bank yang dipilih tidak valid, Tabungan Belum Aktif",
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
        if (!$newAccountBank) {
            return redirect()->back()->with('error', 'Data bank tidak valid.');
        }

        // Ambil kategori tabungan berdasarkan user_id yang login
        $savingCategory = Category::where('user_id', Auth::id())
            ->where('name', 'Saving (Tabungan)')
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
            if ($oldAccountBank) {
                // Kurangi saldo di AccountBank lama
                $oldAccountBank->amount -= $totalSavingAmount;
                $oldAccountBank->save();

                // Tambahkan saldo di AccountBank baru
                $newAccountBank->amount += $totalSavingAmount;
                $newAccountBank->save();
            }

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

    public function sandiBotton()
    {
        return inertia('Setting/SandiBotton', [
            'hasPassword' => !empty(Auth::user()->sandi_botton)
        ]);
    }

    public function updateSandiBotton(Request $request)
    {
        $user = $request->user();

        $rules = [
            'new_password' => ['required', 'string', 'min:4', 'max:20']
        ];

        if ($user->sandi_botton) {
            $rules['current_password'] = ['required', 'string'];
        }

        $request->validate($rules);

        if ($user->sandi_botton) {
            if ($request->current_password !== $user->sandi_botton) {
                return back()->withErrors([
                    'current_password' => 'Sandi saat ini tidak sesuai'
                ]);
            }
        }

        $user->update([
            'sandi_botton' => $request->new_password
        ]);

        return redirect()->route('sandi-botton')
            ->with('success', 'Sandi botton berhasil diperbarui');
    }
}