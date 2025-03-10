<?php

namespace App\Http\Controllers\MasterData;

use App\Models\MasterData\Category;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();
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
            'name' => 'required|string|max:50|unique:categories,name',
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
            'name' => 'required|string|max:50|unique:categories,name,' . $category->id,
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
        if ($category->name === 'Saving') {
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
}