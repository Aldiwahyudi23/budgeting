<?php

namespace App\Console\Commands;

use App\Mail\Notification;
use App\Models\Financial\Bill;
use App\Models\MasterData\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Billsremender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:billsremender';

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

        $today = Carbon::today();
        $todayDay = $today->day + 2; // Ambil hari (day) dari tanggal hari ini

        // Cari semua bills yang aktif dan auto
        $bills = Bill::where('reminder', true)
            ->whereDay('date', $todayDay) // Cek hari (day) dari tanggal bill sama dengan hari ini
            ->get();

        if ($bills->isEmpty()) {
            $this->info("No bills due in 2 days to process. {$todayDay}");
            return;
        }

        // Proses setiap bill
        foreach ($bills as $bill) {
            // Cek apakah subcategory aktif
            $subCategory = SubCategory::find($bill->sub_category_id);

            if (!$subCategory || !$subCategory->is_active) {
                $this->info("SubCategory ID {$bill->sub_category_id} is not active. Skipping Bill ID {$bill->id}.");
                continue;
            }

            $user = User::find($bill->user_id);

            $recipientEmail = $user->email;
            $recipientName = $user->name;
            $subCategoryName = $subCategory->name;
            $categoryName = $subCategory->category->name;
            $amount = $bill->amount;
            $status = "Belum dibayar";

            // Buat pesan email
            $message = "*Halo {$recipientName},*\n\n";
            $message .= "Berikut adalah Pengingat 2 Hari Sebelum Jatuh Tempo untuk {$subCategoryName}:\n\n";
            $message .= "Kategori: {$categoryName}\n";
            $message .= "Sub Kategori: {$subCategoryName}\n";
            $message .= "Nominal: Rp " . number_format($amount, 0, ',', '.') . "\n";
            $message .= "Tanggal Jatuh Tempo: {$bill->date}\n\n";
            $message .= "Status: *{$status}*\n\n";
            $message .= "Terima kasih telah menggunakan layanan kami.";

            $bodyMessage = preg_replace('/\*(.*?)\*/', '<b>$1</b>', $message);

            // Kirim email
            Mail::to($recipientEmail)->send(new Notification($recipientName, $bodyMessage, $status));

            $this->info("Bill ID {$bill->id} processed successfully.");
        }

        $this->info('All bills due in 2 days processed.');
    }
}