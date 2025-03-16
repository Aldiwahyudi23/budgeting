<?php

namespace App\Console\Commands;

use App\Mail\Notification;
use App\Models\Aktivitas\Expenses;
use App\Models\Financial\Debt;
use App\Models\MasterData\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DebtsRemender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:debts-remender';

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

        // Cari semua debts yang aktif dan auto
        $debts = Debt::where('reminder', true)
            ->where('status', 'active')
            ->where('type', 'installment')
            ->where('due_date', $todayDay) // Cek hari (day) dari tanggal debt sama dengan hari ini
            ->get();

        if ($debts->isEmpty()) {
            $this->info("No debts due in 2 days to process. {$todayDay}");
            return;
        }

        // Proses setiap debt
        foreach ($debts as $debt) {
            // Cek apakah subcategory aktif
            $subCategory = SubCategory::find($debt->sub_category_id);

            if (!$subCategory || !$subCategory->is_active) {
                $this->info("SubCategory ID {$debt->sub_category_id} is not active. Skipping debt ID {$debt->id}.");
                continue;
            }

            $expenses = Expenses::where('sub_kategori_id', $debt->sub_category_id)
                ->where('user_id', $debt->user_id)
                ->count();

            $user = User::find($debt->user_id);

            $recipientEmail = $user->email;
            $recipientName = $user->name;
            $subCategoryName = $subCategory->name;
            $categoryName = $subCategory->category->name;
            $amount = $debt->amount;
            $status = "Belum dibayar";

            // Buat pesan email
            $message = "*Halo {$recipientName},*\n\n";
            $message .= "📅 **Pengingat 2 Hari Sebelum Jatuh Tempo**\n\n";
            $message .= "Kami ingin mengingatkan Anda bahwa tagihan berikut akan jatuh tempo dalam **2 hari**:\n\n";
            $message .= "🔹 **Kategori:** {$categoryName}\n";
            $message .= "🔹 **Sub Kategori:** {$subCategoryName}\n";
            $message .= "🔹 **Nominal Tagihan:** Rp " . number_format($amount, 0, ',', '.') . "\n";
            $message .= "🔹 **Pembayaran ke:** {$debt->due_date}\n";
            $message .= "🔹 **Tanggal Jatuh Tempo:** {$debt->date}\n";
            $message .= "🔹 **Status Pembayaran:** *{$status}*\n\n";
            $message .= "📊 **Detail Hutang:**\n";
            $message .= "Anda telah melakukan pembayaran sebanyak **{$expenses} kali** dari total **{$debt->teno_months} bulan**.\n\n";
            $message .= "💡 **Tips:**\n";
            $message .= "- Pastikan untuk membayar tagihan sebelum jatuh tempo untuk menghindari denda.\n";
            $message .= "- Jika Anda sudah membayar, abaikan pesan ini.\n\n";
            $message .= "Terima kasih telah menggunakan layanan kami. 🙏\n\n";
            $message .= "Salam hangat,\n";
            $message .= "Tim Keuangan Anda";

            $bodyMessage = preg_replace('/\*(.*?)\*/', '<b>$1</b>', $message);

            // Kirim email
            Mail::to($recipientEmail)->send(new Notification($recipientName, $bodyMessage, $status));

            $this->info("debt ID {$debt->id} processed successfully.");
        }

        $this->info('All debts due in 2 days processed.');
    }
}