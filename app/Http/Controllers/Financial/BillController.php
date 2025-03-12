<?php

namespace App\Http\Controllers\Financial;

use App\Models\Financial\Bill;
use App\Http\Controllers\Controller;
use App\Models\MasterData\Category;
use App\Models\MasterData\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        ]);

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

        return redirect()->back()->with('success', 'Bill berhasil ditambahkan.');
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
        ]);

        $bill = Bill::findOrFail($id);

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

        return redirect()->back()->with('success', 'Bill berhasil diperbarui.');
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
