<template>
  <AppLayout title="Data BPJS JHT">
    <div class="p-4 space-y-4">
      <!-- Header Saldo -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-4 md:p-8">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div class="space-y-2">
              <h3 class="text-xl font-bold text-gray-800">Ringkasan BPJS JHT</h3>
              <p class="text-sm text-gray-500">Perhitungan berdasarkan pengaturan pekerjaan Anda</p>
            </div>
            
            <div v-if="props.latestBalance" class="bg-gradient-to-r from-blue-50 to-blue-100 p-5 rounded-xl border border-blue-200 shadow-inner w-full md:w-auto">
              <p class="text-sm font-medium text-gray-600">Saldo Terkini</p>
              <p class="text-2xl md:text-3xl font-bold text-blue-700">
                {{ formatCurrency(props.latestBalance.final_balance) }}
              </p>
              <p class="text-xs text-gray-500 mt-2">Perusahaan: {{ props.latestBalance.company_name }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Informasi Penting -->
      <div class="bg-blue-50/50 border-l-4 border-blue-400 rounded-xl p-5 shadow-sm">
        <div class="flex items-start">
          <div class="flex-shrink-0 pt-0.5">
            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-semibold text-blue-800">Catatan Penting</h3>
            <div class="mt-2 text-sm text-blue-700 space-y-2">
              <p class="flex items-start">
                <span class="inline-block mr-2">•</span>
                Data dihitung otomatis berdasarkan nominal Company Contribution (CC) dan Employee Contribution (EC) yang telah di atur di setting Pekerjaan
              </p>
              <p class="flex items-start">
                <span class="inline-block mr-2">•</span>
                Jumlah tidak akan sama persis dengan saldo aktual JHT Anda
              </p>
              <p class="flex items-start">
                <span class="inline-block mr-2">•</span>
                Perhitungan otomatis dilakukan setiap tanggal 13
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Filter -->
      <div class="bg-white rounded-xl shadow-md p-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
            <select 
                id="year" 
            v-model="selectedYear" 
            @change="filterByYear"
              class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
            >
              <option v-for="year in availableYears" :value="year">{{ year }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
            <div class="relative">
              <input
                v-model="searchQuery"
                 @input="performSearch"
                type="text"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm pl-10"
                placeholder="Cari perusahaan..."
              >
              <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </span>
            </div>
            
          </div>
        </div>
      </div>

      <!-- Tabel -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
             <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perusahaan</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Iuran Perusahaan</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Iuran Karyawan</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo Awal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo Akhir</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
          </tr>
        </thead>
<tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="(record, index) in filteredRecords" :key="record.id" class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ index + 1 }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
              {{ record.company_name }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
              {{ formatCurrency(record.company_contribution) }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
              {{ formatCurrency(record.employee_contribution) }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ formatCurrency(record.initial_balance) }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold" 
                :class="record.final_balance >= record.initial_balance ? 'text-green-600' : 'text-red-600'">
              {{ formatCurrency(record.final_balance) }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ formatDate(record.transaction_date) }}
            </td>
          </tr>
          <tr v-if="filteredRecords.length === 0">
            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
              Tidak ada data ditemukan untuk tahun {{ selectedYear }}
            </td>
          </tr>
        </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
<script setup>
import { ref , computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  latestBalance: Object,
  bpjsJhtRecords: Array,
  availableYears: Array,
  filters: Object,
});

const selectedYear = ref(props.filters.year || new Date().getFullYear());
const searchQuery = ref(props.filters.search || '');

// Filter data berdasarkan tahun dan pencarian
const filteredRecords = computed(() => {
  let records = props.bpjsJhtRecords;
  
  // Filter tahun
  if (selectedYear.value) {
    records = records.filter(record => 
      new Date(record.transaction_date).getFullYear() === parseInt(selectedYear.value))
  }
  
  // Filter pencarian
  if (searchQuery.value) {
    const searchTerm = searchQuery.value.toLowerCase();
    records = records.filter(record => 
      record.company_name.toLowerCase().includes(searchTerm) ||
      (record.description && record.description.toLowerCase().includes(searchTerm)))
  }
  
  return records;
});

const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(value || 0);
};

const formatDate = (dateString) => {
  if (!dateString) return '-';
  try {
    return new Date(dateString).toLocaleDateString('id-ID', {
      day: '2-digit',
      month: 'short',
      year: 'numeric'
    });
  } catch (e) {
    console.error('Error formatting date:', e);
    return dateString;
  }
};

const filterByYear = () => {
  router.get(route('bpjs.index'), { 
    year: selectedYear.value,
    search: searchQuery.value
  }, {
    preserveState: true
  });
};

const performSearch = () => {
  router.get(route('bpjs.index'), {
    year: selectedYear.value,
    search: searchQuery.value
  }, {
    preserveState: true,
    replace: true,
  });
};
</script>



