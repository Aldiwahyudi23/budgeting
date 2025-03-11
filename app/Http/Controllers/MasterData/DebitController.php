<?php

namespace App\Http\Controllers\MasterData;

use App\Models\MasterData\Debit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DebitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $user_id = Auth::id();
        // Query data debit berdasarkan user_id
        $debits = Debit::where('user_id', $user_id)
            ->when($request->search, function ($query, $search) {
                return $query->where('note', 'like', '%' . $search . '%');
            })
            ->when($request->date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('MasterData/Debit/Index', [
            'debits' => $debits,
            'filters' => $request->only(['search', 'date']),
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Debit $debit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Debit $debit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Debit $debit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debit $debit)
    {
        //
    }
}