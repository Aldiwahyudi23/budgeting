<?php

namespace App\Console\Commands;

use App\Mail\Notification;
use App\Models\Aktivitas\Expenses;
use App\Models\Financial\Bill;
use App\Models\MasterData\AccountBank;
use App\Models\MasterData\Category;
use App\Models\MasterData\SubCategory;
use App\Models\User;
use App\Services\FonnteService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class BillsAuto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:bills-auto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        parent::__construct();
        $this->fonnteService = $fonnteService;
    }
    public function handle()
    {
        // Ambil tanggal hari ini
        $today = Carbon::today();
        $todayDay = $today->day; // Ambil hari (day) dari tanggal hari ini

        // Cari semua bills yang aktif dan auto
        $bills = Bill::where('auto', true)
            ->whereDay('date', $todayDay) // Cek hari (day) dari tanggal bill sama dengan hari ini
            ->get();

        if ($bills->isEmpty()) {
            $this->info("No active and auto bills to process {$todayDay}");
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

            // Cek apakah account bank ada
            $accountBank = AccountBank::find($bill->account_id);

            if (!$accountBank) {
                $this->error("AccountBank ID {$bill->account_id} not found. Skipping Bill ID {$bill->id}.");
                continue;
            }

            // Cek apakah saldo mencukupi
            if ($accountBank->amount < $bill->amount) {
                $this->error("Insufficient balance in AccountBank ID {$bill->account_id}. Skipping Bill ID {$bill->id}.");
                continue;
            }

            // Simpan data ke expenses
            $expense = Expenses::create(
                [
                    'amount' => $bill->amount,
                    'date' => $today, // Gunakan tanggal hari ini
                    'sub_kategori_id' => $bill->sub_category_id,
                    'category_id' => $subCategory->category_id, // Ambil category_id dari subcategory
                    'user_id' => $bill->user_id, // User ID dari bill
                    'payment' => 'Transfer', // Payment method
                    'account_id' => $bill->account_id, // Account ID dari bill
                ]
            );

            // Kurangi saldo di account bank
            $accountBank->amount -= $bill->amount;
            $accountBank->save();

            $user = User::find($bill->user_id);

            $recipientNo = $user->numberPhone;
            $recipientEmail = $user->email;
            $recipientName = $user->name;
            $subCategoryName = $subCategory->name;
            $categoryName = $subCategory->category->name;
            $amount = $bill->amount;
            $accountBankName = $accountBank->name;
            $remainingBalance = $accountBank->amount; // Saldo yang tersisa
            $processDate = Carbon::now()->format('d F Y H:i:s'); // Tanggal/waktu proses
            $status = "Selesai";

            // Buat pesan email
            $message = "✨ *Halo {$recipientName},* ✨\n\n";
            $message .= "📋 Berikut adalah laporan transaksi Pembayaran *{$subCategoryName}* yang di-setting otomatis:\n\n";
            $message .= "🏷️ *Kategori:* {$categoryName}\n";
            $message .= "📂 *Sub Kategori:* {$subCategoryName}\n";
            $message .= "💰 *Nominal:* Rp " . number_format($amount, 0, ',', '.') . "\n";
            $message .= "🏦 *Account Bank:* {$accountBankName}\n";
            $message .= "💳 *Saldo Tersisa:* Rp " . number_format($remainingBalance, 0, ',', '.') . "\n";
            $message .= "📅 *Tanggal/Waktu Proses:* {$processDate}\n\n";
            $message .= "🔄 *Status:* *{$status}*\n\n";
            $message .= "🙏 Terima kasih telah menggunakan layanan kami. Jika ada pertanyaan atau kendala, jangan ragu untuk menghubungi kami.\n\n";
            $message .= "Best regards,\n";
            $message .= "Budgeting Kel. Ma HAYA 🚀";

            $bodyMessage = preg_replace('/\*(.*?)\*/', '<b>$1</b>', $message);

            $status = "Selesai";
            Mail::to($recipientEmail)->send(new Notification($recipientName, $bodyMessage, $status));

            if ($recipientNo) {
                $this->fonnteService->sendWhatsAppMessage($recipientNo, $message);
            }

            $this->info("Bill ID {$bill->id} processed successfully. Expense ID {$expense->id} created.");
        }

        $this->info('All active and auto bills processed.');
    }
}