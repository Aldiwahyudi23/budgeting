<template>
  <AppLayout title="History Pembayaran">
    <div class="p-4">
      <div class="container mx-auto p-2">
        <!-- Header & Tombol Kembali -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-4 rounded-lg shadow-md mb-2">
          <div>
            <h1 class="text-xl font-semibold text-gray-800">History Pembayaran</h1>
            <p class="text-sm text-gray-600 mt-1">
              Halaman ini menampilkan history pembayaran untuk transaksi yang terkait dengan pinjaman ini.
            </p>
          </div>
          <button @click="goBack" class="flex items-center text-gray-600 hover:text-gray-800 mt-4 sm:mt-0">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
          </button>
        </div>

        <!-- Detail Pinjaman -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Detail Pinjaman</h2>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
              <p class="text-sm text-gray-600">Nama Pinjaman</p>
              <p class="text-sm font-medium text-gray-800">{{ formatDate(expenses?.date) || '-' }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Nama Pinjaman</p>
              <p class="text-sm font-medium text-gray-800">{{ loan?.name || '-' }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Nominal</p>
              <p class="text-sm font-medium text-gray-800">Rp {{ formatCurrency(expenses?.amount) }}</p>
            </div>

             <div>
              <p class="text-sm text-gray-600">Total Pembayaran</p>
              <p class="text-sm font-medium text-gray-800">Rp {{ formatCurrency(loan?.paid_amount) }}</p>
            </div>

            <div>
              <p class="text-sm text-gray-600">Sisa Pinjaman</p>
              <p class="text-sm font-medium text-gray-800">Rp {{ formatCurrency(loan?.amount ) }}</p>
            </div>
           
       
            <div>
              <p class="text-sm text-gray-600">Metode Pembayaran</p>
              <p class="text-sm font-medium text-gray-800">{{ expenses?.payment || '-' }}</p>
            </div>
            <div>
              <p v-if="expenses?.payment === 'Transfer'" class="text-sm text-gray-600">Account Bank</p>
              <p class="text-sm font-medium text-gray-800">{{ expenses.account_bank?.name || '-' }}</p>
            </div>
          </div>
        </div>

        <!-- Tabel History Pembayaran -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="px-6 py-4 border-b">
        <h4 class="text-lg font-semibold">Pembayaran</h4>
      </div>
          <table class="min-w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr 
                v-for="(income, index) in incomes" 
                :key="income.id" 
                @click="openModal(income)"
                class="cursor-pointer hover:bg-gray-50"
              >
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ index + 1 }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatDate(income?.date) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ formatCurrency(income?.amount) }}</td>
              </tr>
              <tr v-if="incomes.length === 0">
                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data pembayaran.</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Modal Detail Pembayaran -->
        <DetailModal 
          :show="isModalOpen" 
          :detail="selectedIncome" 
          @close="closeModal"
        />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import DetailModal from '@/Components/DetailModal.vue'; // Import komponen DetailModal

// Ambil props dari controller
const props = defineProps({
  loan: Object,
  expenses: Object,
    
  incomes: {
    type: Array,
    default: () => [],
  },
});

// State untuk modal
const isModalOpen = ref(false);
const selectedIncome = ref({});

// Buka modal dengan data income yang dipilih
const openModal = (income) => {
  selectedIncome.value = income;
  isModalOpen.value = true;
};

// Tutup modal
const closeModal = () => {
  isModalOpen.value = false;
};

// Format mata uang
const formatCurrency = (value) => {
  if (!value) return '0';
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' })
    .format(value)
    .replace('Rp', '')
    .trim();
};

// Format tanggal
const formatDate = (date) => {
  if (!date) return '-';
  return new Date(date).toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  });
};

// Fungsi untuk kembali ke halaman sebelumnya
const goBack = () => {
  window.history.back();
};
</script>