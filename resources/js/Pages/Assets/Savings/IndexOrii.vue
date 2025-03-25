<template>
  <AppLayout title="Saving (Tabungan)">
    <div class="p-4">
      <!-- Tampilkan flash message jika ada -->
      <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ $page.props.flash.success }}
      </div>

      <div v-if="$page.props.flash.error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {{ $page.props.flash.error }}
      </div>

      <!-- Tampilkan Saldo per Sub Kategori -->
      <div class="mb-2">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
          <div v-for="subCategory in subCategoryBalances" :key="subCategory.id" class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-gray-700 font-medium">{{ subCategory.name }}</h3>
            <p class="text-2xl font-bold" :class="subCategory.balance < 0 ? 'text-red-600' : 'text-green-600'">
              {{ formatCurrency(subCategory.balance) }}
            </p>
          </div>
        </div>
      </div>

      <!-- Bagian Header: Tombol Tambah & Pencarian -->
      <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
        <!-- Tombol Tambah Sub Kategori -->
        <PrimaryButton @click="openSubCategoryModal">Tambah Kategori Tabungan</PrimaryButton>

        <!-- Pencarian -->
        <div class="relative">
          <TextInput 
            v-model="searchQuery" 
            placeholder="Cari Tabungan..." 
            class="pl-10 pr-4 py-2 border rounded-md w-64"
          />
          <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z" />
          </svg>
        </div>
      </div>

      <!-- Tabel Data -->
      <div class="mt-4 overflow-x-auto">
        <table class="min-w-full border bg-white rounded-lg shadow-md">
          <thead class="bg-gray-200">
            <tr>
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">Tanggal</th>
              <th class="px-4 py-2 text-left">Kategori</th>
              <th class="px-4 py-2 text-left">Catatan</th>
              <th class="px-4 py-2 text-left">Masuk</th>
              <th class="px-4 py-2 text-left">Keluar</th>
              <th class="px-4 py-2 text-left">Saldo</th>
              <th v-if="settings.btn_edit || settings.btn_delete" class="px-4 py-2 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in paginatedSavings" :key="item.id" class="border-b hover:bg-gray-100">
              <td class="px-4 py-2">{{ (currentPage - 1) * perPage + index + 1 }}</td>
              <td class="px-4 py-2">{{ item.date }}</td>
              <td class="px-4 py-2">{{ item.sub_category?.name || '-' }}</td>
              <td class="px-4 py-2">{{ item.note || '-' }}</td>
              <td class="px-4 py-2 text-green-600">
                {{ item.amount > 0 ? formatCurrency(item.amount) : '-' }}
              </td>
              <td class="px-4 py-2 text-red-600">
                {{ item.amount < 0 ? formatCurrency(Math.abs(item.amount)) : '-' }}
              </td>
              <td class="px-4 py-2">{{ formatCurrency(item.balance) }}</td>
              <td v-if="settings.btn_edit || settings.btn_delete" class="px-4 py-2 text-center">
                <SecondaryButton v-if="settings.btn_edit" @click="openModal('edit', item)">Edit</SecondaryButton>
                <PrimaryButton v-if="settings.btn_delete" class="ml-2 bg-red-600 hover:bg-red-700" @click="confirmDelete(item.id)">Hapus</PrimaryButton>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="flex justify-between items-center mt-4">
        <div class="flex items-center space-x-2">
          <select v-model="perPage" class="border rounded-md p-1 text-sm">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>
        <div class="flex space-x-2">
          <button 
            @click="prevPage" 
            :disabled="currentPage === 1" 
            class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 disabled:opacity-50"
          >
            back
          </button>
          <button 
            @click="nextPage" 
            :disabled="currentPage === totalPages" 
            class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 disabled:opacity-50"
          >
            next
          </button>
        </div>
      </div>

 <!-- Modal Tambah Sub Kategori -->
  <CustomModal :show="subCategoryModalOpen" title="Nama Kategori Tabungan" @close="closeSubCategoryModal">
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
          <PrimaryButton class="ml-3" type="submit">Simpan</PrimaryButton>
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

// Ambil props dari controller
const props = defineProps({
  savings: Array,
  categories: Array,
  subCategories: Array,
});

const settings = ref(usePage().props.settings);
const searchQuery = ref('');
const modalOpen = ref(false);
const subCategoryModalOpen = ref(false); // State untuk modal sub kategori
const isEditMode = ref(false);
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
      router.reload(); // Reload halaman untuk memperbarui data
    },
  });
};

// Filter tabungan berdasarkan pencarian
const filteredSavings = computed(() => {
  return props.savings.filter(item => 
    item.category.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    item.sub_category?.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    item.note.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

// Pagination
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

// Saldo per Sub Kategori (berdasarkan balance terbaru)
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

// Format jumlah uang ke dalam format mata uang
const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
  }).format(value || 0);
};
</script>