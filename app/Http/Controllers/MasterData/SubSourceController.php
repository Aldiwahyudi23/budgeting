<?php

namespace App\Http\Controllers\MasterData;

use App\Models\MasterData\SubSource;
use App\Http\Controllers\Controller;
use App\Models\MasterData\Source;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        SubSource::create($request->all());

        return redirect()->route('sub-sources.index')->with('success', 'Data Berhasil di simpan');
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

        // Update data
        $sub_source->update($request->only(['source_id', 'name', 'description', 'is_active']));

        return redirect()->back()->with('success', 'Data Berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubSource $sub_source)
    {
        $sub_source->delete();
        return redirect()->back()->with('success', 'Sub Source berhasil dihapus.');
    }
}