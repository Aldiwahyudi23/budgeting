<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas\Income;
use App\Http\Controllers\Controller;
use App\Models\Financial\Loan;
use App\Models\MasterData\AccountBank;
use App\Models\MasterData\Debit;
use App\Models\MasterData\Source;
use App\Models\MasterData\SubCategory;
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
            ->latest()
            ->get();

        $sources = Source::where('user_id', Auth::id())->get();
        $subSources = SubSource::all();
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
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'date' => 'required|date',
    //         'amount' => 'required|numeric|min:0',
    //         'source_id' => 'required|exists:sources,id',
    //         'sub_source_id' => 'nullable|exists:sub_sources,id',
    //         'payment' => 'required|in:Transfer,Tunai',
    //         'account_id' => 'nullable|exists:account_banks,id',
    //     ], [
    //         'date.required' => 'Tanggal harus diisi.',
    //         'date.date' => 'Format tanggal tidak valid.',

    //         'amount.required' => 'Jumlah harus diisi.',
    //         'amount.numeric' => 'Jumlah harus berupa angka.',
    //         'amount.min' => 'Jumlah tidak boleh kurang dari 0.',

    //         'source_id.required' => 'Sumber harus dipilih.',
    //         'source_id.exists' => 'Sumber yang dipilih tidak valid.',

    //         'sub_source_id.exists' => 'Sub-sumber yang dipilih tidak valid.',

    //         'payment.required' => 'Metode pembayaran harus dipilih.',
    //         'payment.in' => 'Metode pembayaran harus Transfer atau Tunai.',

    //         'account_id.exists' => 'Rekening yang dipilih tidak valid.',
    //     ]);

    //     // Jika payment adalah "Tunai", set account_id ke null
    //     $accountId = $request->payment === 'Tunai' ? null : $request->account_id;

    //     Income::create([
    //         'user_id' => Auth::id(),
    //         'date' => $request->date,
    //         'amount' => $request->amount,
    //         'source_id' => $request->source_id,
    //         'sub_source_id' => $request->sub_source_id,
    //         'payment' => $request->payment,
    //         'account_id' => $accountId,
    //     ]);

    //     if ($request->payment == "Tunai") {
    //         $latestDebit = Debit::where('user_id', Auth::id())->latest()->first();
    //         $balance = $latestDebit ? $latestDebit->balance : 0;
    //         $amount = $request->amount;

    //         $subSource = SubSource::find($request->sub_source_id);
    //         $source = Source::find($request->source_id);
    //         $note = $source->name . " dari " . $subSource->name;

    //         $debit = new Debit();
    //         $debit->user_id = Auth::id();
    //         $debit->amount = $amount;
    //         $debit->type = 'Income';
    //         $debit->note = $note;
    //         $debit->balance = $balance + $amount; // Mengurangi saldo
    //         $debit->save();
    //     }

    //     if ($accountId) {
    //         $amount_bank = AccountBank::find($accountId);
    //         $amount_bank->amount = $amount_bank->amount + $request->amount;
    //         $amount_bank->update();
    //     };

    //     return redirect()->route('income.index')->with('success', 'Pemasukan berhasil ditambahkan.');
    // }


    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'source_id' => 'required|exists:sources,id',
            'sub_source_id' => 'nullable|exists:sub_sources,id',
            'payment' => 'required|in:Transfer,Tunai',
            'account_id' => 'nullable|exists:account_banks,id',
        ], [
            'date.required' => 'Tanggal harus diisi.',
            'date.date' => 'Format tanggal tidak valid.',

            'amount.required' => 'Jumlah harus diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah tidak boleh kurang dari 0.',

            'source_id.required' => 'Sumber harus dipilih.',
            'source_id.exists' => 'Sumber yang dipilih tidak valid.',

            'sub_source_id.exists' => 'Sub-sumber yang dipilih tidak valid.',

            'payment.required' => 'Metode pembayaran harus dipilih.',
            'payment.in' => 'Metode pembayaran harus Transfer atau Tunai.',

            'account_id.exists' => 'Rekening yang dipilih tidak valid.',
        ]);

        // Jika payment adalah "Tunai", set account_id ke null
        $accountId = $request->payment === 'Tunai' ? null : $request->account_id;

        // Simpan data Income
        Income::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'amount' => $request->amount,
            'source_id' => $request->source_id,
            'sub_source_id' => $request->sub_source_id,
            'payment' => $request->payment,
            'account_id' => $accountId,
        ]);

        $source = Source::where('id', $request->source_id)
            ->where('is_active', true)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Cek dan update data di tabel Loan
        if ($source->name == "Loan (Pinjaman)") {
            if ($request->sub_source_id) {
                $subSource = SubSource::find($request->sub_source_id);

                if ($subSource) {
                    $loan = Loan::where('name', $subSource->name)
                        ->where('user_id', Auth::id())
                        ->first();

                    if ($loan) {
                        // Kurangi amount dan tambahkan paid_amount
                        $loan->amount -= $request->amount;
                        $loan->paid_amount += $request->amount;

                        // Jika amount <= 0, ubah status menjadi 'paid'
                        if ($loan->amount <= 0) {
                            $loan->status = 'paid';
                            $subSource->is_active = false;
                            $subSource->update();
                        }

                        $loan->save();
                    }
                }
            }
        }

        // Proses untuk pembayaran Tunai
        if ($request->payment == "Tunai") {
            $latestDebit = Debit::where('user_id', Auth::id())->latest()->first();
            $balance = $latestDebit ? $latestDebit->balance : 0;
            $amount = $request->amount;

            $subSource = SubSource::find($request->sub_source_id);
            $source = Source::find($request->source_id);
            $note = $source->name . " dari " . $subSource->name;

            $debit = new Debit();
            $debit->user_id = Auth::id();
            $debit->amount = $amount;
            $debit->type = 'Income';
            $debit->note = $note;
            $debit->balance = $balance + $amount; // Menambah saldo
            $debit->save();
        }

        // Proses untuk pembayaran Transfer
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
        ], [
            'date.required' => 'Tanggal harus diisi.',
            'date.date' => 'Format tanggal tidak valid.',

            'amount.required' => 'Jumlah harus diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah tidak boleh kurang dari 0.',

            'source_id.required' => 'Sumber harus dipilih.',
            'source_id.exists' => 'Sumber yang dipilih tidak valid.',

            'sub_source_id.exists' => 'Sub-sumber yang dipilih tidak valid.',

            'payment.required' => 'Metode pembayaran harus dipilih.',
            'payment.in' => 'Metode pembayaran harus Transfer atau Tunai.',

            'account_id.exists' => 'Rekening yang dipilih tidak valid.',
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