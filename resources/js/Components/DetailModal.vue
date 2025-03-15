<template>
  <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
      <!-- Header Modal -->
      <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold">Detail Pembayaran</h2>
      </div>

      <!-- Body Modal -->
      <div class="p-6">
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
            <p class="mt-1 text-sm text-gray-900">{{ detail.date }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
            <p class="mt-1 text-sm text-gray-900">{{ detail.category?.name || '-'}}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Nama Sub Kategori</label>
            <p class="mt-1 text-sm text-gray-900">{{ detail.sub_category?.name || '-' }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Nominal</label>
            <p class="mt-1 text-sm text-gray-900">Rp {{ formatCurrency(detail.amount) }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Pembayaran</label>
            <p class="mt-1 text-sm text-gray-900">{{ detail.payment || '-' }}</p>
          </div>
          <div v-if="detail.payment === 'Transfer'">
            <label class="block text-sm font-medium text-gray-700">Account Bank</label>
            <p class="mt-1 text-sm text-gray-900">{{ detail.account_bank?.name || '-' }}</p>
          </div>
        </div>

        <!-- Catatan Kecil -->
        <div class="mt-6 text-sm text-gray-500">
          Catatan: Pastikan semua pembayaran telah diverifikasi dan sesuai dengan data yang tercatat.
        </div>
      </div>

      <!-- Footer Modal -->
      <div class="px-6 py-4 bg-gray-50 text-right">
        <button @click="close" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
          Tutup
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

// Props
const props = defineProps({
  show: Boolean,
  detail: Object,
});

// Emit untuk menutup modal
const emit = defineEmits(['close']);

// Format mata uang
const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value).replace('Rp', '').trim();
};

// Fungsi untuk menutup modal
const close = () => {
  emit('close');
};
</script>