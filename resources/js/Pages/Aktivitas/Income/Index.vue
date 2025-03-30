<template>
  <AppLayout title="Income">
    <div class="p-4">
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

      <!-- Catatan -->
      <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
        <p class="text-sm">
          Ini adalah halaman untuk melakukan semua transaksi pemasukan, termasuk kategori pemasukan seperti gaji, bonus, dan lainnya.
        </p>
      </div>

      <!-- Bagian Header: Tombol Tambah & Pencarian -->
      <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
        <!-- Tombol Tambah Pemasukan -->
        <PrimaryButton @click="openModal('create')">Tambah Pemasukan</PrimaryButton>

        <!-- Filter dan Pencarian -->
        <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
          <!-- Filter Tahun dan Bulan -->
          <div class="flex items-center space-x-4 w-full md:w-auto">
            <!-- Label Filter -->
            <span class="text-sm font-medium text-gray-700">Filter:</span>

            <!-- Filter Tahun -->
            <div class="flex-1 md:flex-none">
              <select id="year" v-model="selectedYear" class="block w-full border rounded-md p-2">
                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
              </select>
            </div>

            <!-- Filter Bulan -->
            <div class="flex-1 md:flex-none">
              <select id="month" v-model="selectedMonth" class="block w-full border rounded-md p-2">
                <option v-for="(month, index) in months" :key="index" :value="index + 1">{{ month }}</option>
              </select>
            </div>
          </div>

          <!-- Pencarian -->
          <div class="relative w-full md:w-64">
            <TextInput 
              v-model="searchQuery" 
              placeholder="Cari..." 
              class="pl-10 pr-4 py-2 border rounded-md w-full"
            />
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z" />
            </svg>
          </div>
        </div>
      </div>

      <!-- Tabel Data -->
      <div class="mt-4 overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full">
          <thead class="bg-gray-200">
            <tr>
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">Tanggal</th>
              <th class="px-4 py-2 text-left">Nominal</th>
              <th class="px-4 py-2 text-left">Sumber</th>
              <th class="px-4 py-2 text-left">Poin</th>
              <th class="px-4 py-2 text-left">Keterangan</th>
              <th class="px-4 py-2 text-left">Pembayaran</th>
              <th class="px-4 py-2 text-left">Rekening</th>
              <th v-if="settings.btn_edit || settings.btn_delete" class="px-4 py-2 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in paginatedIncomes" :key="item.id" class="border-b hover:bg-gray-100">
              <td class="px-4 py-2">{{ index + 1 }}</td>
              <td class="px-4 py-2">{{ item.date }}</td>
              <td class="px-4 py-2">{{ formatCurrency(item.amount) }}</td>
              <td class="px-4 py-2">{{ item.source.name }}</td>
              <td class="px-4 py-2">{{ item.sub_source?.name || '-' }}</td>
              <td class="px-4 py-2">{{ item.description || '-' }}</td>
              <td class="px-4 py-2">{{ item.payment }}</td>
              <td class="px-4 py-2">{{ item.account_bank?.name || 'Tunai' }}</td>
              <td v-if="settings.btn_edit || settings.btn_delete" class="px-4 py-2 text-center">
                <SecondaryButton v-if="settings.btn_edit" @click="openModal('edit', item)">Edit</SecondaryButton>
                <PrimaryButton v-if="settings.btn_delete" class="ml-2 bg-red-600 hover:bg-red-700" @click="confirmDelete(item.id)">Hapus</PrimaryButton>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="flex flex-col md:flex-row justify-between items-center mt-4 space-y-4 md:space-y-0">
        <div class="flex items-center space-x-4">
          <span class="text-sm text-gray-700">Menampilkan {{ paginatedIncomes.length }} dari {{ filteredIncomes.length }} data</span>
          <select v-model="itemsPerPage" class="border rounded-md p-2 text-sm">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>
        <div class="flex items-center space-x-4">
          <button 
            @click="previousPage" 
            :disabled="currentPage === 1" 
            class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 text-sm"
          >
            Sebelumnya
          </button>
          <span class="text-sm text-gray-700">Halaman {{ currentPage }} dari {{ totalPages }}</span>
          <button 
            @click="nextPage" 
            :disabled="currentPage === totalPages" 
            class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 text-sm"
          >
            Selanjutnya
          </button>
        </div>
      </div>

      <!-- Modal Create / Edit -->
      <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Pemasukan' : 'Tambah Pemasukan'" @close="closeModal">
        <template #content>
          <form @submit.prevent="submitForm">
            <!-- Form fields -->
            <div class="mb-4" v-if="settings.date_in">
              <InputLabel for="date" >
                Tanggal
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <TextInput id="date" type="date" v-model="form.date" class="block w-full" required />
              <InputError :message="form.errors.date" />
            </div>

            <div class="mb-4">
              <InputLabel for="amount">
                Nominal
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <TextInput id="amount" type="text" v-model="formattedAmount" @input="handleAmountInput" class="block w-full" />
              <InputError :message="form.errors.amount" />
            </div>

            <div class="mb-4">
              <InputLabel for="source_id">
                Sumber
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <select id="source_id" v-model="form.source_id" class="block w-full border rounded-md p-2" @change="form.sub_source_id = null">
                <option disabled value="">Pilih Sumber</option>
                <option v-for="source in sources" :key="source.id" :value="source.id" :disabled="!source.is_active">
                  {{ source.name }} <span v-if="!source.is_active">(Tidak Aktif)</span>
                </option>
              </select>
              <InputError :message="form.errors.source_id" />
            </div>

            <div class="mb-4">
              <InputLabel for="sub_source_id">
                Poin
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <select id="sub_source_id" v-model="form.sub_source_id" class="block w-full border rounded-md p-2" :disabled="!form.source_id">
                <option disabled value="">Pilih Keterangan</option>
                <option v-for="subSource in filteredSubSources" :key="subSource.id" :value="subSource.id" :disabled="!subSource.is_active">
                  {{ subSource.name }} <span v-if="!subSource.is_active">(Tidak Aktif)</span>
                </option>
              </select>
              <InputError :message="form.errors.sub_source_id" />
            </div>

            <div class="mb-4">
              <InputLabel for="description">
                Keterangan 
              </InputLabel>
              <TextInput id="description" type="text" v-model="form.description" class="block w-full" />
              <InputError :message="form.errors.description" />
            </div>
      <!-- Bagian yang diubah -->
            <div v-if="isSavingSource" class="mb-4 p-3 bg-blue-50 rounded-md">
              <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-1"></i>
                Nabung secara langsung: uang akan langsung tercatat di Account Bank sesuai pengaturan.
              </p>
            </div>

            <div v-else>
            <div class="mb-4">
              <InputLabel for="payment">
                Pembayaran
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <div class="flex space-x-4 mt-2">
                <label class="flex items-center" v-if="settings.bank" >
                  <input type="radio" v-model="form.payment" value="Transfer" class="mr-2" @change="form.account_id = ''" />
                  <span>Transfer</span>
                </label>
                <label class="flex items-center"  v-if="settings.cash">
                  <input type="radio" v-model="form.payment" value="Tunai" class="mr-2" @change="form.account_id = null" />
                  <span>Tunai</span>
                </label>
              </div>
              <InputError :message="form.errors.payment" />
            </div>

            <div class="mb-4" v-if="form.payment === 'Transfer'">
              <InputLabel for="account_id">
                Rekening Tujuan
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <select id="account_id" v-model="form.account_id" class="block w-full border rounded-md p-2" required>
                <option disabled value="">Pilih Rekening</option>
                <option v-for="account in accountBanks" :key="account.id" :value="account.id" :disabled="!account.is_active">
                  {{ account.name }} <span v-if="!account.is_active">(Tidak Aktif)</span>
                </option>
              </select>
              <InputError :message="form.errors.account_id" />
            </div>
            </div>
            <span v-if="!settings.bank && !settings.cash"  class="text-red-500">Untuk melanjutkan Transaksi Harap Pilih salah satu Pembayaran di Setting</span>

            <div class="flex justify-end mt-4">
              <SecondaryButton type="button" @click="closeModal">Batal</SecondaryButton>
              <PrimaryButton :disabled="!settings.bank && !settings.cash" class="ml-3" type="submit">{{ isEditMode ? 'Update' : 'Simpan' }}</PrimaryButton>
            </div>
          </form>
        </template>
      </CustomModal>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed, onMounted, watch, watchEffect } from 'vue';
import { useForm, router, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import CustomModal from '@/Components/CustomModal.vue';

const props = defineProps({
    incomes: Array,
    sources: Array,
    subSources: Array,
    accountBanks: Array,
});

const page = usePage();
const searchQuery = ref('');
const modalOpen = ref(false);
const isEditMode = ref(false);
const settings = ref(usePage().props.settings);

// Filter Tahun dan Bulan
const years = ref(Array.from({ length: 10 }, (_, i) => new Date().getFullYear() - i));
const months = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

const selectedYear = ref(new Date().getFullYear());
const selectedMonth = ref(new Date().getMonth() + 1);

// Pagination
const currentPage = ref(1);
const itemsPerPage = ref(10);

// Fungsi untuk memperbarui data dari backend jika diperlukan
const fetchData = () => {
    const params = { year: selectedYear.value, month: selectedMonth.value };
    router.get(route('income.index'), params, { preserveState: true, replace: true });
};

// Watch untuk memantau perubahan tahun dan bulan
watch([selectedYear, selectedMonth], () => {
    fetchData();
});


const filteredIncomes = computed(() => {
    return props.incomes.filter(item => {
        const date = new Date(item.date);
        const matchesYear = date.getFullYear() === selectedYear.value;
        const matchesMonth = date.getMonth() + 1 === selectedMonth.value;
        const matchesSearch = searchQuery.value
            ? item.source.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
              item.sub_source?.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
              item.payment.toLowerCase().includes(searchQuery.value.toLowerCase())
            : true; 

        return matchesYear && matchesMonth && matchesSearch;
    });
});

const isSavingSource = computed(() => {
  const selectedSource = props.sources.find(sou => sou.id === form.source_id);
  return selectedSource && selectedSource.name === 'Saving (Tabungan)';
});

const paginatedIncomes = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    const end = start + itemsPerPage.value;
    return filteredIncomes.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredIncomes.value.length / itemsPerPage.value));

const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
};

const previousPage = () => {
    if (currentPage.value > 1) currentPage.value--;
};

const form = useForm({
    id: '',
    date: '',
    amount: '',
    source_id: '',
    sub_source_id: null,
    payment: '',
    account_id: null,
    description: null,
});

const filteredSubSources = computed(() => {
    return props.subSources.filter(sub => sub.source_id === form.source_id);
});

const formatCurrency = (value) => {
    if (!value) return '';
    return new Intl.NumberFormat('id-ID').format(value);
};

const parseCurrency = (value) => {
    if (!value) return '';
    return value.replace(/\./g, '');
};

const formattedAmount = computed({
    get: () => formatCurrency(form.amount),
    set: (value) => { form.amount = parseCurrency(value); }
});

watchEffect(() => {
    formattedAmount.value = formatCurrency(form.amount);
});

const openModal = (mode, item = null) => {
    isEditMode.value = mode === 'edit';
    if (isEditMode.value && item) {
        form.id = item.id;
        form.date = item.date;
        form.amount = item.amount;
        form.source_id = item.source_id;
        form.sub_source_id = item.sub_source_id;
        form.payment = item.payment;
        form.account_id = item.account_id;
        form.description = item.description;
    } else {
        form.reset();
    }
    modalOpen.value = true;
};

const closeModal = () => {
    form.reset();
    modalOpen.value = false;
};

const submitForm = () => {
    // Jika source adalah Saving, set nilai default
  if (isSavingSource.value) {
    form.payment = 'Transfer';
  }

    if (isEditMode.value) {
        form.put(route('income.update', form.id), { onSuccess: () => closeModal() });
    } else {
        form.post(route('income.store'), { onSuccess: () => closeModal() });
    }
};

const confirmDelete = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus pemasukan ini?')) {
        router.delete(route('income.destroy', id), {
            onSuccess: () => {
                const index = props.incomes.findIndex((e) => e.id === id);
                if (index !== -1) {
                    props.incomes.splice(index, 1);
                }
            },
            onError: () => { alert('Gagal menghapus pemasukan. Silakan coba lagi.'); },
        });
    }
};

onMounted(() => {
  if (settings.value.saving_expense) {
    console.log(savingSubCategories.value);
  }
});
</script>

<style scoped>
/* Style untuk alert */
.alert {
  position: fixed;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 1000;
  max-width: 90%;
  width: 400px;
  padding: 1rem;
  border-radius: 8px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Style untuk tombol close */
.close-button {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1.25rem;
  color: inherit;
  padding: 0;
  margin-left: 1rem;
}

/* Style untuk alert success */
.alert-success {
  background-color: #f0fdf4;
  border-color: #4ade80;
  color: #166534;
}

/* Style untuk alert error */
.alert-error {
  background-color: #fef2f2;
  border-color: #f87171;
  color: #991b1b;
}
</style>