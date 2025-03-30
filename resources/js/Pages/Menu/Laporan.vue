<template>
  <AppLayout title="Laporan Keuangan">
    <div class="p-4">
      <!-- Filter Laporan -->
      <div class="bg-white p-6 rounded-lg shadow-md mb-6 mt-2">
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
        <div class="bg-white p-4 rounded-lg shadow-md">
          <div class="flex items-center">
            <div class="bg-red-100 p-2 rounded-full">
              <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Total Pengeluaran</h2>
              <p class="text-xl font-bold text-red-600">{{ formatCurrency(reportData.total_expenses) }}</p>
              <p class="text-sm text-gray-500">{{ selectedMonthName }} {{ selectedYear }}</p>
            </div>
          </div>
        </div>

        <!-- Card Total Pendapatan -->
        <div class="bg-white p-4 rounded-lg shadow-md">
          <div class="flex items-center">
            <div class="bg-green-100 p-2 rounded-full">
              <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Total Pendapatan</h2>
              <p class="text-xl font-bold text-green-600">{{ formatCurrency(reportData.total_income) }}</p>
              <p class="text-sm text-gray-500">{{ selectedMonthName }} {{ selectedYear }}</p>
            </div>
          </div>
        </div>

        <!-- Card Saldo Tabungan -->
        <div class="bg-white p-4 rounded-lg shadow-md">
          <div class="flex items-center">
            <div class="bg-blue-100 p-2 rounded-full">
              <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Saldo Tabungan</h2>
              <p class="text-xl font-bold text-blue-600">{{ formatCurrency(reportData.total_savings) }}</p>
              <p class="text-sm text-gray-500">Saldo Saat Ini</p>
            </div>
          </div>
        </div>

        <!-- Card Saldo Bersih -->
        <div class="bg-white p-4 rounded-lg shadow-md">
          <div class="flex items-center">
            <div class="bg-purple-100 p-2 rounded-full">
              <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Saldo Bersih</h2>
              <p class="text-xl font-bold text-purple-600">{{ formatCurrency(reportData.net_balance) }}</p>
              <p class="text-sm text-gray-500">{{ selectedMonthName }} {{ selectedYear }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabel Perbandingan Pengeluaran dan Pemasukan -->
      <div class="flex flex-col md:flex-row gap-4 mb-6">
    <!-- Tabel Laporan Pengeluaran -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden w-full md:w-1/2">
      <div class="bg-gray-700 text-white text-lg font-bold px-4 py-3">Pengeluaran</div>
      <table class="min-w-full responsive-table">
        <thead class="bg-gray-600 text-white text-sm uppercase tracking-wider">
          <tr>
            <th class="px-4 py-3 text-left">No</th>
            <th class="px-4 py-3 text-left">Kategori</th>
            <th class="px-4 py-3 text-left">Rencana</th>
            <th class="px-4 py-3 text-left">Aktual</th>
            <th class="px-4 py-3 text-left">Selisih</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-300 text-gray-700">
           <tr v-for="(item, index) in reportData.report" :key="index" class="hover:bg-gray-100">
            <td class="px-4 py-3">{{ index + 1 }}</td>
            <td class="px-4 py-3">{{ item.name || '-' }}</td>
            <td class="px-4 py-3">Rp {{ formatCurrency(item.alokasi) }}</td>
            <td class="px-4 py-3">Rp {{ formatCurrency(item.aktual) }}</td>
            <td class="px-4 py-3 font-semibold" :class="getSelisihClass(item.selisih)">
              Rp {{ formatCurrency(item.selisih) }}
            </td>
          </tr>
          <tr v-if="report.length === 0">
            <td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada data laporan.</td>
          </tr>
        </tbody>
        <tfoot>
          <tr class="border-t border-gray-300">
            <td colspan="2" class="px-4 py-2 text-right text-sm font-medium">Total Keseluruhan:</td>
            <td class="px-4 py-2 text-sm">Rp {{ formatCurrency(totalAlokasi) }}</td>
            <td class="px-4 py-2 text-sm">Rp {{ formatCurrency(totalAktual) }}</td>
            <td class="px-4 py-2 text-sm font-semibold" :class="getSelisihClass(totalSelisih)">
              Rp {{ formatCurrency(totalSelisih) }}
            </td>
          </tr>
        </tfoot>
      </table>
      </div>

        <!-- Tabel Laporan Pemasukan -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden w-full md:w-1/2">
          <div class="bg-gray-700 text-white text-lg font-bold px-4 py-3">Pemasukan</div>
          <table class="min-w-full responsive-table">
            <thead class="bg-gray-600 text-white text-sm uppercase tracking-wider">
              <tr>
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Sumber</th>
                <th class="px-4 py-3 text-left">Rencana</th>
                <th class="px-4 py-3 text-left">Aktual</th>
                <th class="px-4 py-3 text-left">Selisih</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-300 text-gray-700">
              <tr v-for="(item, index) in reportData.reportIn" :key="index" class="hover:bg-gray-100">
                <td class="px-4 py-3">{{ index + 1 }}</td>
                <td class="px-4 py-3">{{ item.name || '-' }}</td>
                <td class="px-4 py-3">Rp {{ formatCurrency(item.alokasi) }}</td>
                <td class="px-4 py-3">Rp {{ formatCurrency(item.aktual) }}</td>
                <td class="px-4 py-3 font-semibold" :class="getSelisihClass(item.selisih)">
                  Rp {{ formatCurrency(item.selisih) }}
                </td>
              </tr>
              <tr v-if="reportData.reportIn.length === 0">
                <td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada data laporan.</td>
              </tr>
            </tbody>
             <tfoot>
          <tr class="border-t border-gray-300">
            <td colspan="2" class="px-4 py-2 text-right text-sm font-medium">Total Keseluruhan:</td>
            <td class="px-4 py-2 text-sm">Rp {{ formatCurrency(totalAlokasiIn) }}</td>
            <td class="px-4 py-2 text-sm">Rp {{ formatCurrency(totalAktualIn) }}</td>
            <td class="px-4 py-2 text-sm font-semibold" :class="getSelisihClass(totalSelisihIn)">
              Rp {{ formatCurrency(totalSelisihIn) }}
            </td>
          </tr>
        </tfoot>
          </table>
        </div>
      </div>

      <!-- Grafik Laporan -->
      <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold mb-4">Grafik Laporan</h2>
        <div class="h-64">
          <canvas id="reportChart"></canvas>
        </div>
      </div>

      <!-- Detail Laporan -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Detail Laporan</h2>
        <!-- Input Pencarian -->
        <div class="mb-4">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Cari transaksi..."
            class="w-full p-2 border rounded-md"
          />
        </div>

        <!-- Tabel Responsif -->
        <div class="responsive-table">
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
              <tr v-for="item in paginatedTransactions" :key="item.id" class="border-b">
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

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-4">
          <button 
            @click="previousPage" 
            :disabled="currentPage === 1" 
            class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300"
          >
            back
          </button>
          <span>Hal {{ currentPage }} dari {{ totalPages }}</span>
          <button 
            @click="nextPage" 
            :disabled="currentPage === totalPages" 
            class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300"
          >
            next
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed, onMounted, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import Chart from 'chart.js/auto';

// Data untuk filter
const selectedYear = ref(new Date().getFullYear());
const selectedMonth = ref(new Date().getMonth() + 1);
const years = ref(Array.from({ length: 10 }, (_, i) => new Date().getFullYear() - i));
const months = ref([
  'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
]);

// Ambil props dari controller
const props = defineProps({
  report: Array, // Data laporan dari controller
});

// Data laporan
const reportData = ref({
  total_expenses: '',
  total_income: '',
  total_savings: '',
  net_balance: '',
  transactions: [],
  report: [],
  reportIn: [],
});

const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = 10;

// Filter transaksi berdasarkan pencarian
const filteredTransactions = computed(() => {
  if (!searchQuery.value) return reportData.value.transactions;
  return reportData.value.transactions.filter(item =>
    item.description.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    item.category.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

// Pagination
const paginatedTransactions = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredTransactions.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredTransactions.value.length / itemsPerPage));

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};

const previousPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

// Format mata uang
const formatCurrency = (value) => {
  const number = parseFloat(value); // Konversi ke angka
  if (isNaN(number)) return '0'; // Jika bukan angka, kembalikan '0'
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number).replace('Rp', '').trim();
};

// Fungsi untuk menentukan class selisih
const getSelisihClass = (selisih) => {
  const number = parseFloat(selisih); // Konversi ke angka
  if (isNaN(number)) return 'text-gray-500'; // Jika bukan angka, kembalikan warna default
  return number < 0 ? 'text-red-500' : 'text-green-500';
};

// Hitung total
const totalAlokasi = computed(() => {
  return reportData.value.report.reduce((sum, item) => sum + (Number(item.alokasi) || 0), 0);
});

const excludedCategories = computed(() => ['Saving (Tabungan)']);

const totalAktual = computed(() => {
  return reportData.value.report.reduce((sum, item) => {
    const isExcluded = excludedCategories.value.some(cat => 
      item.category_name?.toLowerCase().includes(cat.toLowerCase())
    );
    return isExcluded ? sum : sum + (Number(item.aktual) || 0);
  }, 0);
});

const totalSelisih = computed(() => {
  return  totalAlokasi.value - totalAktual.value;
});
// Hitung total
const totalAlokasiIn = computed(() => {
  return reportData.value.reportIn.reduce((sum, item) => sum + (Number(item.alokasi) || 0), 0);
});

const totalAktualIn = computed(() => {
  return reportData.value.reportIn.reduce((sum, item) => sum + (Number(item.aktual) || 0), 0);
});

const totalSelisihIn = computed(() => {
  return  totalAktual.value - totalAlokasi.value ;
});

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

// Render grafik
const renderChart = () => {
  const ctx = document.getElementById('reportChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Pengeluaran', 'Pendapatan', 'Tabungan', 'Saldo Bersih'],
      datasets: [{
        label: 'Jumlah',
        data: [
          reportData.value.total_expenses,
          reportData.value.total_income,
          reportData.value.total_savings,
          reportData.value.net_balance
        ],
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 102, 255, 0.2)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(153, 102, 255, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
};

// Ambil data laporan saat komponen dimuat
onMounted(() => {
  fetchReport();
});


</script>

<style>
/* Tambahkan scroll horizontal pada tabel di layar kecil */
@media (max-width: 640px) {
  .responsive-table {
    overflow-x: auto;
    display: block;
    white-space: nowrap;
  }
}

/* Pastikan container grafik memiliki ukuran yang cukup */
.h-64 {
  height: 16rem; /* 16 * 0.25rem = 4rem */
}
</style>