<?php

namespace App\Http\Controllers\MasterData;

use App\Models\MasterData\Source;
use App\Http\Controllers\Controller;
use App\Models\MasterData\SubSource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::where('user_id', Auth::id())->first();

        $excludedNames = ['Fund Transfer', 'Loan (Pinjaman)']; // Tambahkan nama-nama yang ingin dikecualikan
        $sources = Source::where('user_id', Auth::id())
            ->whereNotIn('name', $excludedNames)
            ->latest()
            ->get();

        return Inertia::render('MasterData/Source/Index', [
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
            'description' => 'nullable|string',
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sources')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                }),
            ],
            'is_active' => 'boolean',
        ], [
            'name.required' => "Nama Sumber (Source) Wajib diisi !",
            'name.max' => "Nama Sumber (Source) Tidak Boleh Lebih Dari 50 !",
            'name.unique' => "Nama Sumber (Source) sudah ada, silakan gunakan nama yang lain.",
        ]);

        Source::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active ?? true, // Default true jika tidak diisi
        ]);
        return redirect()->back()->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Source $source)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Source $source)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Source $source)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sources')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })->ignore($source->id), // Abaikan record dengan ID yang sedang diperbarui
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'name.required' => "Nama Sumber (Source) Wajib diisi !",
            'name.max' => "Nama Sumber (Source) Tidak Boleh Lebih Dari 50 !",
            'name.unique' => "Nama Sumber (Source) sudah ada, silakan gunakan nama yang lain.",
        ]);

        $source->update([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active ?? true, // Default true jika tidak diisi
        ]);
        return redirect()->back()->with('success', 'Data Berhasil Diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Source $source)
    {
        $source->delete();
        return redirect()->back()->with('success', 'Source berhasil dihapus.');
    }
}