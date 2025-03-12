<template>
  <AppLayout title="Kelola Hutang">
    <div class="p-4">
      <div class="container mx-auto p-2">
        <!-- Header & Tombol Tambah -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-4 rounded-lg shadow-md mb-2">
          <div>
            <h1 class="text-xl font-semibold text-gray-800">Kelola Hutang</h1>
            <p class="text-sm text-gray-600 mt-1">
              Halaman ini digunakan untuk mengelola dan menambahkan data hutang seperti hutang pribadi, cicilan, atau hutang bisnis.
            </p>
          </div>
          <PrimaryButton @click="openModal('create')" class="mt-4 sm:mt-0">Tambah Hutang</PrimaryButton>
        </div>

        <!-- Daftar Hutang -->
        <div v-if="debts.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <div v-for="debt in debts" :key="debt.id" class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between">
              <h2 class="text-lg font-semibold">{{ debt.sub_category?.name || 'Tanpa Kategori' }}</h2>
              <span 
                class="px-2 py-1 text-xs font-semibold rounded-lg"
                :class="debt.sub_category?.is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'"
              >
                {{ debt.sub_category?.is_active ? 'Aktif' : 'Tidak Aktif' }}
              </span>
            </div>
            <p class="text-sm text-gray-500">{{ debt.note }}</p>
            <p class="text-xl font-bold text-purple-600">{{ formatCurrency(debt.amount) }}</p>
            <p class="text-sm text-gray-500">Tanggal Jatuh Tempo: {{ formatDate(debt.due_date) }}</p>

            <!-- Pesan Reminder -->
            <p v-if="debt.reminder" class="text-sm text-green-500">
              Hutang ini di set Pengingat dan akan diingatkan selalu.
            </p>
            <p v-if="debt.auto" class="text-sm text-blue-500">
              Setiap tanggal jatuh tempo, hutang akan otomatis tersimpan ke data.
            </p>

            <!-- Tombol Edit & Hapus -->
            <div class="mt-4 flex space-x-2">
              <PrimaryButton @click="openModal('edit', debt)">Edit</PrimaryButton>
              <PrimaryButton class="bg-red-600 hover:bg-red-700" @click="confirmDelete(debt.id)">Hapus</PrimaryButton>
            </div>
          </div>
        </div>

        <!-- Pesan Jika Tidak Ada Data -->
        <div v-else class="text-center bg-white p-2 rounded-lg shadow-md">
          <p class="text-gray-500 text-sm">Belum ada hutang yang tercatat. Silakan tambahkan hutang baru.</p>
        </div>

        <!-- Informasi Tambahan -->
        <div class="mt-4 bg-gray-100 p-2 rounded-lg shadow-md">
          <h2 class="text-lg font-semibold text-gray-800">Informasi Mengenai Hutang</h2>
          <p class="text-sm text-gray-600 mt-2">
            Halaman ini digunakan untuk mencatat hutang yang harus dibayar, baik itu hutang pribadi, cicilan, atau hutang bisnis.
          </p>
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
              <InputLabel for="name" value="Nama Hutang" />
              <TextInput id="name" v-model="form.name" class="block w-full" :disabled="isEditMode" :readonly="isEditMode"/>
              <InputError :message="form.errors.name" />
            </div>

            <div class="mb-4">
              <InputLabel for="kategori" value="Kategori" />
              <TextInput id="kategori" v-model="form.kategori" class="block w-full" />
              <InputError :message="form.errors.kategori" />
            </div>

            <div class="mb-4">
              <InputLabel for="amount" value="Jumlah Hutang" />
              <TextInput id="amount" type="number" v-model="form.amount" class="block w-full" required />
              <InputError :message="form.errors.amount" />
            </div>

            <div class="mb-4">
              <InputLabel for="note" value="Catatan" />
              <TextInput id="note" v-model="form.note" class="block w-full" />
              <InputError :message="form.errors.note" />
            </div>

            <div class="mb-4">
              <InputLabel for="type" value="Tipe Hutang" />
              <select id="type" v-model="form.type" class="block w-full">
                <option value="personal">Personal</option>
                <option value="installment">Cicilan</option>
                <option value="business">Bisnis</option>
              </select>
              <InputError :message="form.errors.type" />
            </div>

            <div v-if="form.type === 'installment'" class="mb-4">
              <InputLabel for="due_date" value="Tanggal Jatuh Tempo" />
              <select id="due_date" v-model="form.due_date" class="block w-full">
                <option v-for="day in 31" :key="day" :value="day">{{ day }}</option>
              </select>
              <InputError :message="form.errors.due_date" />
            </div>

            <div v-if="form.type === 'installment'" class="mb-4">
              <InputLabel for="tenor_months" value="Tenor (Bulan)" />
              <TextInput id="tenor_months" type="number" v-model="form.tenor_months" class="block w-full" />
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

            <div class="mb-4">
              <label class="flex items-center">
                <input type="checkbox" v-model="form.auto" class="mr-2" />
                <span>Otomatis</span>
              </label>
              <p class="text-sm text-gray-500">Secara Otomatis Masuk data sesuai tanggal</p>
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
import { ref, reactive, computed, watch } from 'vue';
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

// Form untuk tambah/edit Debt
const form = useForm({
  id: null,
  name: '',
  kategori: '',
  amount: '',
  note: '',
  type: 'personal',
  due_date: null,
  tenor_months: null,
  is_active: false,
  reminder: false,
  auto: false,
});

// Format mata uang
const formatCurrency = (value) => {
  if (!value) return '';
  return new Intl.NumberFormat('id-ID').format(value.replace(/\D/g, ''));
};

// Watch perubahan amount
watch(() => {
  if (form) {
    form.amount = formatCurrency(String(form.amount));
  }
});

// Buka modal
const openModal = (mode, debt = null) => {
  isEditMode.value = mode === 'edit';
  if (isEditMode.value && debt) {
    form.id = debt.id;
    form.name = debt.sub_category?.name || '';
    form.kategori = debt.sub_category?.name || '';
    form.note = debt.note;
    form.amount = formatCurrency(String(debt.amount)); // Format sebelum ditampilkan
    form.type = debt.type;
    form.due_date = debt.due_date;
    form.tenor_months = debt.tenor_months;
    form.reminder = Boolean(debt.reminder);
    form.auto = Boolean(debt.auto);
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
  // Hapus format sebelum dikirim ke backend
  form.amount = form.amount.replace(/\D/g, '');

  if (isEditMode.value) {
    form.put(route('debts.update', form.id), {
      onSuccess: () => closeModal(),
    });
  } else {
    form.post(route('debts.store'), {
      onSuccess: () => closeModal(),
    });
  }
};

// Konfirmasi hapus
const confirmDelete = (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus hutang ini?')) {
    router.delete(route('debts.destroy', id));
  }
};

// Format tanggal
const formatDate = (date) => {
  if (!date) return "";
  const parsedDate = new Date(date);
  return parsedDate.getDate();
};
</script>