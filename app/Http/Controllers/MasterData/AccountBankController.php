<?php

namespace App\Http\Controllers\MasterData;

use App\Models\MasterData\AccountBank;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class AccountBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::where('user_id', Auth::id())->first();
        // Ambil data rekening bank milik pengguna yang sedang login
        $accountBanks = AccountBank::where('user_id', Auth::id())->latest()->get();
        return inertia('MasterData/AccountBank/Index', [
            'accountBanks' => $accountBanks,
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
        // Validasi input
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('account_banks')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })
            ],
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        // Simpan rekening bank dengan user_id dari pengguna yang login
        $accountBank = AccountBank::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount ?? 0,
            'is_active' => $request->is_active ?? true, // Default true jika tidak diisi
        ]);

        return redirect()->back()->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountBank $accountBank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountBank $accountBank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountBank $accountBank)
    {

        // Pastikan rekening bank milik pengguna yang sedang login
        if ($accountBank->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        // Validasi input
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('account_banks')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })->ignore($accountBank->id), // Abaikan record dengan ID yang sedang diperbarui
            ],
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        // Simpan rekening bank dengan user_id dari pengguna yang login
        $accountBank->update([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount ?? 0,
            'is_active' => $request->is_active ?? true, // Default true jika tidak diisi
        ]);

        return redirect()->back()->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountBank $accountBank)
    {

        // Pastikan rekening bank milik pengguna yang sedang login
        if ($accountBank->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $accountBank->delete();
        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }

    public function mutation(AccountBank $accountBank)
    {
        // Pastikan rekening bank milik pengguna yang sedang login
        if ($accountBank->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil data log activity untuk rekening bank ini
        $activities = Activity::where('subject_type', AccountBank::class)
            ->where('subject_id', $accountBank->id)
            ->whereJsonContains('properties->attributes', ['amount' => $accountBank->amount])
            ->latest()
            ->get();

        return inertia('AccountBank/Mutation', [
            'accountBank' => $accountBank,
            'activities' => $activities,
        ]);
    }
}