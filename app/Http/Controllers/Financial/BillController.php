<?php

namespace App\Http\Controllers\Financial;

use App\Models\Financial\Bill;
use App\Http\Controllers\Controller;
use App\Models\MasterData\Category;
use App\Models\MasterData\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Di controller
        $bills = Bill::with('subCategory')->where('user_id', Auth::id())->get();

        return Inertia::render('Financial/Bill/Index', [
            'bills' => $bills,
        ]);
    }

    // Menyimpan data Bill
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'note' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'reminder' => 'boolean',
            'auto' => 'boolean',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'note.string' => 'Catatan harus berupa teks.',

            'amount.required' => 'Jumlah wajib diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah tidak boleh kurang dari 0.',

            'date.required' => 'Tanggal wajib diisi.',
            'date.date' => 'Format tanggal tidak valid.',

            'reminder.boolean' => 'Pengingat harus bernilai benar atau salah.',
            'auto.boolean' => 'Otomatis harus bernilai benar atau salah.',
            'is_active.boolean' => 'Status aktif harus bernilai benar atau salah.',
        ]);


        // Mulai database transaction
        DB::beginTransaction();

        try {

            // Cari atau buat kategori "Bills (Tagihan)"
            $category = Category::firstOrCreate(
                ['name' => 'Bills (Tagihan)', 'user_id' => Auth::id()],
                ['description' => 'Mengelola Tagihan']
            );

            // Buat sub kategori baru
            $subCategory = SubCategory::create([
                'name' => $request->name,
                'description' => $request->note,
                'category_id' => $category->id,
                'is_active' => $request->is_active,
            ]);

            // Simpan data Bill
            Bill::create([
                'user_id' => Auth::id(),
                'date' => $request->date,
                'amount' => $request->amount,
                'note' => $request->note,
                'sub_category_id' => $subCategory->id,
                'reminder' => $request->reminder ?? false,
                'auto' => $request->auto ?? false,
            ]);

            // Commit transaction jika semua proses berhasil
            DB::commit();
            return redirect()->back()->with('success', 'Bill berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    // Mengupdate data Bill
    public function update(Request $request, $id)
    {

        $request->validate([
            'note' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'reminder' => 'boolean',
            'auto' => 'boolean',
            'is_active' => 'boolean',
        ], [
            'note.string' => 'Catatan harus berupa teks.',

            'amount.required' => 'Jumlah wajib diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah tidak boleh kurang dari 0.',

            'date.required' => 'Tanggal wajib diisi.',
            'date.date' => 'Format tanggal tidak valid.',

            'reminder.boolean' => 'Pengingat harus bernilai benar atau salah.',
            'auto.boolean' => 'Otomatis harus bernilai benar atau salah.',
            'is_active.boolean' => 'Status aktif harus bernilai benar atau salah.',
        ]);


        $bill = Bill::findOrFail($id);
        // Mulai database transaction
        DB::beginTransaction();

        try {
            // Update sub kategori
            $bill->subCategory->update([
                'description' => $request->note,
                'is_active' => $request->is_active,
            ]);

            // Update data Bill
            $bill->update([
                'date' => $request->date,
                'amount' => $request->amount,
                'note' => $request->note,
                'reminder' => $request->reminder ?? false,
                'auto' => $request->auto ?? false,
            ]);

            // Commit transaction jika semua proses berhasil
            DB::commit();
            return redirect()->back()->with('success', 'Bill berhasil perbaharui.');
        } catch (\Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    // Menghapus data Bill
    public function destroy($id)
    {
        $bill = Bill::findOrFail($id);
        $subCategory = SubCategory::findOrFail($bill->sub_category_id);

        $subCategory->delete();
        $bill->delete();

        return redirect()->back()->with('success', 'Bill berhasil dihapus.');
    }
}
