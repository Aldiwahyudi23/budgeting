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
          <!-- Tombol untuk menampilkan/sembunyikan hutang selesai -->
          <div v-if="inactiveDebts.length > 0" class="mt-2 sm:mt-0">
            <a 
              @click="toggleInactiveDebts" 
              class="text-sm text-blue-500 hover:text-blue-700 cursor-pointer"
            >
              {{ showInactiveDebts ? 'Sembunyikan Hutang Selesai' : 'Lihat Hutang Selesai' }}
            </a>
          </div>
        </div>

       

            <!-- Daftar Hutang Selesai (Paid) -->
        <div v-if="showInactiveDebts && paidDebts.length > 0" class="mt-4">
          <h2 class="text-lg font-semibold mb-4">Hutang yang Sudah Dibayar</h2>
          <div class="bg-white p-4 rounded-lg shadow-md">
            <div 
              v-for="loan in paidDebts" 
              :key="loan.id" 
              class="flex justify-between items-center py-2 border-b last:border-b-0 cursor-pointer hover:bg-gray-50"
              @click="goToDebtStory(loan.id)"
            >
              <span class="text-gray-800">{{ loan.sub_category?.name || 'Tanpa Kategori' }} </span>
              <span class="text-purple-600 font-semibold">Rp {{ formatCurrency(loan.amount) }}</span>

            </div>
          </div>
        </div>

        <!-- Cek Kategori Loan -->
        <div v-if="!loanCategoryExists" class="text-center bg-white p-6 rounded-lg shadow-md mt-4">
          <p class="text-gray-500 text-sm mb-4">
            Kategori "Loan (Pinjaman)" belum diaktifkan. Silakan aktifkan terlebih dahulu.
          </p>
          <PrimaryButton @click="activateLoanCategory">Aktifkan Kategori Loan</PrimaryButton>
        </div>

        <!-- Daftar Pinjaman Aktif -->
          <div v-else>
          <div v-if="activeDebts.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            <div v-for="loan in activeDebts" :key="loan.id" class="bg-white p-6 rounded-lg shadow-md">
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
                  :href="route('loans.show', { id: loan.id })" 
                  class="text-sm text-blue-500 hover:text-blue-700 underline"
                >
                  Lihat Detail
                </a>
              </div>
            </div>
          </div>

          <!-- Pesan Jika Tidak Ada Data -->
          <div v-else class="text-center bg-white p-2 rounded-lg shadow-md">
            <p class="text-gray-500 text-sm">Belum ada data pinjaman aktif yang tercatat.</p>
          </div>
          </div>

        

        <!-- Informasi Tambahan -->
        <div class="mt-4 bg-gray-100 p-2 rounded-lg shadow-md">
          <h2 class="text-lg font-semibold text-gray-800">Informasi Mengenai Pinjaman</h2>
          <p class="text-sm text-gray-600 mt-2">
            Halaman ini digunakan untuk mengelola data pinjaman, baik pinjaman aktif maupun yang sudah lunas. Berikut cara menambahkan dan mengelola pinjaman:
          </p>
          <ul class="text-sm text-gray-600 mt-2 list-disc list-inside">
            <li>
              <strong>Aktifkan Kategori Pinjaman</strong>:
              <ul class="list-circle list-inside ml-4">
                <li>Jika kategori "Loan (Pinjaman)" belum aktif, klik tombol "Aktifkan Kategori Loan" di atas.</li>
              </ul>
            </li>
            <li>
              <strong>Menambahkan Pinjaman</strong>:
              <ul class="list-circle list-inside ml-4">
                <li>Pinjaman dapat ditambahkan melalui halaman <strong>Transaksi Pengeluaran (Expenses)</strong>.</li>
                <li>Pilih kategori <strong>Loan (Pinjaman)</strong>.</li>
                <li>Masukkan nama peminjam dan nominal pinjaman.</li>
              </ul>
            </li>
            <li>
              <strong>Pembayaran Pinjaman</strong>:
              <ul class="list-circle list-inside ml-4">
                <li>Pembayaran dilakukan melalui halaman <strong>Transaksi Pemasukan (Income)</strong>.</li>
                <li>Pilih sumber <strong>Pinjaman</strong> dan pilih nama peminjam.</li>
                <li>Masukkan nominal pembayaran.</li>
              </ul>
            </li>
            <li>
              <strong>Status Pinjaman</strong>:
              <ul class="list-circle list-inside ml-4">
                <li>Pinjaman dengan status <strong>Aktif</strong> akan ditampilkan di halaman ini.</li>
                <li>Pinjaman yang sudah lunas atau tidak aktif dapat dilihat di bawah dengan mengklik "Lihat Hutang Selesai".</li>
              </ul>
            </li>
          </ul>
          <p class="text-sm text-gray-600 mt-2">
            Pastikan untuk selalu memperbarui data pinjaman setelah melakukan transaksi pembayaran agar status pinjaman tetap akurat.
          </p>
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
              <TextInput id="name" v-model="form.name" class="block w-full" disabled />
              <InputError :message="form.errors.name" />
            </div>

            <div class="mb-4">
              <InputLabel for="amount">
                Jumlah Pinjaman
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <TextInput id="amount" type="text" v-model="formattedAmount" @input="handleAmountInput" class="block w-full" disabled />
              <InputError :message="form.errors.amount" />
            </div>

            <div class="mb-4">
              <InputLabel for="paid_amount">
                Jumlah Dibayar
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <TextInput id="paid_amount" type="text" v-model="formattedPaidAmount" @input="handlePaidAmountInput" class="block w-full" disabled />
              <InputError :message="form.errors.paid_amount" />
            </div>

            <div class="mb-4">
              <InputLabel for="status">
                Status
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <select id="status" v-model="form.status" class="block w-full border rounded-md p-2" disabled>
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
import { ref, computed } from 'vue';
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
  debts: Array, // Data hutang
});

// State untuk modal
const modalOpen = ref(false);

// State untuk menampilkan/sembunyikan hutang selesai
const showInactiveDebts = ref(false);

// Computed property untuk pengecekan kategori Loan
const loanCategoryExists = computed(() => {
  return props.categories.some(
    category => {
      const categoryName = category.name.trim().toLowerCase();
      const expectedName = 'Loan (Pinjaman)'.toLowerCase();
      return categoryName === expectedName && category.user_id === props.user.id;
    }
  );
});

// Filter data hutang yang sudah dibayar (status paid)
// Filter data berdasarkan status
const activeDebts = computed(() => props.loans.filter(loan => loan.status === 'active'));
const inactiveDebts = computed(() => props.loans.filter(loan => loan.status !== 'active'));
const paidDebts = computed(() => props.loans.filter(loan => loan.status === 'paid'));

// Toggle tampilan data hutang selesai
const toggleInactiveDebts = () => {
  showInactiveDebts.value = !showInactiveDebts.value;
};

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
  } else {
    form.reset();
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
  const categoryData = {
    name: 'Loan (Pinjaman)',
    is_active: true,
    user_id: props.user.id, // Pastikan user_id disertakan
  };

  const sourceData = {
    name: 'Loan (Pinjaman)',
    is_active: true,
    user_id: props.user.id, // Pastikan user_id disertakan
  };

  // Kirim kedua permintaan secara paralel
  Promise.all([
    router.post(route('category.store'), categoryData),
    router.post(route('source.store'), sourceData),
  ])
    .then(() => {
      window.location.reload(); // Refresh halaman untuk memuat ulang data
    })
    .catch((errors) => {
      console.error('Gagal menyimpan data:', errors); // Debugging
    });
};
</script>