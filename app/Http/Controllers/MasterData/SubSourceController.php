<?php

namespace App\Http\Controllers\MasterData;

use App\Models\MasterData\SubSource;
use App\Http\Controllers\Controller;
use App\Models\MasterData\Category;
use App\Models\MasterData\Source;
use App\Models\MasterData\SubCategory;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SubSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::where('user_id', Auth::id())->first();
        // $subSources = SubSource::with('source')->latest()->get();
        $userId = Auth::id(); // Ambil user_id yang sedang aktif
        $subSources = SubSource::whereHas('source', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('source')->latest()->get();
        $sources = Source::where('user_id', Auth::id())->get();

        return Inertia::render('MasterData/Source/Sub', [
            'subSources' => $subSources,
            'sources' => $sources,
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
            'source_id' => 'required|exists:sources,id',
            'name' => [
                'required',
                'string',
                'max:50',
                // Validasi kombinasi unik untuk brand_id dan name
                Rule::unique('sub_sources')->where(function ($query) use ($request) {
                    return $query->where('source_id', $request->source_id)
                        ->where('name', $request->name);
                }),
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'name.required' => "Sub Sumber (Source) Wajib diisi !",
            'name.max' => "Sub Sumber (Source) Tidak Boleh Lebih Dari 50 !",
            'name.unique' => "Sub Sumber (Source) dengan nama ini sudah ada untuk Sumber (Source) yang dipilih.",

            'source_id.required' => "Nama Sumber (Source) Wajib diisi !",
            'source_id.exists' => "Nama Sumber (Source) sudah ada, silakan gunakan nama yang lain.",
        ]);

        try {
            DB::beginTransaction();

            SubSource::create($request->all());

            // 2. Cek apakah category name adalah 'Saving (Tabungan)'
            $source = Source::find($request['source_id']);

            if ($source && $source->name === 'Saving (Tabungan)') {
                // 3. Cari source dengan name yang sama dengan source
                $category = Category::where('name', $source->name)->first();

                if ($category) {
                    // 4. Simpan ke sub category
                    SubCategory::create([
                        'name' => $request->name,
                        'category_id' => $category->id,
                        'description' => $request->description,
                        'is_active' => $request->is_active ?? false,
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data Berhasil di simpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SubSource $sub_source)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubSource $sub_source)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubSource $sub_source)
    {

        $request->validate([
            'source_id' => 'required|exists:sources,id', // Validasi source_id
            'name' => [
                'required',
                'string',
                'max:50',
                // Validasi kombinasi unik untuk source_id dan name
                Rule::unique('sub_sources')->where(function ($query) use ($request) {
                    return $query->where('source_id', $request->source_id)
                        ->where('name', $request->name);
                })->ignore($sub_source->id), // Abaikan record dengan ID yang sedang diperbarui
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'name.required' => "Sub Sumber (Source) Wajib diisi !",
            'name.max' => "Sub Sumber (Source) Tidak Boleh Lebih Dari 50 Karakter !",
            'name.unique' => "Sub Sumber (Source) dengan nama ini sudah ada untuk Sumber (Source) yang dipilih.",

            'source_id.required' => "Nama Sumber (Source) Wajib diisi !",
            'source_id.exists' => "Sumber (Source) yang dipilih tidak valid.",
        ]);


        try {
            DB::beginTransaction();

            // Cek apakah source name adalah 'Saving (Tabungan)'
            $source = Source::find($request['source_id']);

            if ($source && ($source->name === 'Saving (Tabungan)' || $source->name === 'Loan (Pinjaman)')) {
                // Cari source dengan name yang sama dengan source
                $category = Category::where('name', $source->name)->first();

                if ($category) {
                    // Gunakan getOriginal() untuk mendapatkan nama sebelum diupdate
                    $originalName = $sub_source->getOriginal('name');

                    // Cari sub source berdcategoryarkan nama sebelum diubah
                    $subCategory = SubCategory::where('name', $originalName)
                        ->where('category_id', $category->id)
                        ->first();


                    if ($subCategory) {
                        // Update sub source
                        $subCategory->update([
                            'name' => $request->name,
                            'category_id' => $category->id,
                            'description' => $request->description,
                            'is_active' => $request->is_active,
                        ]);
                    } else {
                        SubCategory::create([
                            'name' => $request->name,
                            'category_id' => $category->id,
                            'description' => $request->description,
                            'is_active' => $request->is_active,
                        ]);
                    }
                }
            }

            $sub_source->update($request->all());


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
    public function destroy(SubSource $sub_source)
    {

        try {
            DB::beginTransaction();

            // Cek apakah source name adalah 'Saving (Tabungan)'
            $source = Source::find($sub_source['source_id']);

            if ($source && ($source->name === 'Saving (Tabungan)' || $source->name === 'Loan (Pinjaman)')) {
                // Cari source dengan name yang sama dengan source
                $category = Category::where('name', $source->name)->first();

                if ($category) {
                    // Gunakan getOriginal() untuk mendapatkan nama sebelum diupdate
                    $originalName = $sub_source->getOriginal('name');

                    // Cari sub source berdcategoryarkan nama sebelum diubah
                    $SubCategory = SubCategory::where('name', $originalName)
                        ->where('category_id', $category->id)
                        ->first();


                    if ($SubCategory) {
                        // Update sub source
                        $SubCategory->delete();
                    }
                }
            }

            $sub_source->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Data Berhasil di Hapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function updatePublic(SubSource $sub_source, Request $request)
    {
        // Validasi input
        $request->validate([
            'public' => 'required|boolean',
        ]);

        // Update status public
        $sub_source->update([
            'public' => $request->public,
        ]);

        // Kembalikan respons sukses
        return response()->json(['message' => 'Status berhasil diupdate!'], 200);
    }
}