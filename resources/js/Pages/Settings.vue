<template>
  <AppLayout title="Settings">
    <div class="p-4">
               <!-- Tampilkan flash message jika ada -->
      <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ $page.props.flash.success }}
      </div>

      <div v-if="$page.props.flash.error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {{ $page.props.flash.error }}
      </div>
      <div v-if="$page.props.flash.info" class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
        {{ $page.props.flash.info }}
      </div>

      <h1 class="text-2xl font-bold mb-4">Pengaturan</h1>

      <!-- Switch untuk Tombol Edit -->
      <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
        <label class="block text-gray-700 font-bold mb-2">Untuk memunculkan Tombol Edit disemua Tabel</label>
        <div class="flex items-center">
          <input
            type="checkbox"
            :checked="settings.btn_edit"
            @change="updateSetting('btn_edit', $event.target.checked)"
            class="form-checkbox h-5 w-5 text-blue-600"
          />
          <span class="ml-2 text-gray-700 text-sm">{{ settings.btn_edit ? 'Aktif' : 'Tidak Aktif' }}</span>
        </div>
      </div>

      <!-- Switch untuk Tombol Hapus -->
      <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
        <label class="block text-gray-700 font-bold mb-2">Untuk memunculkan Tombol Hapus disemua Tabel</label>
        <div class="flex items-center">
          <input
            type="checkbox"
            :checked="settings.btn_delete"
            @change="updateSetting('btn_delete', $event.target.checked)"
            class="form-checkbox h-5 w-5 text-blue-600"
          />
          <span class="ml-2 text-gray-700 text-sm">{{ settings.btn_delete ? 'Aktif' : 'Tidak Aktif' }}</span>
        </div>
      </div>

      
      <!-- Dropdown untuk memilih AccountBank -->
      <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
        <label class="block text-gray-700 font-bold mb-2">Pilih Akun Bank</label>
         <p class="text-gray-600 mb-2 text-sm">Tentukan BANK untuk Saving (Tabungan) </p>
        <div class="flex items-center">
          <!-- Dropdown untuk memilih akun bank -->
          <select
            v-model="selectedAccount"
            class="block w-full border rounded-md p-2" 
          >
            <option disabled value="">--Pilih Bank Saving--</option>
            <option v-for="account in accounts" 
            :key="account.id" 
            :value="account.id"
            :disabled="!account.is_active">
              {{ account.name }} <span v-if="!account.is_active">(Tidak Aktif)</span>
            </option>
          </select>
           <!-- Tombol Simpan -->
          <button
            @click="confirmUpdate"
            class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm"
          >
            Simpan
          </button>
        </div>

        <!-- Pesan Error -->
        <p v-if="error" class="text-red-500 text-sm mt-2">{{ error }}</p>
      </div>

      <!-- Switch untuk Expenses to Savings -->
      <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
        <label class="block text-gray-700 font-bold mb-2">Expenses to Savings</label>
        <p class="text-gray-600 mb-2 text-sm">Agar di transaksi Expense, ada category Saving muncul</p>
        <div class="flex items-center">
          <input
            type="checkbox"
            :checked="settings.expense_saving"
            @change="updateSetting('expense_saving', $event.target.checked)"
            class="form-checkbox h-5 w-5 text-blue-600"
          />
          <span class="ml-2 text-gray-700 text-sm">{{ settings.expense_saving ? 'Aktif' : 'Tidak Aktif' }}</span>
        </div>
      </div>

      <!-- Switch untuk Savings to Expenses -->
      <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
        <label class="block text-gray-700 font-bold mb-2">Savings to Expenses</label>
        <p class="text-gray-600 mb-2 text-sm">Agar di transaksi Expense, Saving muncul di Account Bank</p>
        <div class="flex items-center">
          <input
            type="checkbox"
            :checked="settings.saving_expense"
            @change="updateSetting('saving_expense', $event.target.checked)"
            class="form-checkbox h-5 w-5 text-blue-600"
          />
          <span class="ml-2 text-gray-700 text-sm">{{ settings.saving_expense ? 'Aktif' : 'Tidak Aktif' }}</span>
        </div>
      </div>

      <!-- Switch untuk Income to Savings -->
      <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
        <label class="block text-gray-700 font-bold mb-2">Income to Savings</label>
        <p class="text-gray-600 mb-2 text-sm">Agar di transaksi Income ada category Saving muncul</p>
        <div class="flex items-center">
          <input
            type="checkbox"
            :checked="settings.income_saving"
            @change="updateSetting('income_saving', $event.target.checked)"
            class="form-checkbox h-5 w-5 text-blue-600"
          />
          <span class="ml-2 text-gray-700 text-sm">{{ settings.income_saving ? 'Aktif' : 'Tidak Aktif' }}</span>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

// Ambil data settings dan accounts dari props
const settings = ref(usePage().props.settings);
const accounts = ref(usePage().props.accounts);
const selectedAccount = ref(settings.value.account_id);

// Fungsi untuk mengupdate setting
const updateSetting = (key, value) => {
  router.post(route('settings.update', { key }), {
    value,
  }, {
    preserveScroll: true,
    onSuccess: () => {
      settings.value[key] = value;
    },
  });
};

import Swal from 'sweetalert2';

// Fungsi untuk konfirmasi sebelum update
const confirmUpdate = () => {
  // Validasi jika belum memilih bank
  if (!selectedAccount.value) {
    error.value = 'Pilihan bank harus diisi';
    return;
  }

  // Cari nama bank lama dan baru
  const oldBank = accounts.value.find(account => account.id === settings.value.account_id);
  const newBank = accounts.value.find(account => account.id === selectedAccount.value);

  // Tampilkan modal konfirmasi menggunakan SweetAlert2
  Swal.fire({
    title: 'Konfirmasi Perubahan',
    html: `Jika Account Bank Saving diubah, saldo di bank <b>${oldBank?.name || 'sebelumnya'}</b> akan dipindahkan ke akun bank <b>${newBank?.name}</b>. Apakah Anda yakin?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Setuju',
    cancelButtonText: 'Batal',
  }).then((result) => {
    // Jika user setuju, kirim permintaan update
    if (result.isConfirmed) {
      updateAccount();
    }
  });
};

// Fungsi untuk mengupdate account_id
const updateAccount = () => {
  router.post(route('setting_Account.update', { key: settings.value.id }), {
    account_id: selectedAccount.value,
  }, {
    preserveScroll: true,
    onSuccess: () => {
      // Swal.fire('Berhasil!', 'Bank berhasil dipilih.', 'success');
      error.value = ''; // Reset pesan error
    },
    onError: (errors) => {
      console.error('Error:', errors); // Debugging
      Swal.fire('Gagal!', 'Gagal memperbarui bank. Silakan coba lagi.', 'error');
      error.value = 'Gagal memperbarui bank. Silakan coba lagi.';
    },
  });
};

const error = ref('');


</script>