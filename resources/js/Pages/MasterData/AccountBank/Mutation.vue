<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

// Ambil data transaksi dari backend (Laravel Inertia)
const transactions = ref(usePage().props.transactions);

// State untuk filter & pagination
const search = ref('');
const perPage = ref(10);
const currentPage = ref(1);

// Filter transaksi berdasarkan pencarian
// const filteredTransactions = computed(() => {
//   return transactions.value
//     .filter(trx =>
//       getDescription(trx).toLowerCase().includes(search.value.toLowerCase())
//     )
//     .slice((currentPage.value - 1) * perPage.value, currentPage.value * perPage.value);
// });

// Filter transaksi berdasarkan pencarian
const filteredTransactions = computed(() => {
  if (!search.value) return transactions.value;
  return transactions.value.filter(item =>
    item.description.toLowerCase().includes(search.value.toLowerCase()) ||
    item.category.toLowerCase().includes(search.value.toLowerCase())
  );
});

// Fungsi untuk format tanggal
const formatDate = (date) => {
  return new Date(date).toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
  });
};

// Fungsi untuk format mata uang
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
  }).format(amount);
};

// Dapatkan keterangan transaksi berdasarkan tipe
const getDescription = (transaction) => {
  return transaction.type === 'income'
    ? `Sumber: ${transaction.sub_kategori_id || 'Tidak Ada'}`
    : `Kategori: ${transaction.sub_kategori_id || 'Tidak Ada'}`;
};

// Pagination: Halaman sebelumnya
const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

// Pagination: Halaman selanjutnya
const nextPage = () => {
  if (currentPage.value * perPage.value < transactions.value.length) currentPage.value++;
};
</script>

<template>
  <AppLayout>
    <div class="p-6 bg-gray-100 min-h-screen">
      <!-- Judul Halaman -->
      <h1 class="text-2xl font-bold mb-4 text-center text-gray-700">
        Riwayat Mutasi Rekening
      </h1>

      <!-- Catatan Penting -->
      <div class="bg-blue-100 p-4 rounded-md shadow-md mb-6">
        <p class="text-gray-700">
          💡 <strong>Catatan:</strong> Halaman ini menampilkan semua transaksi masuk dan keluar dari rekening Anda.
          Anda dapat mencari transaksi tertentu dan menyesuaikan jumlah yang ditampilkan.
        </p>
      </div>

      <!-- Filter & Pencarian -->
      <div class="flex flex-col sm:flex-row justify-between mb-4 gap-4">
        <div class="flex items-center gap-2">
          <InputLabel for="entries" value="Tampilkan" />
          <select v-model="perPage" class="border p-2 rounded">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
          </select>
          <span class="text-gray-600">transaksi</span>
        </div>
        <TextInput
          v-model="search"
          type="text"
          placeholder="Cari transaksi..."
          class="p-2 border rounded w-full sm:w-auto"
        />
      </div>

      <!-- Tabel Mutasi -->
      <div class="overflow-x-auto bg-white p-4 rounded-lg shadow-md">
        <table class="w-full border-collapse">
          <thead>
            <tr class="bg-gray-200">
              <th class="p-2 text-left">Tanggal</th>
              <th class="p-2 text-left">Kategori</th>
              <th class="p-2 text-left">Keterangan</th>
              <th class="p-2 text-left">Nominal</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="transaction in filteredTransactions" :key="transaction.id" class="border-b">
              <td class="p-2">{{ formatDate(transaction.date) }}</td>
              <td class="p-2">
                  {{ transaction.category }} 
              </td>
              <td class="p-2">
                  {{ transaction.description }}
              </td>
              <td class="p-2 font-bold" :class="transaction.type === 'income' ? 'text-green-600' : 'text-red-600'">
                {{ formatCurrency(transaction.amount) }}
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-4">
          <SecondaryButton @click="prevPage" :disabled="currentPage === 1">
            ⬅ Sebelumnya
          </SecondaryButton>
          <span class="text-gray-700">Halaman {{ currentPage }}</span>
          <PrimaryButton @click="nextPage" :disabled="currentPage * perPage >= transactions.length">
            Selanjutnya ➡
          </PrimaryButton>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style>
/* Responsif */
@media (max-width: 640px) {
  table {
    font-size: 14px;
  }
  th, td {
    padding: 8px;
  }
}
</style>
