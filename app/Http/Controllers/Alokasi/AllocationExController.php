<?php

namespace App\Http\Controllers\Alokasi;

use App\Models\Alokasi\AllocationEx;
use App\Http\Controllers\Controller;
use App\Models\MasterData\Category;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AllocationExController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $settings = Setting::where('user_id', Auth::id())->first();
        // Ambil tahun dan bulan dari request (default ke tahun dan bulan sekarang)
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));
        $date = $year . '-' . $month; // Format YYYY-MM

        // Ambil data transaksi berdasarkan filter date
        $transactions = AllocationEx::with('category')
            ->where('date', $date)
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        // Ambil semua kategori
        $categories = Category::where('user_id', Auth::id())->get();

        return Inertia::render('MasterData/Category/Allocation', [
            'transactions' => $transactions,
            'categories' => $categories,
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
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date_format:Y-m', // Format YYYY-MM
        ]);

        AllocationEx::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(AllocationEx $allocationEx)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AllocationEx $allocationEx)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AllocationEx $allocationEx)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AllocationEx $allocation_ex)
    {
        $allocation_ex->delete();
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }

    // Mengupdate status kategori
    public function updateCategoryStatus(Request $request, string $id)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $data = Category::find($id);
        $data->update([
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('success', 'Status kategori berhasil diperbarui.');
    }
}