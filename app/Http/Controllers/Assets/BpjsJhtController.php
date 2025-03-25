<?php

namespace App\Http\Controllers\Assets;

use App\Models\Aset\BpjsJht;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BpjsJhtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     // Ambil saldo terbaru
    //     $latestBalance = BpjsJht::where('user_id', Auth::id())
    //         ->latest()
    //         ->first();

    //     // Ambil semua data BPJS JHT dengan pencarian
    //     $query = BpjsJht::where('user_id', Auth::id())->latest();

    //     if ($request->has('search')) {
    //         $query->where('company_name', 'like', '%' . $request->search . '%')
    //             ->orWhere('description', 'like', '%' . $request->search . '%');
    //     }

    //     $bpjsJhtRecords = $query->orderBy('transaction_date', 'desc')->paginate(10);

    //     return Inertia::render('Assets/Bpjs/Index', [
    //         'latestBalance' => $latestBalance,
    //         'bpjsJhtRecords' => $bpjsJhtRecords,
    //         'filters' => $request->only('search'),
    //     ]);
    // }

    public function index(Request $request)
    {
        $request->validate([
            'year' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
            'search' => 'nullable|string|max:255',
        ]);

        // Query dasar
        $query = BpjsJht::where('user_id', Auth::id())
            ->orderBy('transaction_date', 'desc');

        // Filter tahun
        if ($request->has('year')) {
            $query->whereYear('transaction_date', $request->year);
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Ambil semua data tanpa pagination
        $bpjsJhtRecords = $query->get();

        // Ambil saldo terbaru (untuk card ringkasan)
        $latestBalance = BpjsJht::where('user_id', Auth::id())
            ->orderBy('transaction_date', 'desc')
            ->first();

        // Daftar tahun yang tersedia
        $availableYears = BpjsJht::where('user_id', Auth::id())
            ->selectRaw('YEAR(transaction_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return Inertia::render('Assets/Bpjs/Index', [
            'latestBalance' => $latestBalance,
            'bpjsJhtRecords' => $bpjsJhtRecords,
            'availableYears' => $availableYears,
            'filters' => $request->only(['search', 'year']),
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BpjsJht $bpjsJht)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BpjsJht $bpjsJht)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BpjsJht $bpjsJht)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BpjsJht $bpjsJht)
    {
        //
    }
}