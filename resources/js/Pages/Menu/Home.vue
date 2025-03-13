<template>
  <AppLayout title="Dashboard Keuangan">
    <div class="p-4">

  <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
    <!-- Card Saldo Bersih -->
    <Link
      :href="route('account-bank.index')"
      class="flex flex-col items-center justify-center bg-blue-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1"
    >
      <div class="flex items-center">
        <div class="hidden sm:block bg-purple-100 p-2 rounded-full">
          <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-3">
          <h2 class="text-base font-semibold">Saldo Bersih</h2>
          <p class="text-xl font-bold text-purple-600">{{ formatCurrency(totalBalance) }}</p>
          <p class="text-xs text-gray-500">
            <span class="block">Bank: {{ formatCurrency(totalBankBalance) }}</span>
            <span class="block">Tunai: {{ formatCurrency(totalCashBalance) }}</span>
          </p>
        </div>
      </div>
    </Link>

    <!-- Card Saldo Tabungan -->
    <div class="flex flex-col items-center justify-center bg-red-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
      <div class="flex items-center">
        <div class="hidden sm:block bg-blue-100 p-2 rounded-full">
          <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
          </svg>
        </div>
        <div class="ml-3">
          <h2 class="text-base font-semibold">Saldo Tabungan</h2>
          <p class="text-xl font-bold text-blue-600">{{ formatCurrency(totalSavingAmount) }}</p>
          <p class="text-xs text-gray-500">Saldo saat ini</p>
        </div>
      </div>
    </div>

    <!-- Card Total Pendapatan -->
    <div class="flex flex-col items-center justify-center bg-green-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
      <div class="flex items-center">
        <div class="hidden sm:block bg-green-100 p-2 rounded-full">
          <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-3">
          <h2 class="text-base font-semibold">Total Pendapatan</h2>
          <p class="text-xl font-bold text-green-600">{{ formatCurrency(totalIncome) }}</p>
          <p class="text-xs text-gray-500">Bulan ini</p>
        </div>
      </div>
    </div>

    <!-- Card Total Pengeluaran -->
    <div class="flex flex-col items-center justify-center bg-yellow-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
      <div class="flex items-center">
        <div class=" hidden sm:block bg-red-100 p-2 rounded-full">
          <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-3">
          <h2 class="text-base font-semibold">Total Pengeluaran</h2>
          <p class="text-xl font-bold text-red-600">{{ formatCurrency(totalExpenses) }}</p>
          <p class="text-xs text-gray-500">Bulan ini</p>
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-4 sm:grid-cols-6 xl:grid-cols-8 gap-4 mt-6">
    <!-- Menu Tagihan -->
    <Link
      :href="route('bills.index')"
      class="menu-item bg-blue-500"
    >
      <div class="bg-blue-600 p-3 rounded-full text-white">
        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11m-1-6h4m-4 0v4m0-4L3 10m1 4h9m-9 0v6m0-6L3 14m11-4h4m-4 0v6m0-6L14 14m5-4h2m-2 0v6m0-6L19 14"></path>
        </svg>
      </div>
      <span>Tagihan</span>
    </Link>

    <!-- Menu Hutang -->
    <Link
      :href="route('debts.index')"
      class="menu-item bg-red-500"
    >
      <div class="bg-red-600 p-3 rounded-full text-white">
        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3 3v-6m-8 3a9 9 0 1118 0 9 9 0 01-18 0z"></path>
        </svg>
      </div>
      <span>Hutang</span>
    </Link>

    <!-- Menu Pinjaman -->
    <Link
      :href="route('loans.index')"
      class="menu-item bg-green-500"
    >
      <div class="bg-green-600 p-3 rounded-full text-white">
        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      <span>Pinjaman</span>
    </Link>

    <!-- Menu Tabungan -->
    <Link
      :href="route('savings.index')"
      class="menu-item bg-purple-500"
    >
      <div class="bg-purple-600 p-3 rounded-full text-white">
        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <span>Tabungan</span>
    </Link>
  </div>


      <!-- Grafik dan Data Lainnya -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Grafik Pengeluaran -->
       <div class="bg-white p-6 rounded-lg shadow-md">
          <h2 class="text-lg font-semibold mb-4">Grafik Pengeluaran vs Pendapatan</h2>
          <div class="h-64">
            <canvas ref="chartCanvas"></canvas>
          </div>
        </div>

 <!-- Daftar Transaksi Terbaru -->
  <div class="bg-white p-4 rounded-lg shadow-md">
    <h2 class="text-sm font-semibold mb-3">Transaksi Terbaru</h2>
    <ul>
      <li
        v-for="transaction in props.latestTransactions"
        :key="transaction.id"
        class="flex items-center justify-between py-1 border-b"
      >
        <div>
          <p class="text-xs font-semibold">{{ transaction.category }} {{ transaction.description }}</p>
          <p class="text-[10px] text-gray-500">
            {{ new Date(transaction.date).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) }}
          </p>
        </div>
        <p :class="transaction.type === 'income' ? 'text-green-500' : 'text-red-500'">
          {{ transaction.type === 'income' ? '+' : '-' }} Rp {{ transaction.amount.toLocaleString() }}
        </p>
      </li>
    </ul>
    <Link
      :href="route('laporan')"
      class="text-blue-500 hover:text-blue-700 text-[12px] mt-3 block"
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
import { ref, onMounted } from 'vue'; // Tambahkan import ref & onMounted
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Chart from 'chart.js/auto';

const chartCanvas = ref(null);
let chartInstance = null;

// Terima props dari controller
const props = defineProps({
  totalSavingAmount: Number,
  totalIncome: Number,
  totalExpenses: Number,
  totalBalance: Number,
  totalBankBalance: Number,
  totalCashBalance: Number,
  transactions: Array, // Tambahkan transaksi
  latestTransactions: Array
});

const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', { 
    style: 'currency', 
    currency: 'IDR', 
    minimumFractionDigits: 0, 
    maximumFractionDigits: 0 
  }).format(value);
};

// Contoh penggunaan
console.log(formatCurrency(1000000)); // Output: "Rp1.000.000"
console.log(formatCurrency(50000));   // Output: "Rp50.000"


onMounted(() => {
  if (chartCanvas.value) {
    if (chartInstance) {
      chartInstance.destroy();
    }

    chartInstance = new Chart(chartCanvas.value, {
      type: 'bar',
      data: {
        labels: ['Pengeluaran', 'Pendapatan'],
        datasets: [
          {
            label: 'Jumlah (Rp)',
            data: [props.totalExpenses, props.totalIncome],
            backgroundColor: ['#f87171', '#4ade80'],
            borderColor: ['#dc2626', '#16a34a'],
            borderWidth: 1,
          },
        ],
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            beginAtZero: true,
            ticks: {
              callback: function (value) {
                return new Intl.NumberFormat('id-ID', {
                  style: 'currency',
                  currency: 'IDR',
                }).format(value);
              },
            },
          },
        },
        plugins: {
          legend: { display: false },
        },
      },
    });
  }
});
</script>


<style scoped>
.menu-item {
  @apply flex flex-col items-center justify-center p-4 rounded-lg shadow-md text-white font-semibold transition-transform transform hover:scale-105;
}
.icon {
  @apply w-10 h-10 mb-2;
}

</style>