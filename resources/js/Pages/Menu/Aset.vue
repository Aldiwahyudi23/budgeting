<template>
  <AppLayout title="Aset">
    <div class="p-4">
      <h3 class="text-xl font-bold mb-6">Manajemen Aset</h3>

      <!-- Section Tabungan -->
      <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-lg font-semibold">Tabungan</h2>
            <p class="text-sm text-gray-600">Saldo tabungan Anda</p>
          </div>
          <div class="text-right">
            <p class="text-xl font-bold text-green-600">
              Rp{{ formatCurrency(totalSavingAmount) }}
            </p>
            <p class="text-sm text-gray-500">Saldo saat ini</p>
          </div>
        </div>
        <div class="mt-4">
          <Link
            :href="route('savings.index')"
            class="text-blue-500 hover:text-blue-700 text-sm"
          >
            Lihat Detail Tabungan →
          </Link>
        </div>
      </div>

      <!-- Grid untuk Aset Lainnya -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Card Saham -->
        <Link
          :href="route('savings.index')"
          class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"
        >
          <div class="flex items-center">
            <div class="bg-blue-100 p-3 rounded-full">
              <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Saham</h2>
              <p class="text-sm text-gray-600">Kelola portofolio saham Anda</p>
            </div>
          </div>
        </Link>

        <!-- Card Pinjaman -->
        <Link
          :href="route('savings.index')"
          class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"
        >
          <div class="flex items-center">
            <div class="bg-red-100 p-3 rounded-full">
              <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Pinjaman</h2>
              <p class="text-sm text-gray-600">Kelola pinjaman Anda</p>
            </div>
          </div>
        </Link>

        <!-- Card Properti -->
        <Link
          :href="route('savings.index')"
          class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"
        >
          <div class="flex items-center">
            <div class="bg-green-100 p-3 rounded-full">
              <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Properti</h2>
              <p class="text-sm text-gray-600">Kelola properti Anda</p>
            </div>
          </div>
        </Link>

        <!-- Card Emas -->
        <Link
          :href="route('savings.index')"
          class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"
        >
          <div class="flex items-center">
            <div class="bg-yellow-100 p-3 rounded-full">
              <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Emas</h2>
              <p class="text-sm text-gray-600">Kelola investasi emas Anda</p>
            </div>
          </div>
        </Link>

        <!-- Card Reksadana -->
        <Link
          :href="route('savings.index')"
          class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"
        >
          <div class="flex items-center">
            <div class="bg-purple-100 p-3 rounded-full">
              <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Reksadana</h2>
              <p class="text-sm text-gray-600">Kelola reksadana Anda</p>
            </div>
          </div>
        </Link>

        <!-- Card Lainnya -->
        <Link
          :href="route('savings.index')"
          class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"
        >
          <div class="flex items-center">
            <div class="bg-pink-100 p-3 rounded-full">
              <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold">Aset Lainnya</h2>
              <p class="text-sm text-gray-600">Kelola aset lainnya</p>
            </div>
          </div>
        </Link>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

// Terima props dari controller
const props = defineProps({
  totalSavingAmount: Number,
});

// Fungsi untuk memformat mata uang
const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID').format(value);
};
</script>