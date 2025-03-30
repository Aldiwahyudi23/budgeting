<?php

namespace App\Http\Controllers;

use App\Models\Auth\Job;
use App\Http\Controllers\Controller;
use App\Models\Alokasi\AllocationEx;
use App\Models\Alokasi\AllocationIn;
use App\Models\MasterData\Source;
use App\Models\MasterData\SubCategory;
use App\Models\MasterData\SubSource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Validasi request
        $request->validate([
            'company_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'job_description' => 'nullable|string',
            'salary' => 'required|numeric',
            'bpjs' => 'nullable|boolean',
            'bpjs_company_percentage' => 'nullable|numeric|between:0,100',
            'bpjs_employee_percentage' => 'nullable|numeric|between:0,100',
            'benefits' => 'nullable|string',
        ], [
            'company_name.required' => 'Nama perusahaan wajib diisi.',
            'company_name.max' => 'Nama perusahaan maksimal 255 karakter.',
            'job_title.required' => 'Judul pekerjaan wajib diisi.',
            'job_title.max' => 'Judul pekerjaan maksimal 255 karakter.',
            'salary.required' => 'Gaji wajib diisi.',
            'salary.numeric' => 'Gaji harus berupa angka.',
            'bpjs.boolean' => 'BPJS harus berupa nilai boolean (true/false).',
            'bpjs_company_percentage.numeric' => 'Persentase BPJS perusahaan harus berupa angka.',
            'bpjs_company_percentage.between' => 'Persentase BPJS perusahaan harus antara 0 hingga 100.',
            'bpjs_employee_percentage.numeric' => 'Persentase BPJS karyawan harus berupa angka.',
            'bpjs_employee_percentage.between' => 'Persentase BPJS karyawan harus antara 0 hingga 100.',
        ]);

        // Cek apakah user sudah memiliki job
        if (Job::where('user_id', Auth::id())->exists()) {
            return redirect()->back()->withErrors(['error' => 'You already have a job entry.']);
        }

        try {
            // Mulai transaction
            DB::transaction(function () use ($request) {
                // Simpan job baru
                $job = Job::create([
                    'user_id' => Auth::id(),
                    'company_name' => $request->company_name,
                    'job_title' => $request->job_title,
                    'job_description' => $request->job_description,
                    'salary' => $request->salary,
                    'bpjs' => $request->bpjs,
                    'bpjs_company_percentage' => $request->bpjs_company_percentage,
                    'bpjs_employee_percentage' => $request->bpjs_employee_percentage,
                    'benefits' => $request->benefits,
                ]);

                $source = Source::firstOrCreate(
                    ['name' => 'Salary (Gajih)', 'user_id' => Auth::id()], // Cari berdasarkan name dan user_id
                    ['is_active' => true] // Jika tidak ada, buat baru dengan is_active = true
                );

                // Simpan Sub Source dengan name = company_name, category_id = id source, dan is_active = true
                SubSource::create([
                    'source_id' => $source->id,
                    'name' => $request->company_name,
                    'is_active' => true,
                ]);


                // Get the current year and month in 'Y-m' format
                $currentDate = now();
                $currentYear = $currentDate->year;
                $currentMonth = $currentDate->month;

                // Process allocations from current month to December of the current year
                for ($month = $currentMonth; $month <= 12; $month++) {
                    $date = sprintf('%d-%02d', $currentYear, $month);

                    // Check if allocation exists for this user, category, and month
                    $existingAllocation = AllocationIn::where('user_id', Auth::id())
                        ->where('source_id', $source->id)
                        ->where('date', $date)
                        ->first();

                    if ($existingAllocation) {
                        // Update existing allocation
                        $existingAllocation->update([
                            'amount' => $existingAllocation->amount + $request->salary
                        ]);
                    } else {
                        // Create new allocation
                        AllocationIn::create([
                            'user_id' => Auth::id(),
                            'source_id' => $source->id,
                            'amount' => $request->salary,
                            'date' => $date,
                        ]);
                    }
                }
            });
            return back()->with('success', 'Job, Source, dan Sub Source berhasil disimpan!');
        } catch (Exception $e) {
            // Rollback transaction dan tampilkan pesan error
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {

        // Validasi request
        $request->validate([
            'company_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'job_description' => 'nullable|string',
            'salary' => 'required|numeric',
            'bpjs' => 'nullable|boolean',
            'bpjs_company_percentage' => 'nullable|numeric|between:0,100',
            'bpjs_employee_percentage' => 'nullable|numeric|between:0,100',
            'benefits' => 'nullable|string',
        ], [
            'company_name.required' => 'Nama perusahaan wajib diisi.',
            'company_name.max' => 'Nama perusahaan maksimal 255 karakter.',
            'job_title.required' => 'Judul pekerjaan wajib diisi.',
            'job_title.max' => 'Judul pekerjaan maksimal 255 karakter.',
            'salary.required' => 'Gaji wajib diisi.',
            'salary.numeric' => 'Gaji harus berupa angka.',
            'bpjs.boolean' => 'BPJS harus berupa nilai boolean (true/false).',
            'bpjs_company_percentage.numeric' => 'Persentase BPJS perusahaan harus berupa angka.',
            'bpjs_company_percentage.between' => 'Persentase BPJS perusahaan harus antara 0 hingga 100.',
            'bpjs_employee_percentage.numeric' => 'Persentase BPJS karyawan harus berupa angka.',
            'bpjs_employee_percentage.between' => 'Persentase BPJS karyawan harus antara 0 hingga 100.',
        ]);

        $job->update($request->all());

        $source = Source::firstOrCreate(
            ['name' => 'Salary (Gajih)', 'user_id' => Auth::id()], // Cari berdasarkan name dan user_id
            ['is_active' => true] // Jika tidak ada, buat baru dengan is_active = true
        );

        // Get the current year and month in 'Y-m' format
        $currentDate = now();
        $currentYear = $currentDate->year;
        $currentMonth = $currentDate->month;

        // Process allocations from current month to December of the current year
        for ($month = $currentMonth; $month <= 12; $month++) {
            $date = sprintf('%d-%02d', $currentYear, $month);

            // Check if allocation exists for this user, category, and month
            $existingAllocation = AllocationIn::where('user_id', Auth::id())
                ->where('source_id', $source->id)
                ->where('date', $date)
                ->first();

            $bpjs =  $request->salary * (4 / 100);
            $amount =  $request->salary - $bpjs;

            if ($existingAllocation) {
                // Update existing allocation
                $existingAllocation->update([
                    'amount' => $amount
                ]);
            } else {
                // Create new allocation
                AllocationIn::create([
                    'user_id' => Auth::id(),
                    'source_id' => $source->id,
                    'amount' => $amount,
                    'date' => $date,
                ]);
            }
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        //
    }
}