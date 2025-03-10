<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Models\MasterData\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return inertia('Settings', [
            'settings' => $settings,
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