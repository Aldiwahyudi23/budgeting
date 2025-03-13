<?php

namespace App\Http\Controllers\Financial;

use App\Models\Financial\Debt;
use App\Http\Controllers\Controller;
use App\Models\Aktivitas\Expenses;
use App\Models\MasterData\Category;
use App\Models\MasterData\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB; // Jangan lupa import DB facade

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $debts = Debt::with('subCategory')->where('user_id', Auth::id())->get();

        // Ambil data expenses untuk setiap hutang
        $debts->each(function ($debt) {
            // Jika tipe hutang adalah "installment", ambil data expenses berdasarkan sub_category_id
            if ($debt->type === 'installment') {
                $expenses = Expenses::where('sub_kategori_id', $debt->sub_category_id)->get();
                $debt->expenses = $expenses;
            }
        });

        return Inertia::render('Financial/Debt/Index', [
            'debts' => $debts,
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
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'note' => 'nullable|string',
            'type' => 'required|in:personal,installment,business',
            'due_date' => 'nullable|integer|between:1,31',
            'tenor_months' => 'nullable|integer',
            'is_active' => 'boolean',
            'reminder' => 'boolean',
            'auto' => 'boolean',
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'amount.required' => 'Nominal harus diisi.',
            'amount.numeric' => 'Nominal harus berupa angka.',

            'note.string' => 'Catatan harus berupa teks.',

            'type.required' => 'Jenis transaksi harus diisi.',
            'type.in' => 'Jenis transaksi harus berupa salah satu dari: personal, installment, business.',

            'due_date.integer' => 'Tanggal jatuh tempo harus berupa angka.',
            'due_date.between' => 'Tanggal jatuh tempo harus antara 1 hingga 31.',

            'tenor_months.integer' => 'Tenor bulan harus berupa angka.',

            'is_active.boolean' => 'Status aktif harus berupa benar atau salah.',
            'reminder.boolean' => 'Pengingat harus berupa benar atau salah.',
            'auto.boolean' => 'Otomatis harus berupa benar atau salah.',
        ]);

        $user = Auth::user();

        // Mulai database transaction
        DB::beginTransaction();

        try {
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
                'name' => $request->name,
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

            // Commit transaction jika semua proses berhasil
            DB::commit();

            return redirect()->back()->with('success', 'Hutang berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
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
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'kategori.required' => 'Kategori harus diisi.',
            'kategori.string' => 'Kategori harus berupa teks.',
            'kategori.max' => 'Kategori tidak boleh lebih dari 255 karakter.',

            'amount.required' => 'Nominal harus diisi.',
            'amount.numeric' => 'Nominal harus berupa angka.',

            'note.string' => 'Catatan harus berupa teks.',

            'type.required' => 'Jenis transaksi harus diisi.',
            'type.in' => 'Jenis transaksi harus berupa salah satu dari: personal, installment, business.',

            'due_date.integer' => 'Tanggal jatuh tempo harus berupa angka.',
            'due_date.between' => 'Tanggal jatuh tempo harus antara 1 hingga 31.',

            'tenor_months.integer' => 'Tenor bulan harus berupa angka.',

            'is_active.boolean' => 'Status aktif harus berupa benar atau salah.',
            'reminder.boolean' => 'Pengingat harus berupa benar atau salah.',
            'auto.boolean' => 'Otomatis harus berupa benar atau salah.',
        ]);

        // Mulai database transaction
        DB::beginTransaction();

        try {
            // Temukan debt berdasarkan ID
            $debt = Debt::findOrFail($id);

            // Pastikan subCategory ada
            if (!$debt->subCategory) {
                throw new \Exception('Sub kategori tidak ditemukan.');
            }

            // Update sub kategori
            $debt->subCategory->update([
                'name' => $request->name,
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

            // Commit transaction jika semua proses berhasil
            DB::commit();

            // Redirect ke halaman daftar debt dengan pesan sukses
            return redirect()->route('debts.index')->with('success', 'Hutang berhasil diperbarui.');
        } catch (\Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $depts = Debt::findOrFail($id);
        $subCategory = SubCategory::findOrFail($depts->sub_category_id);

        $subCategory->delete();
        $depts->delete();

        return redirect()->back()->with('success', 'Debt berhasil dihapus.');
    }
}