<template>
  <AppLayout title="Laporan Keuangan">
    <div class="p-4">
      <h1 class="text-2xl font-bold mb-6">Laporan Keuangan</h1>

      <!-- Filter Laporan -->
      <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold mb-4">Filter Laporan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <!-- Pilih Tahun -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Tahun</label>
            <select v-model="selectedYear" class="mt-1 block w-full border rounded-md p-2">
              <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
            </select>
          </div>

          <!-- Pilih Bulan -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Bulan</label>
            <select v-model="selectedMonth" class="mt-1 block w-full border rounded-md p-2">
              <option v-for="(month, index) in months" :key="index" :value="index + 1">{{ month }}</option>
            </select>
          </div>

          <!-- Tombol Filter -->
          <div class="flex items-end">
            <button @click="fetchReport" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
              Terapkan Filter
            </button>
          </div>
        </div>
      </div>

      <!-- Ringkasan Laporan -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Card Total Pengeluaran -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <div class="flex items-center">
            <div class="bg-red-100 p-3 rounded-full">
              <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Total Pengeluaran</h2>
              <p class="text-2xl font-bold text-red-600">{{ formatCurrency(reportData.total_expenses) }}</p>
              <p class="text-sm text-gray-500">{{ selectedMonthName }} {{ selectedYear }}</p>
            </div>
          </div>
        </div>

        <!-- Card Total Pendapatan -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <div class="flex items-center">
            <div class="bg-green-100 p-3 rounded-full">
              <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Total Pendapatan</h2>
              <p class="text-2xl font-bold text-green-600">{{ formatCurrency(reportData.total_income) }}</p>
              <p class="text-sm text-gray-500">{{ selectedMonthName }} {{ selectedYear }}</p>
            </div>
          </div>
        </div>

        <!-- Card Saldo Tabungan -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <div class="flex items-center">
            <div class="bg-blue-100 p-3 rounded-full">
              <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Saldo Tabungan</h2>
              <p class="text-2xl font-bold text-blue-600">{{ formatCurrency(reportData.total_savings) }}</p>
              <p class="text-sm text-gray-500">Saldo Saat Ini</p>
            </div>
          </div>
        </div>

        <!-- Card Saldo Bersih -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <div class="flex items-center">
            <div class="bg-purple-100 p-3 rounded-full">
              <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Saldo Bersih</h2>
              <p class="text-2xl font-bold text-purple-600">{{ formatCurrency(reportData.net_balance) }}</p>
              <p class="text-sm text-gray-500">{{ selectedMonthName }} {{ selectedYear }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Grafik Laporan -->
      <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold mb-4">Grafik Laporan</h2>
        <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
          <p class="text-gray-500">Grafik akan ditampilkan di sini</p>
        </div>
      </div>

      <!-- Tabel Detail Laporan -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Detail Laporan</h2>
        <table class="min-w-full">
          <thead>
            <tr>
              <th class="text-left py-2">Tanggal</th>
              <th class="text-left py-2">Kategori</th>
              <th class="text-left py-2">Deskripsi</th>
              <th class="text-right py-2">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in reportData.transactions" :key="item.id" class="border-b">
              <td class="py-2">{{ formatDate(item.date) }}</td>
              <td class="py-2">{{ item.category }}</td>
              <td class="py-2">{{ item.description }}</td>
              <td class="text-right" :class="item.type === 'income' ? 'text-green-500' : 'text-red-500'">
                {{ item.type === 'income' ? '+' : '-' }} {{ formatCurrency(item.amount) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

// Data untuk filter
const selectedYear = ref(new Date().getFullYear());
const selectedMonth = ref(new Date().getMonth() + 1);
const years = ref(Array.from({ length: 10 }, (_, i) => new Date().getFullYear() - i));
const months = ref([
  'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
]);

// Data laporan
const reportData = ref({
  total_expenses: '',
  total_income: '',
  total_savings: '',
  net_balance: '',
  transactions: [],
});

// Format mata uang
const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
};

// Format tanggal
const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('id-ID');
};

// Ambil nama bulan yang dipilih
const selectedMonthName = computed(() => months.value[selectedMonth.value - 1]);

// Ambil data laporan
const fetchReport = async () => {
  router.get(route('laporan'), {
    year: selectedYear.value,
    month: selectedMonth.value,
  }, {
    preserveState: true,
    onSuccess: (data) => {
      reportData.value = data.props.report;
    },
  });
};

// Ambil data laporan saat komponen dimuat
onMounted(() => {
  fetchReport();
});
</script>