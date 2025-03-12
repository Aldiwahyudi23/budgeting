<template>
  <AppLayout title="Dashboard Keuangan">
    <div class="p-4">

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Card Saldo Bersih -->
    <Link
      :href="route('account-bank.index')"
      class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow"
    >
      <div class="flex items-center">
        <div class="bg-purple-100 p-2 rounded-full">
          <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-3">
          <h2 class="text-base font-semibold">Saldo Bersih</h2>
          <p class="text-xl font-bold text-purple-600">Rp {{ formatCurrency(totalBalance) }}</p>
          <p class="text-xs text-gray-500">
            <span class="block">Bank: Rp {{ formatCurrency(totalBankBalance) }}</span>
            <span class="block">Tunai: Rp {{ formatCurrency(totalCashBalance) }}</span>
          </p>
        </div>
      </div>
    </Link>

    <!-- Card Saldo Tabungan -->
    <div class="bg-white p-4 rounded-lg shadow-md">
      <div class="flex items-center">
        <div class="bg-blue-100 p-2 rounded-full">
          <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
          </svg>
        </div>
        <div class="ml-3">
          <h2 class="text-base font-semibold">Saldo Tabungan</h2>
          <p class="text-xl font-bold text-blue-600">Rp{{ formatCurrency(totalSavingAmount) }}</p>
          <p class="text-xs text-gray-500">Saldo saat ini</p>
        </div>
      </div>
    </div>

    <!-- Card Total Pendapatan -->
    <div class="bg-white p-4 rounded-lg shadow-md">
      <div class="flex items-center">
        <div class="bg-green-100 p-2 rounded-full">
          <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-3">
          <h2 class="text-base font-semibold">Total Pendapatan</h2>
          <p class="text-xl font-bold text-green-600">Rp{{ formatCurrency(totalIncome) }}</p>
          <p class="text-xs text-gray-500">Bulan ini</p>
        </div>
      </div>
    </div>

    <!-- Card Total Pengeluaran -->
    <div class="bg-white p-4 rounded-lg shadow-md">
      <div class="flex items-center">
        <div class="bg-red-100 p-2 rounded-full">
          <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-3">
          <h2 class="text-base font-semibold">Total Pengeluaran</h2>
          <p class="text-xl font-bold text-red-600">Rp{{ formatCurrency(totalExpenses) }}</p>
          <p class="text-xs text-gray-500">Bulan ini</p>
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
    <!-- Menu Tagihan -->
    <Link
      :href="route('bills.index')"
      class="flex flex-col items-center justify-center bg-blue-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1"
    >
      <div class="bg-blue-500 p-3 rounded-full text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 3v18m18-18v18M3 9h18m-9 9V9"></path>
        </svg>
      </div>
      <p class="mt-2 text-sm font-semibold text-gray-700">Tagihan</p>
    </Link>

    <!-- Menu Hutang -->
    <Link
      :href="route('debts.index')"
      class="flex flex-col items-center justify-center bg-red-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1"
    >
      <div class="bg-red-500 p-3 rounded-full text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-2 0v10m-6 4h12a1 1 0 001-1v-2H4v2a1 1 0 001 1z"></path>
        </svg>
      </div>
      <p class="mt-2 text-sm font-semibold text-gray-700">Hutang</p>
    </Link>

    <!-- Menu Pinjaman -->
    <Link
      :href="route('loans.index')"
      class="flex flex-col items-center justify-center bg-green-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1"
    >
      <div class="bg-green-500 p-3 rounded-full text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m0 0L9 8m6 0v8"></path>
        </svg>
      </div>
      <p class="mt-2 text-sm font-semibold text-gray-700">Pinjaman</p>
    </Link>

    <!-- Menu Tabungan -->
    <Link
      :href="route('savings.index')"
      class="flex flex-col items-center justify-center bg-yellow-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1"
    >
      <div class="bg-yellow-500 p-3 rounded-full text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a4 4 0 00-8 0v2m0 0a4 4 0 018 0zm-4 5v2m-6 4h12a1 1 0 001-1v-2H4v2a1 1 0 001 1z"></path>
        </svg>
      </div>
      <p class="mt-2 text-sm font-semibold text-gray-700">Tabungan</p>
    </Link>
  </div>


      <!-- Grafik dan Data Lainnya -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Grafik Pengeluaran -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h2 class="text-lg font-semibold mb-4">Grafik Pengeluaran</h2>
          <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
            <p class="text-gray-500">Grafik akan ditampilkan di sini</p>
          </div>
        </div>

        <!-- Daftar Transaksi Terbaru -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h2 class="text-lg font-semibold mb-4">Transaksi Terbaru</h2>
          <ul>
            <li class="flex items-center justify-between py-2 border-b">
              <div>
                <p class="font-semibold">Belanja Bulanan</p>
                <p class="text-sm text-gray-500">12 Oktober 2023</p>
              </div>
              <p class="text-red-500">- Rp 1.500.000</p>
            </li>
            <li class="flex items-center justify-between py-2 border-b">
              <div>
                <p class="font-semibold">Gaji Bulanan</p>
                <p class="text-sm text-gray-500">10 Oktober 2023</p>
              </div>
              <p class="text-green-500">+ Rp 5.000.000</p>
            </li>
            <li class="flex items-center justify-between py-2 border-b">
              <div>
                <p class="font-semibold">Bayar Listrik</p>
                <p class="text-sm text-gray-500">8 Oktober 2023</p>
              </div>
              <p class="text-red-500">- Rp 500.000</p>
            </li>
          </ul>
          <Link
            :href="route('expense.index')"
            class="text-blue-500 hover:text-blue-700 text-sm mt-4 block"
          >
            Lihat Semua Transaksi →
          </Link>
        </div>
      </div>

      

      <!-- Quick Links -->
      <div class="mt-6">
        <h2 class="text-lg font-semibold mb-4">Akses Cepat</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <Link
            :href="route('expense.index')"
            class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"
          >
            <div class="flex items-center">
              <div class="bg-red-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="ml-4">
                <h2 class="text-lg font-semibold">Pengeluaran</h2>
                <p class="text-sm text-gray-600">Kelola pengeluaran Anda</p>
              </div>
            </div>
          </Link>

          <Link
            :href="route('income.index')"
            class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"
          >
            <div class="flex items-center">
              <div class="bg-green-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="ml-4">
                <h2 class="text-lg font-semibold">Pendapatan</h2>
                <p class="text-sm text-gray-600">Kelola pendapatan Anda</p>
              </div>
            </div>
          </Link>

          <Link
            :href="route('savings.index')"
            class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"
          >
            <div class="flex items-center">
              <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
              </div>
              <div class="ml-4">
                <h2 class="text-lg font-semibold">Tabungan</h2>
                <p class="text-sm text-gray-600">Kelola tabungan Anda</p>
              </div>
            </div>
          </Link>

          <Link
            :href="route('account-bank.index')"
            class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"
          >
            <div class="flex items-center">
              <div class="bg-purple-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="ml-4">
                <h2 class="text-lg font-semibold">Laporan</h2>
                <p class="text-sm text-gray-600">Lihat laporan keuangan</p>
              </div>
            </div>
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

// Terima props dari controller
const props = defineProps({
  totalSavingAmount: Number,
  totalIncome:Number,
  totalExpenses:Number,
  totalBalance: Number,
  totalBankBalance: Number,
  totalCashBalance: Number,
  transactions: Array, // Tambahkan transaksi
});

// Fungsi untuk memformat mata uang
const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID').format(value);
};
</script>
