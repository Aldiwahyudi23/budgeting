<template>
      <AppLayout title="Settings">
        <div class="p-4">
          <h1 class="text-2xl font-bold mb-4">Pengaturan</h1>
      
          <!-- Switch untuk Tombol Edit -->
          <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
            <label class="block text-gray-700 font-bold mb-2">Untuk memunculkan Tombol Edit</label>
            <div class="flex items-center">
              <input
                type="checkbox"
                :checked="settings.btn_edit"
                @change="updateSetting('btn_edit', $event.target.checked)"
                class="form-checkbox h-5 w-5 text-blue-600"
              />
              <span class="ml-2 text-gray-700">{{ settings.btn_edit ? 'Aktif' : 'Tidak Aktif' }}</span>
            </div>
          </div>
      
          <!-- Switch untuk Tombol Hapus -->
          <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
            <label class="block text-gray-700 font-bold mb-2">Untuk memunculkan Tombol Hapus</label>
            <div class="flex items-center">
              <input
                type="checkbox"
                :checked="settings.btn_delete"
                @change="updateSetting('btn_delete', $event.target.checked)"
                class="form-checkbox h-5 w-5 text-blue-600"
              />
              <span class="ml-2 text-gray-700">{{ settings.btn_delete ? 'Aktif' : 'Tidak Aktif' }}</span>
            </div>
          </div>
      
          <!-- Switch untuk Expenses to Savings -->
          <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
            <label class="block text-gray-700 font-bold mb-2">Expenses to Savings</label>
            <p class="text-gray-600 mb-2">Agar di transaksi Expense ada category Saving muncul</p>
            <div class="flex items-center">
              <input
                type="checkbox"
                :checked="settings.expense_saving"
                @change="updateSetting('expense_saving', $event.target.checked)"
                class="form-checkbox h-5 w-5 text-blue-600"
              />
              <span class="ml-2 text-gray-700">{{ settings.expense_saving ? 'Aktif' : 'Tidak Aktif' }}</span>
            </div>
          </div>
      
          <!-- Switch untuk Savings to Expenses -->
          <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
            <label class="block text-gray-700 font-bold mb-2">Savings to Expenses</label>
            <p class="text-gray-600 mb-2">Agar di transaksi Savings ada category Expense muncul</p>
            <div class="flex items-center">
              <input
                type="checkbox"
                :checked="settings.saving_expense"
                @change="updateSetting('saving_expense', $event.target.checked)"
                class="form-checkbox h-5 w-5 text-blue-600"
              />
              <span class="ml-2 text-gray-700">{{ settings.saving_expense ? 'Aktif' : 'Tidak Aktif' }}</span>
            </div>
          </div>
      
          <!-- Switch untuk Income to Savings -->
          <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
            <label class="block text-gray-700 font-bold mb-2">Income to Savings</label>
            <p class="text-gray-600 mb-2">Agar di transaksi Income ada category Saving muncul</p>
            <div class="flex items-center">
              <input
                type="checkbox"
                :checked="settings.income_saving"
                @change="updateSetting('income_saving', $event.target.checked)"
                class="form-checkbox h-5 w-5 text-blue-600"
              />
              <span class="ml-2 text-gray-700">{{ settings.income_saving ? 'Aktif' : 'Tidak Aktif' }}</span>
            </div>
          </div>
        </div>
      </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

// Ambil data settings dari props
const settings = ref(usePage().props.settings);

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
</script>