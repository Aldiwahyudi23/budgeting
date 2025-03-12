<?php

namespace App\Http\Controllers\Financial;

use App\Models\Financial\Debt;
use App\Http\Controllers\Controller;
use App\Models\MasterData\Category;
use App\Models\MasterData\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $debts = Debt::with('subCategory')->where('user_id', Auth::id())->get();
        return Inertia::render('Financial/Debt/Index', ['debts' => $debts]);
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
            'name' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'note' => 'nullable|string',
            'type' => 'required|in:personal,installment,business',
            'due_date' => 'nullable|integer|min:1|max:31',
            'tenor_months' => 'nullable|integer|min:1',
            'last_payment_month' => 'nullable|date',
            'is_active' => 'boolean',
            'reminder' => 'boolean',
            'auto' => 'boolean',
        ]);

        $user = Auth::user();

        // Cek apakah kategori "Debt" sudah ada
        $category = Category::firstOrCreate([
            'name' => 'Debt (Hutang)',
            'description' => 'Catatan Hutang',
            'is_active' => true,
            'user_id' => $user->id,
        ]);

        // Simpan SubCategory berdasarkan kategori yang dipilih
        $subCategory = SubCategory::create([
            'category_id' => $category->id,
            'name' => $request->kategori,
            'description' => $request->note,
            'is_active' => $request->is_active ?? true,
        ]);

        // Simpan Debt
        $debt = Debt::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'amount' => $request->amount,
            'paid_amount' => 0,
            'status' => 'active',
            'note' => $request->note,
            'sub_category_id' => $subCategory->id,
            'type' => $request->type,
            'due_date' => $request->due_date,
            'tenor_months' => $request->tenor_months ?? $request->due_date,
            'last_payment_month' => $request->last_payment_month,
            'reminder' => $request->reminder ?? false,
            'auto' => $request->auto ?? false,
        ]);

        return redirect()->back()->with('success', 'Hutang berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Debt $debt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Debt $debt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    // Method untuk mengupdate data debt
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari frontend
        $request->validate([
            'name' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'note' => 'nullable|string',
            'type' => 'required|in:personal,installment,business',
            'due_date' => 'nullable|integer|between:1,31',
            'tenor_months' => 'nullable|integer',
            'is_active' => 'boolean',
            'reminder' => 'boolean',
            'auto' => 'boolean',
        ]);

        $debt = Debt::findOrFail($id);

        // Update sub kategori
        $debt->subCategory->update([
            'name' => $request->kategori,
            'description' => $request->note,
            'is_active' => $request->is_active,
        ]);

        // Update data Debt
        $debt->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'note' => $request->note,
            'type' => $request->type,
            'due_date' => $request->due_date,
            'tenor_months' => $request->tenor_months,
            'reminder' => $request->reminder,
            'auto' => $request->auto,
        ]);

        // Redirect ke halaman daftar debt dengan pesan sukses
        return redirect()->route('debts.index')->with('success', 'Hutang berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debt $debt)
    {
        //
    }
}