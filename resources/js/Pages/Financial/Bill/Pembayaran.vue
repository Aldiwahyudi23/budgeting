<template>
  <AppLayout title="History Pembayaran">
    <div class="p-4">
      <div class="container mx-auto p-2">
        <!-- Header & Tombol Kembali -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-4 rounded-lg shadow-md mb-2">
          <div>
            <h1 class="text-xl font-semibold text-gray-800">History Pembayaran</h1>
            <p class="text-sm text-gray-600 mt-1">
              Halaman ini menampilkan history pembayaran untuk transaksi yang terkait dengan tagihan ini.
            </p>
          </div>
          <button @click="goBack" class="flex items-center text-gray-600 hover:text-gray-800 mt-4 sm:mt-0">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
          </button>
        </div>

        <!-- Catatan Penjelasan -->
        <div class="bg-blue-50 p-4 rounded-lg mb-6">
          <p class="text-sm text-blue-800">
            Setiap pembayaran yang dilakukan akan tercatat di sini, termasuk detail seperti nominal, tanggal, dan catatan tambahan.
          </p>
        </div>

        <!-- Tabel History Pembayaran -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
<table class="min-w-full">
  <thead class="bg-gray-50">
    <tr>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th> <!-- Kolom No -->
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
    </tr>
  </thead>
  <tbody class="divide-y divide-gray-200">
    <tr 
      v-for="(expense, index) in expenses" 
      :key="expense.id" 
      @click="openModal(expense)"
      class="cursor-pointer hover:bg-gray-50"
    >
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ index + 1 }}</td> <!-- Nomor urut -->
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatDate(expense.date) }}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ formatCurrency(expense.amount) }}</td>
    </tr>
    <tr v-if="expenses.length === 0">
      <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data pembayaran.</td>
    </tr>
  </tbody>
</table>
        </div>

        <!-- Modal Detail Pembayaran -->
        <DetailModal 
          :show="isModalOpen" 
          :detail="selectedExpense" 
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
  expenses: Array,
});

// State untuk modal
const isModalOpen = ref(false);
const selectedExpense = ref({});

// Buka modal dengan data expense yang dipilih
const openModal = (expense) => {
  selectedExpense.value = expense;
  isModalOpen.value = true;
};

// Tutup modal
const closeModal = () => {
  isModalOpen.value = false;
};

// Format mata uang
const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value).replace('Rp', '').trim();
};

// Format tanggal
const formatDate = (date) => {
  return new Date(date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
};

// Fungsi untuk kembali ke halaman sebelumnya
const goBack = () => {
  router.visit(route('bills.index')); // Sesuaikan dengan nama route halaman sebelumnya
};
</script>