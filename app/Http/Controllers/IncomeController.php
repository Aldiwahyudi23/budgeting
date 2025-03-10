<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas\Income;
use App\Http\Controllers\Controller;
use App\Models\MasterData\AccountBank;
use App\Models\MasterData\Source;
use App\Models\MasterData\SubSource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $settings = Setting::where('user_id', Auth::id())->first();
        $year = $request->input('year', date('Y')); // Default: Tahun saat ini
        $month = $request->input('month', date('m')); // Default: Bulan saat ini

        $incomes = Income::where('user_id', Auth::id())
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->with(['source', 'subSource', 'accountBank'])
            ->get();

        $sources = Source::where('is_active', true)->get();
        $subSources = SubSource::where('is_active', true)->get();
        $accountBanks = AccountBank::where('user_id', Auth::id())->get();

        return inertia('Aktivitas/Income/Index', [
            'incomes' => $incomes,
            'sources' => $sources,
            'subSources' => $subSources,
            'accountBanks' => $accountBanks,
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
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'source_id' => 'required|exists:sources,id',
            'sub_source_id' => 'nullable|exists:sub_sources,id',
            'payment' => 'required|in:Transfer,Tunai',
            'account_id' => 'nullable|exists:account_banks,id',
        ]);

        // Jika payment adalah "Tunai", set account_id ke null
        $accountId = $request->payment === 'Tunai' ? null : $request->account_id;

        Income::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'amount' => $request->amount,
            'source_id' => $request->source_id,
            'sub_source_id' => $request->sub_source_id,
            'payment' => $request->payment,
            'account_id' => $accountId,
        ]);

        if ($accountId) {
            $amount_bank = AccountBank::find($accountId);
            $amount_bank->amount = $amount_bank->amount + $request->amount;
            $amount_bank->update();
        };

        return redirect()->route('income.index')->with('success', 'Pemasukan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        // Pastikan pemasukan milik pengguna yang sedang login
        if ($income->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'source_id' => 'required|exists:sources,id',
            'sub_source_id' => 'nullable|exists:sub_sources,id',
            'payment' => 'required|in:Transfer,Tunai',
            'account_id' => 'nullable|exists:account_banks,id',
        ]);

        // Jika payment adalah "Tunai", set account_id ke null
        $accountId = $request->payment === 'Tunai' ? null : $request->account_id;

        $income->update([
            'date' => $request->date,
            'amount' => $request->amount,
            'source_id' => $request->source_id,
            'sub_source_id' => $request->sub_source_id,
            'payment' => $request->payment,
            'account_id' => $accountId,
        ]);

        return redirect()->route('income.index')->with('success', 'Pemasukan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        // Pastikan pemasukan milik pengguna yang sedang login
        if ($income->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $income->delete();

        return redirect()->route('income.index')->with('success', 'Pemasukan berhasil dihapus.');
    }
}