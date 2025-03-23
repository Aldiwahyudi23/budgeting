<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Ambil props dari controller
const props = defineProps({
    latestBalance: Object,
    bpjsJhtRecords: Object,
    filters: Object,
});

// State untuk pencarian
const search = ref(props.filters.search);

// Fungsi untuk melakukan pencarian
const performSearch = () => {
    router.get(route('bpjs.index'), { search: search.value }, {
        preserveState: true,
        replace: true,
    });
};

// Format angka ke Rupiah
const formatRupiah = (value) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    }).format(value);
};
</script>

<template>
    <AppLayout title="Data BPJS JHT">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data BPJS JHT
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Header dengan Saldo Terbaru -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Saldo Terbaru</h3>
                    <div v-if="props.latestBalance" class="bg-blue-100 p-4 rounded-lg">
                        <p class="text-lg font-semibold">Saldo Terbaru untuk {{ props.latestBalance.company_name }}:</p>
                        <p class="text-2xl text-blue-700 font-bold">{{ formatRupiah(props.latestBalance.final_balance) }}</p>
                    </div>
                    <div v-else class="bg-yellow-100 p-4 rounded-lg">
                        <p class="text-lg font-semibold">Belum ada data BPJS JHT.</p>
                    </div>
                </div>

                <!-- Form Pencarian -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <div class="flex items-center">
                        <TextInput
                            v-model="search"
                            placeholder="Cari berdasarkan nama perusahaan atau keterangan..."
                            class="w-full"
                        />
                        <PrimaryButton @click="performSearch" class="ml-2">
                            Cari
                        </PrimaryButton>
                    </div>
                </div>

                <!-- Tabel Data BPJS JHT -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left">Nama Perusahaan</th>
                                <th class="px-4 py-2 text-left">CC (Company Contribution)</th>
                                <th class="px-4 py-2 text-left">EC (Employee Contribution)</th>
                                <th class="px-4 py-2 text-left">Saldo Awal</th>
                                <th class="px-4 py-2 text-left">Saldo Akhir</th>
                                <th class="px-4 py-2 text-left">Tanggal Transaksi</th>
                                <th class="px-4 py-2 text-left">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="record in bpjsJhtRecords.data" :key="record.id" class="border-b">
                                <td class="px-4 py-2">{{ record.company_name }}</td>
                                <td class="px-4 py-2">{{ formatRupiah(record.company_contribution) }}</td>
                                <td class="px-4 py-2">{{ formatRupiah(record.employee_contribution) }}</td>
                                <td class="px-4 py-2">{{ formatRupiah(record.initial_balance) }}</td>
                                <td class="px-4 py-2">{{ formatRupiah(record.final_balance) }}</td>
                                <td class="px-4 py-2">{{ new Date(record.transaction_date).toLocaleDateString('id-ID') }}</td>
                                <td class="px-4 py-2">{{ record.description }}</td>
                            </tr>
                            <tr v-if="bpjsJhtRecords.data.length === 0">
                                <td colspan="7" class="px-4 py-2 text-center">Tidak ada data ditemukan.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <Pagination :links="bpjsJhtRecords.links" class="mt-6" />
            </div>
        </div>
    </AppLayout>
</template>