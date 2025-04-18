<template>
  <AppLayout title="Kelola Bill">
    <div class="p-4">
  <div class="container mx-auto p-2">
    <!-- Header & Tombol Tambah -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-4 rounded-lg shadow-md mb-2">
  <div>
    <h1 class="text-xl font-semibold text-gray-800">Kelola Tagihan Bulanan</h1>
    <p class="text-sm text-gray-600 mt-1">
      Halaman ini digunakan untuk mengelola dan menambahkan data tagihan bulanan seperti 
      listrik, internet, dan tagihan rutin lainnya.
    </p>
  </div>
  
  <div class="flex flex-col sm:flex-row items-center gap-4 mt-4 sm:mt-0">
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm font-semibold shadow">
      💰 Total Tagihan Aktif: {{ formatCurrency(totalActiveBills) }}
    </div>
    <PrimaryButton @click="openModal('create')">Tambah Bill (Tagihan)</PrimaryButton>
  </div>
</div>


    <!-- Daftar Bill -->
    <div v-if="bills.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div v-for="bill in bills" :key="bill.id" class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center justify-between">
          <h2 class="text-lg font-semibold">{{ bill.sub_category?.name || 'Tanpa Kategori' }}</h2>
          <span 
            class="px-2 py-1 text-xs font-semibold rounded-lg"
            :class="bill.sub_category?.is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'"
          >
            {{ bill.sub_category?.is_active ? 'Aktif' : 'Tidak Aktif' }}
          </span>
        </div>
        <p class="text-sm text-gray-500">{{ bill.note }}</p>
        <p class="text-xl font-bold text-purple-600">Rp {{ formatCurrency(bill.amount) }}</p>
        <p class="text-sm text-gray-500">Tanggal Batas Akhir : {{ formatDate(bill.date) }}</p>

        <!-- Pesan Reminder -->
        <p v-if="bill.reminder" class="text-sm text-green-500">
          Tagihan ini di set Pengingat dan akan diingatkan selalu.
        </p>
        <p v-if="bill.auto" class="text-sm text-blue-500">
          Setiap tanggal jatuh tempo, tagihan akan otomatis tersimpan ke data dan mengurangi saldo {{ bill.account_bank.name }}.
        </p>

        <!-- Tombol Edit, Hapus, dan History Pembayaran -->
        <div class="mt-4 flex justify-between items-center">
          <div class="flex space-x-2">
            <PrimaryButton @click="openModal('edit', bill)">Edit</PrimaryButton>
            <!-- <PrimaryButton class="bg-red-600 hover:bg-red-700" @click="confirmDelete(bill.id)">Hapus</PrimaryButton> -->
          </div>
          <a 
            :href="route('history_pembayaran_bill', { id: bill.id })" 
            class="text-sm text-blue-500 hover:text-blue-700 underline"
          >
            History Pembayaran
          </a>
        </div>
      </div>
    </div>

    <!-- Pesan Jika Tidak Ada Data -->
    <div v-else class="text-center bg-white p-2 rounded-lg shadow-md">
      <p class="text-gray-500 text-sm">Belum ada tagihan yang tercatat. Silakan tambahkan tagihan baru.</p>
    </div>

    <!-- Informasi Tambahan -->
    <div class="mt-4 bg-gray-100 p-2 rounded-lg shadow-md">
      <h2 class="text-lg font-semibold text-gray-800">Informasi Mengenai Tagihan</h2>
        <p class="text-sm text-gray-600 mt-2">
          Halaman ini digunakan untuk mencatat tagihan bulanan yang harus dibayar setiap bulannya, seperti bayar kost, listrik, wifi, atau tagihan rutin lainnya. Berikut cara menambahkan tagihan:
        </p>
        <ul class="text-sm text-gray-600 mt-2 list-disc list-inside">
          <li>Klik tombol di atas kanan untuk menambahkan tagihan baru.</li>
          <li>Isi nama tagihan (contoh: "Bayar Listrik").</li>
          <li>Masukkan nominal tagihan.</li>
          <li>Pilih tanggal jatuh tempo.</li>
          <li>Pilih mode pembayaran:
            <ul class="list-circle list-inside ml-4">
              <li><strong>Auto</strong>: Jika pembayaran dilakukan otomatis (misalnya melalui admin bank).</li>
              <li><strong>Pengingat</strong>: Untuk mendapatkan notifikasi sebelum jatuh tempo.</li>
            </ul>
          </li>
          <li>Klik "Tambahkan" untuk menyimpan tagihan.</li>
        </ul>
      <p class="text-sm text-gray-600 mt-2">
        Untuk pembayaran atau transaksi, silakan lakukan melalui halaman 
        <strong>Transaksi Pengeluaran (Expenses)</strong>. 
        Pilih kategori <strong>Bill (Tagihan)</strong> dan tambahkan keterangan sesuai jenis tagihan yang dibayarkan.
      </p>
    </div>
  </div>


      <!-- Modal Tambah/Edit Bill -->
      <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Bill (Tagihan)' : 'Tambah Bill (Tagihan)'" @close="closeModal">
        <template #content>
          <form @submit.prevent="submitForm">
            <div class="mb-4">
            <InputLabel for="name">
              Nama Bill (Tagihan)
              <span class="text-red-500 text-sm" >*</span>
              </InputLabel>
            <TextInput id="name" v-model="form.name" class="block w-full" :disabled="isEditMode" :readonly="isEditMode"/>
            <InputError :message="form.errors.name" />
          </div>

            <div class="mb-4">
              <InputLabel for="note" >
              Catatan
             
              </InputLabel>
              <TextInput id="note" v-model="form.note" class="block w-full" />
              <InputError :message="form.errors.note" />
            </div>

            <div class="mb-4">
              <InputLabel for="amount" >
              Nominal Tagihan
              <span class="text-red-500 text-sm" >*</span>
              </InputLabel>
               <TextInput id="amount" type="text" v-model="formattedAmount" @input="handleAmountInput" class="block w-full" />
              <InputError :message="form.errors.amount" />
            </div>

            <div class="mb-4">
              <InputLabel for="date" >
              Tanggal Tagihan
              <span class="text-red-500 text-sm" >*</span>
              </InputLabel>
              <TextInput id="date" type="date" v-model="form.date" class="block w-full"  />
              <InputError :message="form.errors.date" />
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
        <input
          type="checkbox"
          v-model="form.reminder"
          class="mr-2"
          :disabled="!form.is_active"
        />
        <span>Pengingat</span>
      </label>
      <p class="text-sm text-gray-500">Akan diingatkan H-1 dari Tanggal</p>
    </div>

    <div class="mb-4">
      <label class="flex items-center">
        <input
          type="checkbox"
          v-model="form.auto"
          class="mr-2"
          :disabled="!form.is_active"
        />
        <span>Otomatis</span>
      </label>
      <p class="text-sm text-gray-500">Secara Otomatis Masuk data sesuai tanggal</p>
    </div>
            <div class="mb-4" v-if="form.auto === true">
              <InputLabel for="account_id">
                Sumber Rekening
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
import { ref, computed, watch, watchEffect } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import CustomModal from '@/Components/CustomModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

// Ambil props dari controller
const props = defineProps({
  bills: Array,
  accountBanks: Array,
  totalActiveBills:Number,
});

// State untuk modal
const modalOpen = ref(false);
const isEditMode = ref(false);

// Form untuk tambah/edit Bill
const form = useForm({
  id: null,
  name: '',
  note: '',
  amount: '',
  balance: '',
  date: '',
  reminder: false,
  auto: false,
  is_active: false,
  account_id: null,
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

// Watch perubahan pada form.amount
watchEffect(() => {
  formattedAmount.value = formatCurrency(form.amount);
});

// Watch perubahan pada is_active
watch(
  () => form.is_active, // Gunakan form.is_active langsung karena form adalah reactive object dari useForm
  (newValue) => {
    if (!newValue) {
      // Jika is_active dinonaktifkan, reset reminder dan auto
      form.reminder = false;
      form.auto = false;
    }
  }
);

// Buka modal
const openModal = (mode, bill = null) => {
  isEditMode.value = mode === 'edit';
  if (isEditMode.value && bill) {
    form.id = bill.id;
    form.name = bill.sub_category?.name || '';
    form.note = bill.note;
    form.amount = bill.amount; // Format sebelum ditampilkan
    form.balance = bill.balance; // Format sebelum ditampilkan
    form.date = bill.date;
    form.reminder = Boolean(bill.reminder);
    form.auto = Boolean(bill.auto);
    form.is_active = Boolean(bill.sub_category?.is_active || false);
    form.account_id = bill.account_id;
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
    form.put(route('bills.update', form.id), {
      onSuccess: () => closeModal(),
    });
  } else {
    form.post(route('bills.store'), {
      onSuccess: () => closeModal(),
    });
  }
};

// Konfirmasi hapus
const confirmDelete = (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus bill ini?')) {
    router.delete(route('bills.destroy', id));
  }
};

// Format tanggal
const formatDate = (date) => {
  if (!date) return "";
  const parsedDate = new Date(date);
  return parsedDate.getDate();
};
</script>


