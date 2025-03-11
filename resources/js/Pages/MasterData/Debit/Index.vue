<template>
  <AppLayout title="Data Debit">
    <div class="p-4">
      <!-- Flash Message -->
      <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ $page.props.flash.success }}
      </div>

      <!-- Filter dan Pencarian -->
      <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
        <!-- Filter Tanggal -->
        <div class="relative">
          <input
            type="date"
            v-model="filters.date"
            class="border rounded-md p-2"
          />
        </div>

        <!-- Pencarian -->
        <div class="relative">
          <TextInput
            v-model="filters.search"
            placeholder="Cari berdasarkan catatan..."
            class="pl-10 pr-4 py-2 border rounded-md w-64"
          />
          <svg
            class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z"
            />
          </svg>
        </div>
      </div>

      <!-- Tabel Data Debit -->
      <div class="mt-4 overflow-x-auto">
        <table class="min-w-full border bg-white rounded-lg shadow-md">
          <thead class="bg-gray-200">
            <tr>
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">Tanggal</th>
              <th class="px-4 py-2 text-left">Jenis</th>
              <th class="px-4 py-2 text-left">Catatan</th>
              <th class="px-4 py-2 text-left">Jumlah</th>
              <th class="px-4 py-2 text-left">Saldo</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(debit, index) in debits.data" :key="debit.id" class="border-b hover:bg-gray-100">
              <td class="px-4 py-2">{{ (debits.current_page - 1) * debits.per_page + index + 1 }}</td>
              <td class="px-4 py-2">{{ formatDate(debit.created_at) }}</td>
              <td class="px-4 py-2">
                
                <span :class="{
                  'text-green-600': debit.type === 'income',
                  'text-red-600': debit.type === 'expense',
                  'text-yellow-500': debit.type === 'withdraw',
                  'text-blue-500': debit.type === 'deposit'
                }">
                 {{ debit.type === 'income' ? 'Pendapatan' : debit.type === 'withdraw' ? 'Tarik Tunai' : debit.type === 'deposit' ? 'Setor Tunai' : 'Pengeluaran' }}
</span>

              </td>
              <td class="px-4 py-2">{{ debit.note || '-' }}</td>
              <td class="px-4 py-2" :class="{
                  'text-green-600': debit.type === 'income',
                  'text-red-600': debit.type === 'expense',
                  'text-yellow-500': debit.type === 'withdraw',
                  'text-blue-500': debit.type === 'deposit'
                }">
                {{ formatCurrency(debit.amount) }}
              </td>
              <td class="px-4 py-2">{{ formatCurrency(debit.balance) }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="flex justify-between items-center mt-4">
        <div class="flex items-center space-x-2">
          <select v-model="filters.perPage" @change="updatePerPage" class="border rounded-md p-1 text-sm">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>
        <div class="flex space-x-2">
          <button
            @click="prevPage"
            :disabled="debits.current_page === 1"
            class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 disabled:opacity-50"
          >
            Sebelumnya
          </button>
          <button
            @click="nextPage"
            :disabled="debits.current_page === debits.last_page"
            class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 disabled:opacity-50"
          >
            Selanjutnya
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';

// Ambil props dari controller
const props = defineProps({
  debits: Object,
  filters: Object,
});

// Format tanggal
const formatDate = (date) => {
  return new Date(date).toLocaleDateString('id-ID');
};

// Format mata uang
const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
  }).format(value || 0);
};

// Filter dan Pagination
const filters = ref({
  search: props.filters.search || '',
  date: props.filters.date || '',
  perPage: props.debits.per_page || 10,
});

// Update perPage
const updatePerPage = () => {
  router.get(route('debits.index'), {
    ...filters.value,
    perPage: filters.value.perPage,
  });
};

// Navigasi halaman
const nextPage = () => {
  if (props.debits.current_page < props.debits.last_page) {
    router.get(props.debits.next_page_url);
  }
};

const prevPage = () => {
  if (props.debits.current_page > 1) {
    router.get(props.debits.prev_page_url);
  }
};

// Watch perubahan filter
watch(filters, (newFilters) => {
  router.get(route('debits.index'), newFilters, {
    preserveState: true,
    replace: true,
  });
}, { deep: true });
</script>