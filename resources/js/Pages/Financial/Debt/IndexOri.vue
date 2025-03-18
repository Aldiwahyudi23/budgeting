<template>
  <AppLayout title="Kelola Hutang">
    <div class="p-4">
        <!-- Tampilkan flash message jika ada -->
    <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
      {{ $page.props.flash.success }}
    </div>

    <div v-if="$page.props.flash.error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
      {{ $page.props.flash.error }}
    </div>

      <div class="container mx-auto p-2">
        <!-- Header & Tombol Tambah -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-4 rounded-lg shadow-md mb-2">
          <div>
            <h1 class="text-xl font-semibold text-gray-800">Kelola Hutang</h1>
            <p class="text-sm text-gray-600 mt-1">
              Halaman ini digunakan untuk mengelola dan menambahkan data hutang seperti hutang pribadi, cicilan, atau hutang bisnis.
            </p>
            <!-- Link untuk membuka data tidak aktif (Desktop/Tablet) -->
            <div v-if="inactiveDebts.length > 0" class="mt-6 text-ligth hidden sm:block">
              <a 
                @click="toggleInactiveDebts" 
                class="text-sm text-blue-500 hover:text-blue-700 cursor-pointer"
              >
                {{ showInactiveDebts ? 'Sembunyikan Hutang Selesai' : 'Lihat Hutang Selesai' }}
              </a>
            </div>
          </div>
          <div class="flex items-center gap-2 mt-4 sm:mt-0">
            <PrimaryButton @click="openModal('create')">Tambah Hutang</PrimaryButton>
            <!-- Link untuk membuka data tidak aktif (hanya tampil jika ada data tidak aktif) -->
            <a 
              v-if="inactiveDebts.length > 0" 
              @click="toggleInactiveDebts" 
              class="text-sm text-blue-500 hover:text-blue-700 cursor-pointer sm:hidden text-right"
            >
              {{ showInactiveDebts ? 'Sembunyikan Hutang Selesai' : 'Lihat Hutang Selesai' }}
            </a>
          </div>
        </div>

        <!-- List Data yang Sudah Paid -->
        <div v-if="showInactiveDebts && paidDebts.length > 0">
          <h2 class="text-lg font-semibold mb-4">Hutang yang Sudah Dibayar</h2>
          <div class="bg-white p-4 rounded-lg shadow-md">
            <div 
              v-for="debt in paidDebts" 
              :key="debt.id" 
              class="flex justify-between items-center py-2 border-b last:border-b-0 cursor-pointer hover:bg-gray-50"
              @click="goToDebtStory(debt.id)"
            >
              <span class="text-gray-800">{{ debt.sub_category?.name || 'Tanpa Kategori' }} ({{ debt.type == 'installment' ? 'Kredit/Cicilan' : debt.type }})</span>
              <span class="text-purple-600 font-semibold">Rp {{ formatCurrency(debt.amount) }}</span>
            </div>
          </div>
        </div>

        <!-- Daftar Hutang Aktif -->
        <div v-if="activeDebts.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
          <div v-for="debt in activeDebts" :key="debt.id" class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between">
              <h2 class="text-lg font-semibold">{{ debt.sub_category?.name || 'Tanpa Kategori' }}  
                <span class="text-gray-500 text-sm">({{ debt.type == 'installment' ? 'Kredit/Cicilan' : debt.type }})</span>
              </h2>
              <span 
                class="px-2 py-1 text-xs font-semibold rounded-lg"
                :class="debt.sub_category?.is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'"
              >
                {{ debt.sub_category?.is_active ? 'Aktif' : 'Tidak Aktif' }}
              </span>
            </div>
            <p class="text-sm text-gray-500">{{ debt.note }}</p>
            <p class="text-xl font-bold text-purple-600">Rp {{ formatCurrency(debt.amount) }}</p>

            <!-- Tampilkan paid_amount jika tipe personal -->
            <p v-if="debt.type === 'personal'" class="text-sm text-gray-500">
              Pembayaran = {{ formatCurrency(debt.paid_amount) }}
            </p>

            <!-- Tampilkan Tenor jika tipe installment -->
            <p v-if="debt.type === 'installment'" class="text-sm text-gray-500">
              Tenor = {{ getTenor(debt) }}
            </p>

            <p v-if="debt.type === 'installment'" class="text-sm text-gray-500">Tanggal Jatuh Tempo: {{ formatDate(debt.due_date) }}</p>

            <!-- Pesan Reminder -->
            <p v-if="debt.reminder" class="text-sm text-green-500">
              Hutang ini di set Pengingat dan akan diingatkan selalu.
            </p>

              <!-- Tombol Edit, Hapus, dan History Pembayaran -->
            <div class="mt-4 flex justify-between items-center">
              <div class="flex space-x-2">
                <PrimaryButton @click="openModal('edit', debt)">Edit</PrimaryButton>
                <!-- <PrimaryButton class="bg-red-600 hover:bg-red-700" @click="confirmDelete(debt.id)">Hapus</PrimaryButton> -->
              </div>
              <a 
                :href="route('history_pembayaran_debt', { id: debt.id })" 
                class="text-sm text-blue-500 hover:text-blue-700 underline"
              >
                History Pembayaran
              </a>
            </div>
          </div>
        </div>

        <!-- Pesan Jika Tidak Ada Data -->
        <div v-else class="text-center bg-white p-2 rounded-lg shadow-md mt-4">
          <p class="text-gray-500 text-sm">Belum ada hutang yang tercatat. Silakan tambahkan hutang baru.</p>
        </div>

        <!-- Informasi Tambahan -->
        <div class="mt-4 bg-gray-100 p-2 rounded-lg shadow-md">
          <h2 class="text-lg font-semibold text-gray-800">Informasi Mengenai Hutang</h2>

            <p class="text-sm text-gray-600 mb-4">
              Halaman ini digunakan untuk mencatat semua hutang, baik hutang perorangan maupun hutang bertenor seperti kredit atau cicilan. Berikut cara menambahkan hutang:
            </p>
            <ul class="text-sm text-gray-600 list-disc list-inside mb-6">
              <li>Klik tombol di atas kanan untuk menambahkan hutang baru.</li>
              <li>Pilih nama hutang (misal: "Hutang ke Ahmad" atau "Kredivo").</li>
              <li>Tambahkan catatan (opsional).</li>
              <li>Masukkan nominal:
                <ul class="list-circle list-inside ml-4">
                  <li><strong>Personal</strong>: Masukkan total hutang.</li>
                  <li><strong>Cicilan</strong>: Masukkan cicilan per bulannya.</li>
                </ul>
              </li>
              <li>Pilih jenis hutang: <strong>Personal</strong> atau <strong>Cicilan</strong>.</li>
              <li>Jika memilih <strong>Cicilan</strong>, tentukan tanggal jatuh tempo dan tenor (dalam bulan).</li>
              <li>Aktifkan hutang untuk memulai pencatatan.</li>
              <li>Pilih mode pembayaran:
                <ul class="list-circle list-inside ml-4">
                  <li><strong>Reminder</strong>: Dapatkan pengingat sebelum jatuh tempo.</li>
                </ul>
              </li>
            </ul>

          <p class="text-sm text-gray-600 mt-2">
            Untuk pembayaran atau transaksi, silakan lakukan melalui halaman 
            <strong>Transaksi Pengeluaran (Expenses)</strong>. 
            Pilih kategori <strong>Hutang</strong> dan tambahkan keterangan sesuai jenis hutang yang dibayarkan.
          </p>
        </div>
      </div>

      <!-- Modal Tambah/Edit Hutang -->
      <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Hutang' : 'Tambah Hutang'" @close="closeModal">
        <template #content>
          <form @submit.prevent="submitForm">
            <div class="mb-4">
              <InputLabel for="name">
                Nama Hutang
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <TextInput id="name" v-model="form.name" class="block w-full" :disabled="isEditMode" :readonly="isEditMode"/>
              <InputError :message="form.errors.name" />
            </div>

            <div class="mb-4">
              <InputLabel for="amount">
                Nominal Hutang
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <TextInput id="amount" type="text" v-model="formattedAmount" @input="handleAmountInput" class="block w-full" />
              <InputError :message="form.errors.amount" />
            </div>

            <div class="mb-4">
              <InputLabel for="note">
                Catatan
              </InputLabel>
              <TextInput id="note" v-model="form.note" class="block w-full" />
              <InputError :message="form.errors.note" />
            </div>

            <div class="mb-4">
              <InputLabel for="type">
                Type Hutang
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <select id="type" v-model="form.type" class="block w-full">
                <option disabled value="">Pilih Tipe</option>
                <option value="personal">Personal</option>
                <option value="installment">Cicilan</option>
              </select>
              <InputError :message="form.errors.type" />
            </div>

            <div v-if="form.type === 'installment'" class="mb-4">
              <InputLabel for="due_date">
                Tanggal Jatuh Tempo
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <select id="due_date" v-model="form.due_date" class="block w-full" required>
                <option v-for="day in 31" :key="day" :value="day">{{ day }}</option>
              </select>
              <InputError :message="form.errors.due_date" />
            </div>

            <div v-if="form.type === 'installment'" class="mb-4">
              <InputLabel for="tenor_months">
                Tenor (Bulan)
                <span class="text-red-500 text-sm">*</span>
              </InputLabel>
              <select id="tenor_months" v-model="form.tenor_months" class="block w-full" required>
                <option v-for="month in 12" :key="month" :value="month">{{ month }}</option>
              </select>
              <InputError :message="form.errors.tenor_months" />
            </div>

            <div class="mb-4">
              <label class="flex items-center">
                <input type="checkbox" v-model="form.is_active" class="mr-2" />
                <span>Status</span>  
              </label>
              <p class="text-sm text-gray-500">Jika Aktif akan bisa Transaksi</p>
            </div>

            <div class="mb-4">
              <label class="flex items-center">
                <input type="checkbox" v-model="form.reminder" class="mr-2" />
                <span>Pengingat</span>  
              </label>
              <p class="text-sm text-gray-500">Akan diingatkan H-1 dari Tanggal</p>
            </div>

           

            <div class="flex justify-end mt-4">
              <SecondaryButton type="button" @click="closeModal">Batal</SecondaryButton>
              <PrimaryButton class="ml-3" type="submit">{{ isEditMode ? 'Update' : 'Simpan' }}</PrimaryButton>
            </div>
          </form>
        </template>
      </CustomModal>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, reactive, computed, watch, watchEffect } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import CustomModal from '@/Components/CustomModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

// Ambil props dari controller
const props = defineProps({
  debts: Array,
});

// State untuk modal
const modalOpen = ref(false);
const isEditMode = ref(false);
const showInactiveDebts = ref(false); // Tambahan state untuk toggle data tidak aktif

// Form untuk tambah/edit Debt
const form = useForm({
  id: null,
  name: '',
  amount: '',
  note: '',
  type: '',
  due_date: null,
  tenor_months: null,
  is_active: false,
  reminder: false,
});

// Buka modal
const openModal = (mode, debt = null) => {
  isEditMode.value = mode === 'edit';
  if (isEditMode.value && debt) {
    form.id = debt.id;
    form.name = debt.sub_category?.name || '';
    form.note = debt.note;
    form.amount = debt.amount; // Format sebelum ditampilkan
    form.type = debt.type;
    form.due_date = debt.due_date;
    form.tenor_months = debt.tenor_months;
    form.reminder = Boolean(debt.reminder);
    form.is_active = Boolean(debt.sub_category?.is_active || false);
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
  if (isEditMode.value) {
    form.put(route('debts.update', form.id), {
      onSuccess: () => {
        closeModal();
      },
      onError: (errors) => {
        // Tangani error validasi
        console.error('Error saat mengupdate data:', errors);
      },
      onFinish: () => {
        // Pastikan modal tertutup meskipun ada error
        closeModal();
      },
    });
  } else {
    form.post(route('debts.store'), {
      onSuccess: () => {
        closeModal();
      },
      onError: (errors) => {
        // Tangani error validasi
        console.error('Error saat menyimpan data:', errors);
      },
      onFinish: () => {
        // Pastikan modal tertutup meskipun ada error
        closeModal();
      },
    });
  }
};
// Konfirmasi hapus
const confirmDelete = (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus bill ini?')) {
    router.delete(route('debts.destroy', id));
  }
};


// Filter data berdasarkan status
const activeDebts = computed(() => props.debts.filter(debt => debt.status === 'active'));
const inactiveDebts = computed(() => props.debts.filter(debt => debt.status !== 'active'));
const paidDebts = computed(() => props.debts.filter(debt => debt.status === 'paid'));

// Format mata uang
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


// Format tanggal
const formatDate = (date) => {
  if (!date) return "";
  const parsedDate = new Date(date);
  return parsedDate.getDate();
};

// Fungsi untuk mendapatkan Tenor (hanya untuk tipe installment)
const getTenor = (debt) => {
  if (debt.type === 'installment' && debt.expenses) {
    const paidTenor = debt.expenses.length;
    return `${paidTenor}-${debt.tenor_months}`;
  }
  return '';
};

// Toggle tampilan data tidak aktif
const toggleInactiveDebts = () => {
  showInactiveDebts.value = !showInactiveDebts.value;
};


const goToDebtStory = (debtId) => {
  router.visit(route('history_pembayaran_debt', { id: debtId }));
};
</script>