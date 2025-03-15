<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Assets\Saving;
use App\Models\MasterData\Category;
use App\Models\MasterData\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AsetController extends Controller
{
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
}