<?php

namespace App\Http\Controllers\Assets;

use App\Models\Assets\Saving;
use App\Http\Controllers\Controller;
use App\Models\MasterData\AccountBank;
use App\Models\MasterData\Category;
use App\Models\MasterData\SubCategory;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::where('user_id', Auth::id())->first();
        $savings = Saving::where('user_id', Auth::id())
            ->with(['category', 'subCategory'])
            ->latest()
            ->get();

        $categories = Category::where('is_active', true)
            ->where('user_id', Auth::id())
            ->where('name', 'Saving (Tabungan)')
            ->get(); // Hanya ambil kategori tabungan
        $subCategories = SubCategory::whereHas('category', function ($query) {
            $query->where('is_active', true);
        })->get();

        return inertia('Assets/Savings/Index', [
            'savings' => $savings,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'settings' => $settings,
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
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'note' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
        ]);

        // Hitung saldo terakhir
        $lastSaving = Saving::where('user_id', Auth::id())
            ->where('sub_category_id', $request->sub_category_id)
            ->latest()
            ->first();
        // Jika $lastSaving tidak ada, set balance ke 0
        $lastBalance = $lastSaving ? $lastSaving->balance : 0;

        // Hitung balance baru
        $balance = $lastBalance + $request->amount;

        Saving::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'amount' => $request->amount,
            'note' => $request->note,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'balance' => $balance,
        ]);

        // Ambil data settings untuk user yang sedang login
        $settings = Setting::where('user_id', Auth::id())->first();

        // Cek apakah account_id di settings sudah dipilih
        if (!$settings || !$settings->account_id) {
            return redirect()->back()->with('error', 'Bank untuk tabungan belum dipilih. Silakan pilih bank terlebih dahulu di pengaturan.');
        }

        // Jika kategori adalah "Saving", tambahkan amount ke account_id di settings
        if ($settings && $settings->account_id) {
            $savingAccount = AccountBank::find($settings->account_id);
            $savingAccount->amount += $request->amount;
            $savingAccount->update();
        }

        return redirect()->route('savings.index')->with('success', 'Tabungan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Saving $saving)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Saving $saving)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Saving $saving)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'note' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
        ]);

        // Hitung ulang saldo jika jumlah berubah
        if ($saving->amount !== $request->amount) {
            $balanceDifference = $request->amount - $saving->amount;
            $saving->balance += $balanceDifference;

            // Update saldo untuk semua transaksi setelahnya
            Saving::where('user_id', Auth::id())
                ->where('id', '>', $saving->id)
                ->increment('balance', $balanceDifference);
        }

        $saving->update([
            'date' => $request->date,
            'amount' => $request->amount,
            'note' => $request->note,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'balance' => $saving->balance,
        ]);

        return redirect()->route('savings.index')->with('success', 'Tabungan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saving $saving)
    {
        // Pastikan tabungan milik pengguna yang sedang login
        if ($saving->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Update saldo untuk semua transaksi setelahnya
        Saving::where('user_id', Auth::id())
            ->where('id', '>', $saving->id)
            ->decrement('balance', $saving->amount);

        $saving->delete();

        return redirect()->route('savings.index')->with('success', 'Tabungan berhasil dihapus.');
    }
}
