<?php

namespace App\Http\Controllers\MasterData;

use App\Models\MasterData\SubCategory;
use App\Http\Controllers\Controller;
use App\Models\MasterData\Category;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::where('user_id', Auth::id())->first();
        // $subCategory = SubCategory::with('category')->latest()->get();
        $userId = Auth::id(); // Ambil user_id yang sedang aktif
        $subCategory = SubCategory::whereHas('category', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('category')->latest()->get();
        $category = Category::where('user_id', Auth::id())->get();

        return Inertia::render('MasterData/Category/Sub', [
            'subCategory' => $subCategory,
            'category' => $category,
            'settings' => $settings,
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
            'category_id' => 'required|exists:categories,id',
            'name' => [
                'required',
                'string',
                'max:50',
                // Validasi kombinasi unik untuk brand_id dan name
                Rule::unique('sub_categories')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id)
                        ->where('name', $request->name);
                }),
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'name.required' => "Sub Kategori Wajib diisi !",
            'name.max' => "Sub Kategori Tidak Boleh Lebih Dari 50 !",
            'name.unique' => "Nama Kategori sudah ada, silakan gunakan nama yang lain.",

            'category_id.required' => "Nama Kategori Wajib siisi",
            'category_id.exists' => "Nama Kategori sudah ada, silakan gunakan nama yang lain.",
        ]);

        SubCategory::create($request->all());

        return redirect()->back()->with('success', 'Data Berhasil di simpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $sub_category)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => [
                'required',
                'string',
                'max:50',
                // Validasi kombinasi unik untuk brand_id dan name
                Rule::unique('sub_categories')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id)
                        ->where('name', $request->name);
                })->ignore($sub_category->id), // Abaikan record dengan ID yang sedang diperbarui
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'name.required' => "Sub Kategori Wajib diisi !",
            'name.max' => "Sub Kategori Tidak Boleh Lebih Dari 50 !",
            'name.unique' => "Nama Sub Kategori sudah ada, silakan gunakan nama yang lain.",

            'category_id.required' => "Nama Kategori Wajib siisi",
            'category_id.exists' => "Nama Kategori sudah ada, silakan gunakan nama yang lain.",
        ]);

        $sub_category->update($request->all());

        return redirect()->back()->with('success', 'Data Berhasil di simpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $sub_category)
    {
        $sub_category->delete();
        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }
}