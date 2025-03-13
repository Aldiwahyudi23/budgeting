<template>
  <AppLayout title="Account Bank">
    <div class="p-4">
                <!-- Tampilkan flash message jika ada -->
    <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
      {{ $page.props.flash.success }}
    </div>

    <div v-if="$page.props.flash.error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
      {{ $page.props.flash.error }}
    </div>

      <!-- Bagian Header: Tombol Tambah & Pencarian -->
      <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
        <PrimaryButton @click="openModal('create')">Tambah Rekening Bank</PrimaryButton>
        <div class="relative">
          <TextInput 
            v-model="searchQuery" 
            placeholder="Cari Rekening Bank..." 
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
              <th class="px-4 py-2 text-left">Bank</th>
              <th class="px-4 py-2 text-left">Nominal</th>
              <th class="px-4 py-2 text-center">Status</th>
              <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in filteredAccountBanks" :key="item.id" class="border-b hover:bg-gray-100">
              <td class="px-4 py-2">{{ index + 1 }}</td>
              <td class="px-4 py-2">{{ item.name }}</td>
              <td class="px-4 py-2">{{ formatCurrency(item.amount) }}</td>
              <td class="px-4 py-2 text-center">
                <span v-if="item.is_active" class="px-2 py-1 text-green-700 bg-green-200 rounded-full text-sm">Aktif</span>
                <span v-else class="px-2 py-1 text-red-700 bg-red-200 rounded-full text-sm">Tidak Aktif</span>
              </td>
             <td class="px-4 py-2 text-center">
                <SecondaryButton v-if="settings.btn_edit" @click="openModal('edit', item)">Edit</SecondaryButton>
                <PrimaryButton class="ml-2 bg-blue-600 hover:bg-blue-700" @click="goToMutation(item.id)">Mutasi</PrimaryButton>
                <PrimaryButton class="ml-2 bg-green-600 hover:bg-green-700" @click="openWithdrawModal(item)">Tarik Tunai</PrimaryButton>
                <PrimaryButton v-if="settings.btn_delete" class="ml-2 bg-red-600 hover:bg-red-700" @click="confirmDelete(item.id)">Hapus</PrimaryButton>
            </td>
            </tr>
          </tbody>
        </table>
      </div>

<!-- Card Saldo Cash -->
<div class="mt-6 bg-white p-4 rounded-lg shadow-md">
  <div class="flex items-center justify-between">
    <div class="flex items-center">
      <div class="bg-purple-100 p-2 rounded-full">
        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <div class="ml-3">
        <h2 class="text-base font-semibold">Saldo Cash</h2>
        <p class="text-xl font-bold text-purple-600">{{ formatCurrency(cashBalance) }}</p>
        <Link :href="route('debits.index')" class="text-xs text-gray-500 hover:text-purple-600">Klik untuk melihat detail mutasi</Link>
      </div>
    </div>
    <PrimaryButton class="bg-green-600 hover:bg-green-700" @click="openDepositModal">Setor Tunai</PrimaryButton>
  </div>
</div>

      <!-- Modal Create / Edit -->
      <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Rekening Bank' : 'Tambah Rekening Bank'" @close="closeModal">
        <template #content>
          <form @submit.prevent="submitForm">
            <div class="mb-4">
              <InputLabel for="name">
                Nama Rekening Bank
                <span class="text-red-500 text-sm">*</span> <!-- Bintang merah kecil -->
              </InputLabel>
              <TextInput id="name" v-model="form.name" class="block w-full" />
              <InputError :message="form.errors.name" />
            </div>

            <div class="mb-4">
              <InputLabel for="description" value="Deskripsi" />
              <TextInput id="description" v-model="form.description" class="block w-full" />
              <InputError :message="form.errors.description" />
            </div>

            <div class="mb-4">
              <InputLabel for="amount" value="Nominal" />
              <TextInput
            id="amount"
            type="text"
            v-model="formattedAmount"
            @input="handleAmountInput"
            class="block w-full"
          />
              <InputError :message="form.errors.amount" />
            </div>

            <div class="flex items-center mb-4">
              <input type="checkbox" id="is_active" v-model="form.is_active" class="mr-2" />
              <label for="is_active">Aktif</label>
            </div>

            <div class="flex justify-end mt-4">
              <SecondaryButton type="button" @click="closeModal">Batal</SecondaryButton>
              <PrimaryButton class="ml-3" type="submit">{{ isEditMode ? 'Update' : 'Simpan' }}</PrimaryButton>
            </div>
          </form>
        </template>
      </CustomModal>

      <!-- Modal Tarik Tunai -->
    <CustomModal :show="withdrawModalOpen" title="Tarik Tunai " @close="closeWithdrawModal">
    <template #content>
        <form @submit.prevent="submitWithdrawForm">
        <div class="mb-4">
            <h2 class="text-lg font-semibold">{{ selectedBank?.name }} {{ formatCurrency(selectedBank?.amount) }}</h2>
        </div>

        <div class="mb-4">
            <InputLabel for="withdrawAmount">
              Nominal Yang Ditarik
              <span class="text-red-500 text-sm">*</span>
            </InputLabel>
            <TextInput
            id="withdrawAmount"
            type="text"
            v-model="formattedWithdrawAmount"
            @input="handleWithdrawAmountInput"
            class="block w-full"
          />
            <InputError :message="withdrawForm.errors.amount" />
        </div>

        <div class="mb-4">
            <InputLabel for="note" value="Catatan" />
            <TextInput id="note" v-model="withdrawForm.note" class="block w-full" />
            <InputError :message="withdrawForm.errors.note" />
        </div>

        <div class="flex justify-end mt-4">
            <SecondaryButton type="button" @click="closeWithdrawModal">Batal</SecondaryButton>
            <PrimaryButton class="ml-3" type="submit">Tarik/Pindah ke Cash</PrimaryButton>
        </div>
        </form>
    </template>
    </CustomModal>

    <!-- Modal Setor Tunai -->
<CustomModal :show="depositModalOpen" title="Setor Tunai" @close="closeDepositModal">
  <template #content>
    <form @submit.prevent="submitDepositForm">
      <div class="mb-4">
        <InputLabel for="bank_id">
           Pilih Bank Tujuan
          <span class="text-red-500 text-sm" >*</span>
          </InputLabel>
        <select id="bank_id" v-model="depositForm.bank_id" class="block w-full border rounded-md p-2">
          <option disabled value="">Pilih Bank</option>
          <option v-for="bank in accountBanks" :key="bank.id" :value="bank.id" :disabled="!bank.is_active" >{{ bank.name }} <span v-if="!bank.is_active">(Tidak Aktif)</span> </option>
        </select>
        <InputError :message="depositForm.errors.bank_id" />
      </div>

      <div class="mb-4">
        <InputLabel for="depositAmount">
          Nominal Setor Tunai
          <span class="text-red-500 text-sm" >*</span>
          </InputLabel>
<TextInput
            id="depositAmount"
            type="text"
            v-model="formattedDepositAmount"
            @input="handleDepositAmountInput"
            class="block w-full"
          />
        <InputError :message="depositForm.errors.amount" />
      </div>

      <div class="mb-4">
        <InputLabel for="note" value="Catatan" />
        <TextInput id="note" v-model="depositForm.note" class="block w-full" />
        <InputError :message="depositForm.errors.note" />
      </div>

      <div class="flex justify-end mt-4">
        <SecondaryButton type="button" @click="closeDepositModal">Batal</SecondaryButton>
        <PrimaryButton class="ml-3" type="submit">Setor/Pindah ke Bank</PrimaryButton>
      </div>
    </form>
  </template>
</CustomModal>

    </div>
  </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, reactive, computed } from 'vue';
import { useForm, usePage, router, Link } from '@inertiajs/vue3';
import CustomModal from '@/Components/CustomModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

// Ambil props dari controller
const props = defineProps({
  accountBanks: Array,
  cashBalance: Number,
});

// State untuk rekening bank (dapat diperbarui langsung)
const accountBanks = reactive([...props.accountBanks]);
const modalOpen = ref(false);
const isEditMode = ref(false);
const searchQuery = ref('');
const withdrawModalOpen = ref(false);
const depositModalOpen = ref(false);
const selectedBank = ref(null);

// Ambil data settings dari props
const settings = ref(usePage().props.settings);

// Filter rekening bank berdasarkan pencarian
const filteredAccountBanks = computed(() => {
  return accountBanks.filter(item => 
    item.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

// Form default (di-reset setiap kali modal dibuka)
const defaultForm = {
  id: '',
  name: '',
  description: '',
  amount: '', // Pastikan string kosong
  is_active: false,
  user_id: usePage().props.auth.user.id,
};

// Menggunakan form reaktif
const form = useForm({ ...defaultForm });

// Fungsi untuk memformat mata uang
const formatCurrency = (value) => {
  if (!value && value !== 0) return ''; // Handle null, undefined, atau empty string
  return new Intl.NumberFormat('id-ID').format(value);
};

// Fungsi untuk menghapus format mata uang
const parseCurrency = (value) => {
  if (!value) return '';
  return String(value).replace(/\./g, ''); // Pastikan string
};

// Computed property untuk form utama
const formattedAmount = computed({
  get: () => formatCurrency(form.amount),
  set: (value) => (form.amount = parseCurrency(value)),
});

const handleAmountInput = (event) => {
  const rawValue = String(event.target.value).replace(/\./g, ''); // Pastikan string
  form.amount = rawValue;
};

// Buka modal Create/Edit
const openModal = (mode, item = null) => {
  isEditMode.value = mode === 'edit';
  
  if (isEditMode.value && item) {
    form.id = item.id;
    form.name = item.name;
    form.description = item.description;
    form.amount = item.amount || '';
    form.is_active = Boolean(item.is_active);
  } else {
    form.reset(); // Reset data form ketika membuka modal Create
  }
  
  modalOpen.value = true;
};

// Tutup modal Create/Edit
const closeModal = () => {
  form.reset(); // Reset form saat modal ditutup
  modalOpen.value = false;
};

// Submit form Create/Edit
const submitForm = () => {
  if (isEditMode.value) {
    form.put(route('account-bank.update', form.id), {
      onSuccess: () => {
        // Perbarui rekening bank dalam state tanpa reload
        const index = accountBanks.findIndex((c) => c.id === form.id);
        if (index !== -1) {
          accountBanks[index] = { ...form.data() };
        }
        closeModal();
      }
    });
  } else {
    form.post(route('account-bank.store'), {
      onSuccess: (response) => {
        // Tambahkan rekening bank baru ke daftar tanpa reload
        accountBanks.unshift(response.props.accountBanks[0]);
        closeModal();
      }
    });
  }
};

// Konfirmasi hapus rekening bank
const confirmDelete = (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus rekening bank ini?')) {
    form.delete(route('account-bank.destroy', id), {
      onSuccess: () => {
        // Hapus dari daftar tanpa reload
        const index = accountBanks.findIndex((c) => c.id === id);
        if (index !== -1) {
          accountBanks.splice(index, 1);
        }
      }
    });
  }
};

// Form untuk tarik tunai
const withdrawForm = useForm({
  amount: '', // Pastikan string kosong
  note: '',
  bank_id: null,
});

const formattedWithdrawAmount = computed({
  get: () => formatCurrency(withdrawForm.amount),
  set: (value) => (withdrawForm.amount = parseCurrency(value)),
});

const handleWithdrawAmountInput = (event) => {
  const rawValue = String(event.target.value).replace(/\./g, ''); // Pastikan string
  withdrawForm.amount = rawValue;
};

// Buka modal tarik tunai
const openWithdrawModal = (bank) => {
  selectedBank.value = bank;
  withdrawForm.bank_id = bank.id;
  withdrawModalOpen.value = true;
};

// Tutup modal tarik tunai
const closeWithdrawModal = () => {
  withdrawForm.reset();
  withdrawModalOpen.value = false;
};

// Submit form tarik tunai
const submitWithdrawForm = () => {
  withdrawForm.post(route('account-bank.withdraw'), {
    onSuccess: () => {
      closeWithdrawModal();
      // Perbarui saldo cash dan rekening bank
      const index = accountBanks.findIndex((b) => b.id === selectedBank.value.id);
      if (index !== -1) {
        accountBanks[index].amount -= parseFloat(withdrawForm.amount);
      }
    },
  });
};

// Form untuk setor tunai
const depositForm = useForm({
  amount: '', // Pastikan string kosong
  note: '',
  bank_id: null,
});

const formattedDepositAmount = computed({
  get: () => formatCurrency(depositForm.amount),
  set: (value) => (depositForm.amount = parseCurrency(value)),
});

const handleDepositAmountInput = (event) => {
  const rawValue = String(event.target.value).replace(/\./g, ''); // Pastikan string
  depositForm.amount = rawValue;
};

// Buka modal setor tunai
const openDepositModal = () => {
  depositModalOpen.value = true;
};

// Tutup modal setor tunai
const closeDepositModal = () => {
  depositForm.reset();
  depositModalOpen.value = false;
};

// Submit form setor tunai
const submitDepositForm = () => {
  depositForm.post(route('account-bank.deposit'), {
    onSuccess: () => {
      closeDepositModal();
      // Perbarui saldo cash dan rekening bank
      const index = accountBanks.findIndex((b) => b.id === depositForm.bank_id);
      if (index !== -1) {
        accountBanks[index].amount += parseFloat(depositForm.amount);
      }
    },
  });
};

// Fungsi untuk mengarahkan ke halaman mutasi
const goToMutation = (id) => {
  router.visit(route('account-bank.mutation', id));
};
</script>