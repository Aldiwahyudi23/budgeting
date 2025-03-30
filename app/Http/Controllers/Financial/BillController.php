<?php

namespace App\Http\Controllers\Financial;

use App\Models\Financial\Bill;
use App\Http\Controllers\Controller;
use App\Models\Aktivitas\Expenses;
use App\Models\Alokasi\AllocationEx;
use App\Models\MasterData\AccountBank;
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
        $bills = Bill::with('subCategory', 'accountBank')->where('user_id', Auth::id())->get();
        $accountBanks = AccountBank::where('user_id', Auth::id())
            ->where('is_active', true)
            ->get();

        $totalActiveBills = Bill::with('subCategory', 'accountBank')
            ->where('user_id', Auth::id())
            ->whereHas('subCategory', function ($query) {
                $query->where('is_active', true); // Hanya ambil jika subCategory is_active
            })
            ->sum('amount'); // Menjumlahkan semua 'amount' dari tagihan aktif



        return Inertia::render('Financial/Bill/Index', [
            'bills' => $bills,
            'totalActiveBills' => $totalActiveBills,
            'accountBanks' => $accountBanks,
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
            $bill = Bill::create([
                'user_id' => Auth::id(),
                'date' => $request->date,
                'amount' => $request->amount,
                'note' => $request->note,
                'sub_category_id' => $subCategory->id,
                'reminder' => $request->reminder ?? false,
                'auto' => $request->auto ?? false,
                'account_id' => $request->account_id ?? Null,
            ]);

            // Get the current year and month in 'Y-m' format
            $currentDate = now();
            $currentYearMonth = $currentDate->format('Y-m');
            $currentYear = $currentDate->year;
            $currentMonth = $currentDate->month;

            // Get the subcategory and category of the bill
            $subCategoryBill = SubCategory::find($bill->sub_category_id);
            $categoryBill = Category::find($subCategoryBill->category_id); // Fixed: should be category_id

            // Get the sum of all active bills for the user
            $totalActiveBills = Bill::with('subCategory', 'accountBank')
                ->where('user_id', Auth::id())
                ->whereHas('subCategory', function ($query) {
                    $query->where('is_active', true);
                })
                ->sum('amount');

            // Process allocations from current month to December of the current year
            for ($month = $currentMonth; $month <= 12; $month++) {
                $date = sprintf('%d-%02d', $currentYear, $month);

                // Check if allocation exists for this user, category, and month
                $existingAllocation = AllocationEx::where('user_id', Auth::id())
                    ->where('category_id', $categoryBill->id)
                    ->where('date', $date)
                    ->first();

                if ($existingAllocation) {
                    // Update existing allocation
                    $existingAllocation->update([
                        'amount' => $totalActiveBills
                    ]);
                } else {
                    // Create new allocation
                    AllocationEx::create([
                        'user_id' => Auth::id(),
                        'category_id' => $categoryBill->id,
                        'amount' => $totalActiveBills,
                        'date' => $date,
                    ]);
                }
            }

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
                'account_id' => $request->account_id ?? Null,
            ]);

            // update untuk allocation
            // Get the current year and month in 'Y-m' format
            $currentDate = now();
            $currentYearMonth = $currentDate->format('Y-m');
            $currentYear = $currentDate->year;
            $currentMonth = $currentDate->month;

            // Get the subcategory and category of the bill
            $subCategoryBill = SubCategory::find($bill->sub_category_id);
            $categoryBill = Category::find($subCategoryBill->category_id); // Fixed: should be category_id

            // Get the sum of all active bills for the user
            $totalActiveBills = Bill::with('subCategory', 'accountBank')
                ->where('user_id', Auth::id())
                ->whereHas('subCategory', function ($query) {
                    $query->where('is_active', true);
                })
                ->sum('amount');

            // Process allocations from current month to December of the current year
            for ($month = $currentMonth; $month <= 12; $month++) {
                $date = sprintf('%d-%02d', $currentYear, $month);

                // Check if allocation exists for this user, category, and month
                $existingAllocation = AllocationEx::where('user_id', Auth::id())
                    ->where('category_id', $categoryBill->id)
                    ->where('date', $date)
                    ->first();

                if ($existingAllocation) {
                    // Update existing allocation
                    $existingAllocation->update([
                        'amount' => $totalActiveBills
                    ]);
                } else {
                    // Create new allocation
                    AllocationEx::create([
                        'user_id' => Auth::id(),
                        'category_id' => $categoryBill->id,
                        'amount' => $totalActiveBills,
                        'date' => $date,
                    ]);
                }
            }


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

    public function pembayaran($id)
    {
        $bill = Bill::find($id);
        $expenses = Expenses::with('category', 'subCategory', 'accountBank')->where('sub_kategori_id', $bill->sub_category_id)->get();
        return Inertia::render('Financial/Bill/Pembayaran', compact('expenses'));
    }
}