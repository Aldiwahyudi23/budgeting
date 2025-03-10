<?php

namespace App\Http\Controllers\Alokasi;

use App\Models\Alokasi\AllocationIn;
use App\Http\Controllers\Controller;
use App\Models\MasterData\Source;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AllocationInController extends Controller
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
        $transactions = AllocationIn::with('source')
            ->where('date', $date)
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        // Ambil semua sumber (sources)
        $sources = Source::all();

        return Inertia::render('MasterData/Source/Allocation', [
            'transactions' => $transactions,
            'sources' => $sources,
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
            'source_id' => 'required|exists:sources,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date_format:Y-m', // Format YYYY-MM
        ]);

        AllocationIn::create([
            'user_id' => Auth::id(),
            'source_id' => $request->source_id,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AllocationIn $allocationIn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AllocationIn $allocationIn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AllocationIn $allocationIn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AllocationIn $allocation_in)
    {
        $allocation_in->delete();
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }

    // Mengupdate status kategori
    public function updateSourceStatus(Request $request, string $id)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $data = Source::find($id);
        $data->update([
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('success', 'Status kategori berhasil diperbarui.');
    }
}