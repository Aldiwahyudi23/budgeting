<template>
  <AppLayout title="Settings">
    <div class="p-4">
      <!-- Flash Messages -->
      <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-2">
        {{ $page.props.flash.success }}
      </div>
      <div v-if="$page.props.flash.error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-2">
        {{ $page.props.flash.error }}
      </div>
      <div v-if="$page.props.flash.info" class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-2">
        {{ $page.props.flash.info }}
      </div>

      <h4 class="text-2xl font-bold mb-4">Pengaturan</h4>

<!-- BAGIAN TABEL -->
<div class="mb-6 p-4 bg-white rounded-lg shadow-md">
    <div @click="toggleSection('table')" class="flex justify-between items-center cursor-pointer">
        <h2 class="text-lg font-bold">Tabel</h2>
        <span class="text-gray-500">{{ isTableOpen ? '▲' : '▼' }}</span>
    </div>
    <span class="text-gray-500">Edit dan Hapus hanya jika perlu saja </span>
    <div v-if="isTableOpen">
        <!-- Switch untuk Tombol Edit -->
        <div class="mt-2 mb-6 p-4 bg-blue-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
            <label class="block text-gray-700 font-bold mb-2">Untuk memunculkan Tombol Edit disemua Tabel</label>
            <div class="flex items-center">
                <input
                    type="checkbox"
                    :checked="settings.btn_edit"
                    @click="verifyBeforeUpdate('btn_edit', !settings.btn_edit)"
                    :disabled="!hasPhoneNumber"
                    class="form-checkbox h-5 w-5 text-blue-600"
                />
                <span class="ml-2 text-gray-700 text-sm">{{ settings.btn_edit ? 'Aktif' : 'Tidak Aktif' }}</span>
            </div>
            <p v-if="!hasPhoneNumber" class="mt-2 text-sm text-red-600">
                Untuk mengaktifkan fitur ini, silakan tambahkan nomor WhatsApp terlebih dahulu.
            </p>
        </div>

        <!-- Switch untuk Tombol Hapus -->
        <div class="mb-6 p-4 bg-blue-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
            <label class="block text-gray-700 font-bold mb-2">Untuk memunculkan Tombol Hapus disemua Tabel</label>
            <div class="flex items-center">
                <input
                    type="checkbox"
                    :checked="settings.btn_delete"
                    @click="verifyBeforeUpdate('btn_delete', !settings.btn_delete)"
                    :disabled="!hasPhoneNumber"
                    class="form-checkbox h-5 w-5 text-blue-600"
                />
                <span class="ml-2 text-gray-700 text-sm">{{ settings.btn_delete ? 'Aktif' : 'Tidak Aktif' }}</span>
            </div>
            <p v-if="!hasPhoneNumber" class="mt-2 text-sm text-red-600">
                Untuk mengaktifkan fitur ini, silakan tambahkan nomor WhatsApp terlebih dahulu.
            </p>
        </div>
    </div>
</div>

      <!-- BAGIAN TABUNGAN -->
      <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
        <div @click="toggleSection('savings')" class="flex justify-between items-center cursor-pointer">
          <h2 class="text-lg font-bold">Tabungan</h2>
          <span class="text-gray-500">{{ isSavingsOpen ? '▲' : '▼' }}</span>
        </div>
        <span  class="text-gray-500">Untuk mengaktifkan Tabungan cukup klik Tabungan, lalu buat Kategory tabungannya di setup</span>
        <div v-if="isSavingsOpen">

          <!-- Switch untuk Expenses to Savings -->
          <div class="mt-2 mb-6 p-4 bg-blue-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
            <label class="block text-gray-700 font-bold mb-2">Aktifkan Tabungan</label>
            <p class="text-gray-600 mb-2 text-sm">Memindahkan Saldo Utama ke data Tabungan, Kategori tabungan akan muncul ditransaksi pengeluaran</p>
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

                          <!-- Dropdown untuk memilih AccountBank -->
          <div class="mb-6 p-4 bg-blue-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
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
             <p class="text-gray-600 mt-2 text-sm">Untuk memilih Akun Bank Harap Aktifkan dulu Tabungan di atas</p>
          </div>
          
          <!-- Switch untuk Savings to Expenses -->
          <div class="mb-6 p-4 bg-blue-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
            <label class="block text-gray-700 font-bold mb-2">Tabungan Sumber Pengeluaran </label>
            <p class="text-gray-600 mb-2 text-sm">Anda dapat mengambil Uang dari Tabungan untuk pengeluaran</p>
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
            <div class="mb-6 p-4 bg-blue-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
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
      </div>

      <!-- Tambahkan bagian ini setelah BAGIAN TABUNGAN dan sebelum BAGIAN PEKERJAAN -->
<div class="mb-6 p-4 bg-white rounded-lg shadow-md">
  <div @click="toggleSection('transaction')" class="flex justify-between items-center cursor-pointer">
    <h2 class="text-lg font-bold">Pengaturan Transaksi</h2>
    <span class="text-gray-500">{{ isTransactionOpen ? '▲' : '▼' }}</span>
  </div>
  <span class="text-gray-500">Pengaturan tampilan dan fitur transaksi</span>
  <div v-if="isTransactionOpen">
    
    <!-- Date Input Settings -->
    <div class="mt-2 mb-6 p-4 bg-blue-100 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
      <h3 class="font-bold mb-2">Pengaturan Tanggal</h3>
      
      <!-- Date in Income -->
      <div class="mb-4">
        <label class="flex items-center">
          <input
            type="checkbox"
            :checked="settings.date_in"
            @change="updateSetting('date_in', $event.target.checked)"
            class="form-checkbox h-5 w-5 text-blue-600"
          />
          <span class="ml-2 text-gray-700">Tampilkan Input Tanggal di Pemasukan</span>
        </label>
      </div>
      
      <!-- Date in Expense -->
      <div class="mb-4">
        <label class="flex items-center">
          <input
            type="checkbox"
            :checked="settings.date_ex"
            @change="updateSetting('date_ex', $event.target.checked)"
            class="form-checkbox h-5 w-5 text-blue-600"
          />
          <span class="ml-2 text-gray-700">Tampilkan Input Tanggal di Pengeluaran</span>
        </label>
      </div>
    </div>
    
    <!-- Payment Method Settings -->
    <div class="mb-6 p-4 bg-blue-100 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
      <h3 class="font-bold mb-2">Pengaturan Metode Pembayaran</h3>
      
      <!-- Bank Payment -->
      <div class="mb-4">
        <label class="flex items-center">
          <input
            type="checkbox"
            :checked="settings.bank"
            @change="updateSetting('bank', $event.target.checked)"
            class="form-checkbox h-5 w-5 text-blue-600"
          />
          <span class="ml-2 text-gray-700">Aktifkan Pembayaran via Bank/Transfer</span>
        </label>
      </div>
      
      <!-- Cash Payment -->
      <div class="mb-4">
        <label class="flex items-center">
          <input
            type="checkbox"
            :checked="settings.cash"
            @change="updateSetting('cash', $event.target.checked)"
            class="form-checkbox h-5 w-5 text-blue-600"
          />
          <span class="ml-2 text-gray-700">Aktifkan Pembayaran Tunai</span>
        </label>
      </div>
    </div>
  </div>
</div>

            <!-- BAGIAN TABEL -->
      <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
        <div @click="toggleSection('job')" class="flex justify-between items-center cursor-pointer">
          <h2 class="text-lg font-bold">Pekerjaan</h2>
          <span class="text-gray-500">{{ isJobOpen ? '▲' : '▼' }}</span>
        </div>
        <span class="text-gray-500">Update Pekerjaan di bawah dengan benar</span>
        <div v-if="isJobOpen">
        <!-- Switch untuk Tombol Edit -->
        <form @submit.prevent="saveJob" class="mt-6 space-y-6">
            <!-- Jika job sudah ada, tampilkan peringatan -->
            <div class="bg-yellow-100 p-4 rounded-lg text-yellow-800 text-sm font-semibold">
                Jika memiliki BPJS harap centang dan isi persenannya sesuai aturan dari pemerintah untuk menghitung BPJS secara otomatis
            </div>

            <!-- Company Name -->
            <div>
                <InputLabel for="company_name" class="block text-sm font-medium text-gray-700" >
                  Nama Perusahaan
                 <span class="text-red-500 text-sm">*</span>
                 </InputLabel>
                <TextInput id="company_name" v-model="form.company_name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <InputError :message="form.errors.company_name" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Job Title -->
            <div>
                <InputLabel for="job_title" class="block text-sm font-medium text-gray-700" >
                  Pekerjaan (Jabatan)
                 <span class="text-red-500 text-sm">*</span>
                </InputLabel>
                <TextInput id="job_title" v-model="form.job_title"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <InputError :message="form.errors.job_title" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Job Description -->
            <div>
                <InputLabel for="job_description" value="Deskripsi Pekerjaan" class="block text-sm font-medium text-gray-700" />
                <textarea id="job_description" v-model="form.job_description"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                <InputError :message="form.errors.job_description" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Salary -->
            <div>
                <InputLabel for="salary" class="block text-sm font-medium text-gray-700" >
                  Salary (Gajih)
                   <span class="text-red-500 text-sm">*</span>
                 </InputLabel>
                <TextInput id="salary"  type="text"
                    v-model="formattedAmount"
                    @input="handleAmountInput"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                   
              />
                <InputError :message="form.errors.salary" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- BPJS -->
            <div class="flex items-center">
                <input id="bpjs" type="checkbox" v-model="form.bpjs"
                    class="h-4 w-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500" />
                <label for="bpjs" class="ml-2 text-sm text-gray-700">Has BPJS?</label>
            </div>

            <!-- BPJS Percentages -->
            <div v-if="form.bpjs" class="space-y-4">
                <div>
                    <InputLabel for="bpjs_company_percentage" 
                        class="block text-sm font-medium text-gray-700" >
                        BPJS - Company Contribution (%)
                         <span class="text-red-500 text-sm">*</span>
                   </InputLabel>
                    <TextInput id="bpjs_company_percentage" v-model="form.bpjs_company_percentage" type="number" step="0.01"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <InputError :message="form.errors.bpjs_company_percentage" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <InputLabel for="bpjs_employee_percentage"
                        class="block text-sm font-medium text-gray-700" >
                        BPJS - Employee Contribution (%)
                         <span class="text-red-500 text-sm">*</span>
                    </InputLabel>
                    <TextInput id="bpjs_employee_percentage" v-model="form.bpjs_employee_percentage" type="number" step="0.01"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <InputError :message="form.errors.bpjs_employee_percentage" class="mt-2 text-sm text-red-600" />
                </div>
            </div>

            <!-- Benefits -->
            <div>
                <InputLabel for="benefits" value="Benefits" class="block text-sm font-medium text-gray-700" />
                <textarea id="benefits" v-model="form.benefits"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                <InputError :message="form.errors.benefits" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                      <ActionMessage :on="form.recentlySuccessful" class="me-3 text-green-600">
                          Tersimpan.
                      </ActionMessage>

                      <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                           {{ buttonText }}
                      </PrimaryButton>
            </div>
        </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref , computed } from 'vue';
import { usePage, router, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';

// Data dari server
const settings = ref(usePage().props.settings);
const accounts = ref(usePage().props.accounts);
const selectedAccount = ref(settings.value.account_id);
const user = ref(usePage().props.auth.user);

// Computed property untuk mengecek apakah user memiliki nomor telepon
const hasPhoneNumber = computed(() => {
    return user.value.numberPhone && user.value.numberPhone.trim() !== '';
});

// State untuk mengontrol tampilan
const isTableOpen = ref(false);
const isSavingsOpen = ref(false);
const isJobOpen = ref(false);

// Fungsi toggle untuk menampilkan/menghilangkan isi section
// const toggleSection = (section) => {
//   if (section === 'table') {
//     isTableOpen.value = !isTableOpen.value;
//   }
//   if (section === 'job') {
//     isJobOpen.value = !isJobOpen.value;
//   }
//    else if (section === 'savings') {
//     isSavingsOpen.value = !isSavingsOpen.value;
//   }
// };

// Tambahkan ini bersama state lainnya
const isTransactionOpen = ref(false);

// Modifikasi fungsi toggleSection
const toggleSection = (section) => {
  if (section === 'table') {
    isTableOpen.value = !isTableOpen.value;
  } else if (section === 'job') {
    isJobOpen.value = !isJobOpen.value;
  } else if (section === 'savings') {
    isSavingsOpen.value = !isSavingsOpen.value;
  } else if (section === 'transaction') {
    isTransactionOpen.value = !isTransactionOpen.value;
  }
};

// Fungsi untuk verifikasi sebelum update
const verifyBeforeUpdate = async (key, value) => {
    const { value: password } = await Swal.fire({
        title: 'Verifikasi',
        text: 'Masukkan sandi Tombol untuk melanjutkan:',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off',
            autocorrect: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Verifikasi',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) {
                return 'Harap masukkan sandi!';
            }
        }
    });

    if (password) {
        if (password === user.value.sandi_botton) {
            updateSetting(key, value);
        } else {
            Swal.fire({
                title: 'Gagal!',
                text: 'Sandi tidak sesuai',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            // Reset checkbox state
            settings.value[key] = !value;
        }
    } else {
        // Reset checkbox state jika user membatalkan
        settings.value[key] = !value;
    }
};

// Fungsi untuk mengupdate setting
const updateSetting = (key, value) => {
  router.post(route('settings.update', { key }), {
    value,
  }, {
    preserveScroll: true,
     onSuccess: () => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Pengaturan berhasil diperbarui.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            settings.value[key] = value;
        },
        onError: () => {
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat memperbarui pengaturan.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            // Rollback the change if there's an error
            settings.value[key] = !value;
        }
  });
};

// Fungsi konfirmasi update akun bank
const confirmUpdate = () => {
  if (!selectedAccount.value) {
    error.value = 'Pilih bank harus diisi';
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


const props = defineProps({
    job: Object, // Data pekerjaan (jika ada)
    userId: Number, // ID pengguna yang login
});

// Inertia form untuk membuat atau memperbarui job
const form = useForm({
    company_name: props.job?.company_name || '',
    job_title: props.job?.job_title || '',
    job_description: props.job?.job_description || '',
    salary: props.job?.salary || '',
    bpjs: Boolean(props.job?.bpjs) || false,
    bpjs_company_percentage: props.job?.bpjs_company_percentage || '',
    bpjs_employee_percentage: props.job?.bpjs_employee_percentage || '',
    benefits: props.job?.benefits || '',
});
// Cek apakah user sudah memiliki job
const jobExists = computed(() => !!props.job);

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
  get: () => formatCurrency(form.salary),
  set: (value) => (form.salary = parseCurrency(value)),
});

const handleAmountInput = (event) => {
  const rawValue = String(event.target.value).replace(/\./g, ''); // Pastikan string
  form.salary = rawValue;
};

// Teks tombol berdasarkan kondisi jobExists
const buttonText = computed(() => (jobExists.value ? 'Update' : 'Save'));

// Fungsi untuk menyimpan atau memperbarui job
const saveJob = () => {
    if (jobExists.value) {
        // Jika job sudah ada, lakukan update
        form.put(route('job.update', props.job.id), {
            preserveScroll: true,
            // onSuccess: () => alert('Job updated successfully!'),
        });
    } else {
        // Jika job belum ada, lakukan create
        form.post(route('job.store'), {
            preserveScroll: true,
            // onSuccess: () => alert('Job added successfully!'),
        });
    }
};

</script>
