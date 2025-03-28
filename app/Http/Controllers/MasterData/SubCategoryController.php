<?php

namespace App\Http\Controllers\MasterData;

use App\Models\MasterData\SubCategory;
use App\Http\Controllers\Controller;
use App\Models\MasterData\Category;
use App\Models\MasterData\Source;
use App\Models\MasterData\SubSource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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


        try {
            DB::beginTransaction();

            // 1. Cek apakah category 'Saving (Tabungan)' ada
            // $category = Category::where('name', 'Saving (Tabungan)')->first();

            // if (!$category) {
            //     return redirect()->back()
            //         ->with('error', 'Kategori Tabungan belum ada. Silakan aktifkan terlebih dahulu di Setting-Tabungan.')
            //         ->withInput();
            // }

            // // 2. Cek apakah category 'Saving (Tabungan)' aktif
            // if (!$category->is_active) {
            //     return redirect()->back()
            //         ->with('error', 'Kategori Tabungan tidak aktif. Silakan aktifkan terlebih dahulu di Setting-Tabungan.')
            //         ->withInput();
            // }

            // // 3. Cek apakah category_id yang dikirim sesuai
            // if ($request->category_id != $category->id) {
            //     return redirect()->back()
            //         ->with('error', 'Kategori tidak valid.')
            //         ->withInput();
            // }

            // 4. Simpan sub category
            SubCategory::create($request->all());

            // 5. Simpan ke sub source
            $source = Source::where('name', 'Saving (Tabungan)')->first();

            if ($source) {
                SubSource::create([
                    'name' => $request->name,
                    'source_id' => $source->id,
                    'description' => $request->description,
                    'is_active' => $request->is_active ?? false,
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
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

        try {
            DB::beginTransaction();

            // Cek apakah category name adalah 'Saving (Tabungan)'
            $category = Category::find($request['category_id']);

            if ($category && ($category->name === 'Saving (Tabungan)' || $category->name === 'Loan (Pinjaman)')) {
                // Cari source dengan name yang sama dengan category
                $source = Source::where('name', $category->name)->first();

                if ($source) {
                    // Gunakan getOriginal() untuk mendapatkan nama sebelum diupdate
                    $originalName = $sub_category->getOriginal('name');

                    // Cari sub source berdasarkan nama sebelum diubah
                    $subSource = SubSource::where('name', $originalName)
                        ->where('source_id', $source->id)
                        ->first();


                    if ($subSource) {
                        // Update sub source
                        $subSource->update([
                            'name' => $request->name,
                            'source_id' => $source->id,
                            'description' => $request->description,
                            'is_active' => $request->is_active,
                        ]);
                    } else {
                        SubSource::create([
                            'name' => $request->name,
                            'source_id' => $source->id,
                            'description' => $request->description,
                            'is_active' => $request->is_active,
                        ]);
                    }
                }
            }

            $sub_category->update($request->all());


            DB::commit();
            return redirect()->back()->with('success', 'Data Berhasil di simpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $sub_category)
    {

        try {
            DB::beginTransaction();

            // Cek apakah category name adalah 'Saving (Tabungan)'
            $category = Category::find($sub_category['category_id']);

            if ($category && ($category->name === 'Saving (Tabungan)' || $category->name === 'Loan (Pinjaman)')) {
                // Cari source dengan name yang sama dengan category
                $source = Source::where('name', $category->name)->first();

                if ($source) {
                    // Gunakan getOriginal() untuk mendapatkan nama sebelum diupdate
                    $originalName = $sub_category->getOriginal('name');

                    // Cari sub source berdasarkan nama sebelum diubah
                    $subSource = SubSource::where('name', $originalName)
                        ->where('source_id', $source->id)
                        ->first();


                    if ($subSource) {
                        // Update sub source
                        $subSource->delete();
                    }
                }
            }

            $sub_category->delete();


            DB::commit();
            return redirect()->back()->with('success', 'Data Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updatePublic(SubCategory $subCategory, Request $request)
    {
        // Validasi input
        $request->validate([
            'public' => 'required|boolean',
        ]);

        // Update status public
        $subCategory->update([
            'public' => $request->public,
        ]);

        // Kembalikan respons sukses
        return response()->json(['message' => 'Status berhasil diupdate!'], 200);
    }
}