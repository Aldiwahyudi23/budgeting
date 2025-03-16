<template>
  <AppLayout title="Kelola Pinjaman">
    <div class="p-4">
      <div class="container mx-auto p-2">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-4 rounded-lg shadow-md mb-2">
          <div>
            <h1 class="text-xl font-semibold text-gray-800">Kelola Pinjaman</h1>
            <p class="text-sm text-gray-600 mt-1">
              Halaman ini digunakan untuk mengelola data pinjaman.
            </p>
          </div>
        </div>

        <!-- Cek Kategori Loan -->
        <div v-if="!loanCategoryExists" class="text-center bg-white p-6 rounded-lg shadow-md">
          <p class="text-gray-500 text-sm mb-4">
            Kategori "Loan (Pinjaman)" belum diaktifkan. Silakan aktifkan terlebih dahulu.
          </p>
          <PrimaryButton @click="activateLoanCategory">Aktifkan Kategori Loan</PrimaryButton>
        </div>

        <!-- Daftar Pinjaman -->
        <div v-else>
          <div v-if="loans.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div v-for="loan in loans" :key="loan.id" class="bg-white p-6 rounded-lg shadow-md">
              <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">{{ loan.name }}</h2>
                <span 
                  class="px-2 py-1 text-xs font-semibold rounded-lg"
                  :class="loan.status === 'active' ? 'bg-green-100 text-green-600' : loan.status === 'paid' ? 'bg-blue-100 text-blue-600' : 'bg-red-100 text-red-600'"
                >
                  {{ loan.status === 'active' ? 'Aktif' : loan.status === 'paid' ? 'Lunas' : 'Terlambat' }}
                </span>
              </div>
              <p class="text-sm text-gray-500">{{ loan.note || '-' }}</p>
              <p class="text-xl font-bold text-purple-600">Rp {{ formatCurrency(loan.amount) }}</p>
              <p class="text-sm text-gray-500">Jumlah Dibayar: Rp {{ formatCurrency(loan.paid_amount) }}</p>
              <p class="text-sm text-gray-500">Sisa: Rp {{ formatCurrency(loan.amount - loan.paid_amount) }}</p>

              <!-- Tombol Edit dan Lihat Detail -->
              <div class="mt-4 flex justify-between items-center">
                <PrimaryButton @click="openModal('edit', loan)">Edit</PrimaryButton>
                <a 
                  :href="route('loan.detail', { id: loan.id })" 
                  class="text-sm text-blue-500 hover:text-blue-700 underline"
                >
                  Lihat Detail
                </a>
              </div>
            </div>
          </div>

          <!-- Pesan Jika Tidak Ada Data -->
          <div v-else class="text-center bg-white p-2 rounded-lg shadow-md">
            <p class="text-gray-500 text-sm">Belum ada data pinjaman yang tercatat.</p>
          </div>
        </div>
      </div>

      <!-- Modal Edit Pinjaman -->
      <CustomModal :show="modalOpen" title="Edit Pinjaman" @close="closeModal">
        <template #content>
          <form @submit.prevent="submitForm">
            <div class="mb-4">
              <InputLabel for="name">
                Nama Pinjaman
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <TextInput id="name" v-model="form.name" class="block w-full" />
              <InputError :message="form.errors.name" />
            </div>

            <div class="mb-4">
              <InputLabel for="amount">
                Jumlah Pinjaman
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <TextInput id="amount" type="text" v-model="formattedAmount" @input="handleAmountInput" class="block w-full" />
              <InputError :message="form.errors.amount" />
            </div>

            <div class="mb-4">
              <InputLabel for="paid_amount">
                Jumlah Dibayar
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <TextInput id="paid_amount" type="text" v-model="formattedPaidAmount" @input="handlePaidAmountInput" class="block w-full" />
              <InputError :message="form.errors.paid_amount" />
            </div>

            <div class="mb-4">
              <InputLabel for="status">
                Status
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <select id="status" v-model="form.status" class="block w-full border rounded-md p-2">
                <option value="active">Aktif</option>
                <option value="paid">Lunas</option>
                <option value="overdue">Terlambat</option>
              </select>
              <InputError :message="form.errors.status" />
            </div>

            <div class="mb-4">
              <InputLabel for="note">
                Catatan
              </InputLabel>
              <TextInput id="note" v-model="form.note" class="block w-full" />
              <InputError :message="form.errors.note" />
            </div>

            <div class="flex justify-end mt-4">
              <SecondaryButton type="button" @click="closeModal">Batal</SecondaryButton>
              <PrimaryButton class="ml-3" type="submit">Update</PrimaryButton>
            </div>
          </form>
        </template>
      </CustomModal>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed, onMounted, watch } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import CustomModal from '@/Components/CustomModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

// Ambil props dari controller
const props = defineProps({
  loans: Array,
  categories: Array, // Daftar kategori yang dimiliki user
  user: Object, // Data user yang sedang login
});

// State untuk modal
const modalOpen = ref(false);

// Computed property untuk pengecekan kategori Loan
const loanCategoryExists = computed(() => {
  return props.categories.some(
    category => category.name.trim().toLowerCase() === 'loan (pinjaman)' && category.user_id === props.user.id
  );
});

// Form untuk edit Pinjaman
const form = useForm({
  id: null,
  name: '',
  amount: '',
  paid_amount: '',
  status: 'active',
  note: '',
});

// Format mata uang
const formatCurrency = (value) => {
  if (!value) return '';
  return new Intl.NumberFormat('id-ID').format(value);
};

// Parse mata uang (hapus tanda pemisah ribuan)
const parseCurrency = (value) => {
  if (!value) return '';
  return value.replace(/\./g, '');
};

// Computed property untuk format amount
const formattedAmount = computed({
  get: () => formatCurrency(form.amount),
  set: (value) => { form.amount = parseCurrency(value); }
});

// Computed property untuk format paid_amount
const formattedPaidAmount = computed({
  get: () => formatCurrency(form.paid_amount),
  set: (value) => { form.paid_amount = parseCurrency(value); }
});

// Buka modal edit
const openModal = (mode, loan = null) => {
  if (loan) {
    form.id = loan.id;
    form.name = loan.name;
    form.amount = loan.amount;
    form.paid_amount = loan.paid_amount;
    form.status = loan.status;
    form.note = loan.note;
  }
  modalOpen.value = true;
};

// Tutup modal
const closeModal = () => {
  form.reset();
  modalOpen.value = false;
};

// Submit form
const submitForm = () => {
  form.put(route('loans.update', form.id), {
    onSuccess: () => closeModal(),
  });
};

// Handle input amount
const handleAmountInput = (event) => {
  formattedAmount.value = event.target.value;
};

// Handle input paid_amount
const handlePaidAmountInput = (event) => {
  formattedPaidAmount.value = event.target.value;
};

// Aktifkan kategori Loan
const activateLoanCategory = () => {
  router.post(route('category.store'), {
    name: 'Loan (Pinjaman)',
    is_active: true,
    user_id: props.user.id, // Pastikan user_id disertakan
  }, {
    onSuccess: () => {
      window.location.reload(); // Refresh halaman untuk memuat ulang data
    },
    onError: (errors) => {
      console.error('Gagal menyimpan kategori:', errors); // Debugging
    }
  });
};
</script>


