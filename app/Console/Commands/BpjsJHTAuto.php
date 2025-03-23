<?php

namespace App\Console\Commands;

use App\Models\Auth\Job;
use App\Models\Aset\BpjsJht;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BpjsJHTAuto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:bpjs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jobs = Job::where('bpjs', true)->get();

        foreach ($jobs as $job) {
            // Hitung kontribusi berdasarkan persentase BPJS
            $companyContribution = ($job->salary * $job->bpjs_company_percentage) / 100;
            $employeeContribution = ($job->salary * $job->bpjs_employee_percentage) / 100;

            // Ambil saldo awal dari data sebelumnya (jika ada)
            $lastRecord = BpjsJht::where('user_id', $job->user_id)->latest()->first();
            $initialBalance = $lastRecord ? $lastRecord->final_balance : 0;

            // Hitung saldo akhir
            $finalBalance = $initialBalance + $companyContribution + $employeeContribution;

            // Simpan data ke bpjs_jhts
            BpjsJht::create([
                'user_id' => $job->user_id,
                'company_name' => $job->company_name,
                'company_contribution' => $companyContribution,
                'employee_contribution' => $employeeContribution,
                'initial_balance' => $initialBalance,
                'final_balance' => $finalBalance,
                'transaction_date' => Carbon::now(),
                'status' => 'Pending',
                'reference_number' => 'BPJS-' . strtoupper(uniqid()),
                'description' => 'Kontribusi BPJS bulan ' . Carbon::now()->format('F Y'),
            ]);

            $this->info("BPJS JHT generated for user ID: {$job->user_id}");
        }

        $this->info("BPJS JHT processing completed.");
    }
}