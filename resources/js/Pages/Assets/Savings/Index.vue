<template>
  <AppLayout title="Saving (Tabungan)">
    <div class="p-4 space-y-4">

      <!-- Flash Messages -->
      <div v-if="$page.props.flash.success" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
        <div class="flex items-center">
          <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
          <p>{{ $page.props.flash.success }}</p>
        </div>
      </div>

      <div v-if="$page.props.flash.error" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
        <div class="flex items-center">
          <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
          </svg>
          <p>{{ $page.props.flash.error }}</p>
        </div>
      </div>

      <!-- Saldo per Sub Kategori -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Saldo Tabungan per Kategori</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div v-for="subCategory in subCategoryBalances" :key="subCategory.id" 
                 class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl border border-blue-200">
              <h4 class="text-sm font-medium text-gray-600">{{ subCategory.name }}</h4>
              <p class="text-2xl font-bold mt-2" 
                 :class="subCategory.balance < 0 ? 'text-red-600' : 'text-green-600'">
                {{ formatCurrency(subCategory.balance) }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Filter dan Pencarian -->
      <div class="bg-white rounded-xl shadow-md p-5">
        <div class="flex flex-col md:flex-row md:items-end gap-4">
          <!-- Pencarian -->
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Cari Transaksi</label>
            <div class="relative">
              <input
                v-model="searchQuery"
                type="text"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm pl-10"
                placeholder="Cari berdasarkan kategori atau catatan..."
              >
              <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </span>
            </div>
          </div>
          
          <!-- Tombol Tambah -->
          <PrimaryButton @click="openSubCategoryModal" class="w-full md:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
            </svg>
            Tambah Kategori
          </PrimaryButton>
        </div>
      </div>

      <!-- Tabel Data -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-xl">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masuk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-xl">Saldo</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="(item, index) in paginatedSavings" :key="item.id" class="hover:bg-gray-50/50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ (currentPage - 1) * perPage + index + 1 }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(item.date) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ item.sub_category?.name || '-' }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                  {{ item.note || '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                  {{ item.amount > 0 ? formatCurrency(item.amount) : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">
                  {{ item.amount < 0 ? formatCurrency(Math.abs(item.amount)) : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                  {{ formatCurrency(item.balance) }}
                </td>
              </tr>
              <tr v-if="paginatedSavings.length === 0">
                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                  Tidak ada data transaksi ditemukan
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-b-xl">
          <div class="flex-1 flex justify-between sm:hidden">
            <button @click="prevPage" :disabled="currentPage === 1" 
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
              Sebelumnya
            </button>
            <button @click="nextPage" :disabled="currentPage === totalPages" 
                    class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
              Selanjutnya
            </button>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Menampilkan
                <span class="font-medium">{{ (currentPage - 1) * perPage + 1 }}</span>
                sampai
                <span class="font-medium">{{ Math.min(currentPage * perPage, filteredSavings.length) }}</span>
                dari
                <span class="font-medium">{{ filteredSavings.length }}</span>
                hasil
              </p>
            </div>
            <div class="flex items-center space-x-2">
              <select v-model="perPage" @change="currentPage = 1"
                      class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                <option value="10">10 per halaman</option>
                <option value="25">25 per halaman</option>
                <option value="50">50 per halaman</option>
              </select>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <button @click="prevPage" :disabled="currentPage === 1"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50">
                  <span class="sr-only">Sebelumnya</span>
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                </button>
                <button @click="nextPage" :disabled="currentPage === totalPages"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50">
                  <span class="sr-only">Selanjutnya</span>
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                  </svg>
                </button>
              </nav>
            </div>
          </div>
        </div>
      </div>

<CustomModal :show="subCategoryModalOpen" title="Tambah Kategori Tabungan" @close="closeSubCategoryModal">
  <template #content>
    <form @submit.prevent="submitSubCategoryForm">
      <div class="mb-4">
        <InputLabel for="name">
          Nama Kategori Tabungan
          <span class="text-red-500 text-sm">*</span>
        </InputLabel>
        <TextInput id="name" v-model="subCategoryForm.name" class="block w-full" required />
        <InputError :message="subCategoryForm.errors.name" />
      </div>

      <div class="mb-4">
        <InputLabel for="description">
          Deskripsi
        </InputLabel>
        <TextInput id="description" v-model="subCategoryForm.description" class="block w-full" />
        <InputError :message="subCategoryForm.errors.description" />
      </div>

      <div class="mb-4">
        <InputLabel>
          Kategori Induk
        </InputLabel>
        <div class="p-2 bg-gray-100 rounded">
          Saving (Tabungan)
        </div>
        <small class="text-gray-500">Kategori tabungan akan otomatis terhubung dengan "Saving (Tabungan)"</small>
      </div>

      <div class="mb-4">
        <InputLabel for="is_active">
          Status
        </InputLabel>
        <div class="flex items-center">
          <input type="checkbox" id="is_active" v-model="subCategoryForm.is_active" class="mr-2" />
          <label for="is_active">Aktif</label>
        </div>
        <InputError :message="subCategoryForm.errors.is_active" />
      </div>

      <div class="flex justify-end mt-4">
        <SecondaryButton type="button" @click="closeSubCategoryModal">Batal</SecondaryButton>
        <PrimaryButton class="ml-3" type="submit" :disabled="subCategoryForm.processing">
          <span v-if="subCategoryForm.processing">Menyimpan...</span>
          <span v-else>Simpan</span>
        </PrimaryButton>
      </div>
    </form>
  </template>
</CustomModal>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import CustomModal from '@/Components/CustomModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
  savings: Array,
  categories: Array,
  subCategories: Array,
});

const settings = ref(usePage().props.settings);
const searchQuery = ref('');
const subCategoryModalOpen = ref(false);
const currentPage = ref(1);
const perPage = ref(10);

// Form untuk sub kategori
const subCategoryForm = useForm({
  name: '',
  description: '',
  is_active: true,
  category_id: '', // Akan diisi otomatis dengan ID kategori "Saving (Tabungan)"
});

// Cari ID kategori "Saving (Tabungan)"
const findSavingCategoryId = () => {
  const savingCategory = props.categories.find(category => category.name === 'Saving (Tabungan)');
  return savingCategory ? savingCategory.id : null;
};

// Buka modal tambah sub kategori
const openSubCategoryModal = () => {
  subCategoryForm.category_id = findSavingCategoryId(); // Setel kategori otomatis
  subCategoryModalOpen.value = true;
};

// Tutup modal tambah sub kategori
const closeSubCategoryModal = () => {
  subCategoryForm.reset();
  subCategoryModalOpen.value = false;
};

// Submit form tambah sub kategori
const submitSubCategoryForm = () => {
  subCategoryForm.post(route('sub-category.store'), {
    onSuccess: () => {
      closeSubCategoryModal();
    },
  });
};



const filteredSavings = computed(() => {
  return props.savings.filter(item => 
    item.category.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    item.sub_category?.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    item.note.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const paginatedSavings = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  const end = start + perPage.value;
  return filteredSavings.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredSavings.value.length / perPage.value));

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};

const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

const subCategoryBalances = computed(() => {
  const balances = {};
  props.savings.forEach(item => {
    if (!balances[item.sub_category_id] || new Date(item.date) > new Date(balances[item.sub_category_id].date)) {
      balances[item.sub_category_id] = {
        id: item.sub_category_id,
        name: item.sub_category?.name || 'Tanpa Sub Kategori',
        balance: item.balance,
        date: item.date,
      };
    }
  });
  return Object.values(balances);
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
</script>