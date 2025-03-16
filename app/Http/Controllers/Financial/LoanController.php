<?php

namespace App\Http\Controllers\Financial;

use App\Models\Financial\Loan;
use App\Http\Controllers\Controller;
use App\Models\MasterData\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Ambil kategori "Loan (Pinjaman)" berdasarkan user yang login
        $loanCategory = Category::where('name', 'Loan (Pinjaman)')
            ->where('user_id', Auth::id())
            ->first();

        // Ambil data pinjaman jika kategori "Loan (Pinjaman)" ada
        $loans = [];
        if ($loanCategory) {
            $loans = Loan::where('user_id', Auth::id())->get();
        }

        // Ambil semua kategori untuk pengecekan di frontend
        $categories = Category::where('user_id', Auth::id())->get();

        return inertia('Financial/Loan/Index', [
            'loans' => $loans,
            'categories' => $categories,
            'user' => Auth::user(),
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
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,paid,overdue',
            'note' => 'nullable|string|max:255',
        ]);

        // $loans = Loan::findOrFail($loan);

        // Update data pinjaman
        $loan->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'paid_amount' => $request->paid_amount ?? 0,
            'status' => $request->status,
            'note' => $request->note,
        ]);

        return redirect()->route('loans.index')->with('success', 'Pinjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        //
    }
}