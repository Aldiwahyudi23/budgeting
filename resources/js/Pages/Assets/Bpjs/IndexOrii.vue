
<template>
    <AppLayout title="Data BPJS JHT">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data BPJS JHT
            </h2>
        </template>

        <div class="py-6 md:py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Header dengan Saldo Terbaru -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Ringkasan BPJS JHT</h3>
                            <p class="text-sm text-gray-500">Perhitungan berdasarkan pengaturan pekerjaan Anda</p>
                        </div>
                        
                        <div v-if="props.latestBalance" class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200 w-full md:w-auto">
                            <p class="text-sm font-medium text-gray-600">Saldo Terkini</p>
                            <p class="text-2xl md:text-3xl font-bold text-blue-700">
                                {{ formatRupiah(props.latestBalance.final_balance) }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">Perusahaan: {{ props.latestBalance.company_name }}</p>
                        </div>
                        <div v-else class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 w-full md:w-auto">
                            <p class="text-sm font-medium text-yellow-700">Belum ada data BPJS JHT.</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Penting -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Catatan Penting</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Data dihitung otomatis berdasarkan nominal Company Contribution dan Employee Contribution yang diinput di Pengaturan Pekerjaan</li>
                                    <li>Jumlah tidak sama persis dengan saldo aktual JHT Anda karena tergantung tanggungan dan hasil pengembangan dari BPJS</li>
                                    <li>Perhitungan otomatis dilakukan setiap tanggal 13 dengan syarat BPJS aktif di Pengaturan Pekerjaan</li>
                                    <li>Pastikan selalu memperbarui gaji di Pengaturan Pekerjaan untuk perhitungan yang akurat</li>
                                </ul>
                            </div>
                        </div>
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
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perusahaan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CC</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">EC</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo Awal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo Akhir</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="record in bpjsJhtRecords.data" :key="record.id" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ record.company_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatRupiah(record.company_contribution) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatRupiah(record.employee_contribution) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatRupiah(record.initial_balance) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" 
                                        :class="{
                                            'text-green-600': record.final_balance > record.initial_balance,
                                            'text-red-600': record.final_balance < record.initial_balance,
                                            'text-gray-500': record.final_balance === record.initial_balance
                                        }">
                                        {{ formatRupiah(record.final_balance) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ new Date(record.transaction_date).toLocaleDateString('id-ID', { 
                                            day: '2-digit', 
                                            month: 'short', 
                                            year: 'numeric' 
                                        }) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ record.description }}</td>
                                </tr>
                                <tr v-if="bpjsJhtRecords.data.length === 0">
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada data ditemukan.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    latestBalance: Object,
    bpjsJhtRecords: Object,
    filters: Object,
});

const search = ref(props.filters.search);

const performSearch = () => {
    router.get(route('bpjs.index'), { search: search.value }, {
        preserveState: true,
        replace: true,
    });
};

const formatRupiah = (value) => {
    if (!value) return 'Rp 0';
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(value);
};
</script>