<?php

namespace App\Http\Controllers\MasterData;

use App\Models\MasterData\Category;
use App\Http\Controllers\Controller;
use App\Models\MasterData\SubCategory;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $excludedNames = ['Fund Transfer', 'Saving (Tabungan)', 'Bills (Tagihan)', 'Debt (Hutang)', 'Loan (Pinjaman)']; // Tambahkan nama-nama yang ingin dikecualikan
        $categories = Category::where('user_id', Auth::id())
            ->whereNotIn('name', $excludedNames)
            ->latest()
            ->get();
        $settings = Setting::where('user_id', Auth::id())->first();
        return Inertia::render('MasterData/Category/Index', compact('categories', 'settings'));
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
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('categories')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                }),
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'name.required' => "Kategori Wajib diisi !",
            'name.max' => "Kategori Tidak Boleh Lebih Dari 50 !",
            'name.unique' => "Nama Kategori sudah ada, silakan gunakan nama yang lain.",
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active ?? true, // Default true jika tidak diisi
        ]);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('categories')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })->ignore($category->id), // Abaikan record dengan ID yang sedang diperbarui
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'name.required' => "Kategori Wajib diisi !",
            'name.max' => "Kategori Tidak Boleh Lebih Dari 50 !",
            'name.unique' => "Nama Kategori sudah ada, silakan gunakan nama yang lain.",
        ]);

        $category->update([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active ?? true, // Default true jika tidak diisi
        ]);

        // Jika kategori yang diupdate adalah "Saving"
        if ($category->name === 'Saving (Tabungan)') {
            // Cek apakah ada data Setting untuk user yang sedang login
            $settings = Setting::where('user_id', Auth::id())->first();

            if ($settings) {
                // Perbarui expense_saving di Setting sesuai dengan is_active kategori Saving
                $settings->update(['expense_saving' => $category->is_active]);
            }
        }

        return redirect()->back()->with('success', 'Kategori berhasil diperbaharui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }

    // Menampilkan halaman kelola kategori
    public function manage()
    {

        $excludedNames = ['Fund Transfer', 'Saving (Tabungan)', 'Bills (Tagihan)', 'Debt (Hutang)', 'Loan (Pinjaman)']; // Tambahkan nama-nama yang ingin dikecualikan
        $categories = Category::whereNotIn('name', $excludedNames)
            ->latest()
            ->get();
        $subCategories = SubCategory::all();
        $userCategories = Category::where('user_id', Auth::id())->get();
        $userSubCategories = SubCategory::whereHas('category', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        // dd($userCategories);
        return inertia('MasterData/Category/ManageCategories', [
            'categories' => $categories,
            'subCategories' => $subCategories,
            'userCategories' => $userCategories,
            'userSubCategories' => $userSubCategories,
        ]);
    }
    // Menyimpan kategori dan sub kategori yang dipilih
    public function saveSelected(Request $request)
    {
        $user = Auth::user();

        // Simpan kategori yang dipilih
        foreach ($request->categories as $categoryId) {
            $category = Category::find($categoryId);
            Category::firstOrCreate([
                'user_id' => $user->id,
                'name' => $category->name,
                'description' => $category->description,
            ]);
        }

        // Simpan sub kategori yang dipilih
        foreach ($request->subCategories as $subCategoryId) {
            $subCategory = SubCategory::find($subCategoryId);
            SubCategory::firstOrCreate([
                'category_id' => $subCategory->category_id,
                'name' => $subCategory->name,
                'description' => $subCategory->description,
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
}