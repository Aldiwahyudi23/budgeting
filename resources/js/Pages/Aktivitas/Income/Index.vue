<template>
    <AppLayout title="Income">
        <div class="p-4">
    
            <!-- Bagian Header: Tombol Tambah & Pencarian -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
                <!-- Tombol Tambah Pemasukan -->
                <PrimaryButton @click="openModal('create')">Tambah Pemasukan</PrimaryButton>
    
                <!-- Filter dan Pencarian -->
                <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
                    <!-- Filter Tahun dan Bulan -->
                    <div class="flex items-center space-x-4 w-full md:w-auto">
                        <!-- Label Filter -->
                        <span class="text-sm font-medium text-gray-700">Filter:</span>
    
                        <!-- Filter Tahun -->
                        <div class="flex-1 md:flex-none">
                            <select id="year" v-model="selectedYear" class="block w-full border rounded-md p-2">
                            <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                        </select>
                        </div>
    
                        <!-- Filter Bulan -->
                        <div class="flex-1 md:flex-none">
                            <select id="month" v-model="selectedMonth" class="block w-full border rounded-md p-2">
                            <option v-for="(month, index) in months" :key="index" :value="index + 1">{{ month }}</option>
                        </select>
                        </div>
                    </div>
    
                    <!-- Pencarian -->
                    <div class="relative w-full md:w-64">
                        <TextInput 
                            v-model="searchQuery" 
                            placeholder="Cari Pemasukan..." 
                            class="pl-10 pr-4 py-2 border rounded-md w-full"
                        />
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z" />
                        </svg>
                    </div>
                </div>
            </div>
    
    
            <!-- Tabel Data -->
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full border bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Jumlah</th>
                            <th class="px-4 py-2 text-left">Sumber</th>
                            <th class="px-4 py-2 text-left">Sub Sumber</th>
                            <th class="px-4 py-2 text-left">Pembayaran</th>
                            <th class="px-4 py-2 text-left">Rekening</th>
                            <th v-if="settings.btn_edit || settings.btn_delete" class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in filteredIncomes" :key="item.id" class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2">{{ index + 1 }}</td>
                            <td class="px-4 py-2">{{ item.date }}</td>
                            <td class="px-4 py-2">{{ formatCurrency(item.amount) }}</td>
                            <td class="px-4 py-2">{{ item.source.name }}</td>
                            <td class="px-4 py-2">{{ item.sub_source?.name || '-' }}</td>
                            <td class="px-4 py-2">{{ item.payment }}</td>
                            <td class="px-4 py-2">{{ item.account_bank?.name || '-' }}</td>
                            <td v-if="settings.btn_edit || settings.btn_delete" class="px-4 py-2 text-center">
                                <SecondaryButton v-if="settings.btn_edit" @click="openModal('edit', item)">Edit</SecondaryButton>
                                <PrimaryButton v-if="settings.btn_delete" class="ml-2 bg-red-600 hover:bg-red-700" @click="confirmDelete(item.id)">Hapus</PrimaryButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
            <!-- Modal Create / Edit -->
            <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Pemasukan' : 'Tambah Pemasukan'" @close="closeModal">
                <template #content>
                    <form @submit.prevent="submitForm">
                        <div class="mb-4">
                            <InputLabel for="date" value="Tanggal" />
                            <TextInput id="date" type="date" v-model="form.date" class="block w-full" />
                            <InputError :message="form.errors.date" />
                        </div>
    
                        <div class="mb-4">
                            <InputLabel for="amount" value="Jumlah" />
                            <TextInput id="amount" type="number" v-model="form.amount" class="block w-full" />
                            <InputError :message="form.errors.amount" />
                        </div>
    
                        <div class="mb-4">
                            <InputLabel for="source_id" value="Sumber" />
                            <select id="source_id" v-model="form.source_id" class="block w-full border rounded-md p-2" @change="form.sub_source_id = null">
                                <option disabled value="">Pilih Sumber</option>
                                <option v-for="source in sources" :key="source.id" :value="source.id" :disabled="!source.is_active">{{ source.name }} <span v-if="!source.is_active">(Tidak Aktif)</span> </option>
                            </select>
                            <InputError :message="form.errors.source_id" />
                        </div>
    
                        <div class="mb-4">
                            <InputLabel for="sub_source_id" value="Sub Sumber" />
                            <select id="sub_source_id" v-model="form.sub_source_id" class="block w-full border rounded-md p-2" :disabled="!form.source_id">
                                <option disabled value="">Pilih Sub Sumber</option>
                                <option v-for="subSource in filteredSubSources" :key="subSource.id" :value="subSource.id" :disabled="!subSource.is_active">{{ subSource.name }} <span v-if="!subSource.is_active"  >(Tidak Aktif)</span> </option>
                            </select>
                            <InputError :message="form.errors.sub_source_id" />
                        </div>
    
                        <div class="mb-4">
                            <InputLabel for="payment" value="Pembayaran" />
                            <div class="flex space-x-4 mt-2">
                                <label class="flex items-center">
                                    <input type="radio" v-model="form.payment" value="Transfer" class="mr-2" @change="form.account_id = ''" />
                                    <span>Transfer</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" v-model="form.payment" value="Tunai" class="mr-2" @change="form.account_id = null" />
                                    <span>Tunai</span>
                                </label>
                            </div>
                            <InputError :message="form.errors.payment" />
                        </div>
    
                        <div class="mb-4" v-if="form.payment === 'Transfer'">
                            <InputLabel for="account_id" value="Rekening Tujuan" />
                            <select id="account_id" v-model="form.account_id" class="block w-full border rounded-md p-2">
                                <option disabled value="">Pilih Rekening</option>
                                <option v-for="account in accountBanks" :key="account.id" :value="account.id" :disabled="!account.is_active">{{ account.name }} <span v-if="!account.is_active">(Tidak Aktif)</span></option>
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
import { ref, computed, onMounted } from 'vue';
import { useForm, router, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import CustomModal from '@/Components/CustomModal.vue';

const props = defineProps({
    incomes: Array,
    sources: Array,
    subSources: Array,
    accountBanks: Array,
});

// Ambil data settings dari props
const settings = ref(usePage().props.settings);

const searchQuery = ref('');
const modalOpen = ref(false);
const isEditMode = ref(false);

// Filter Tahun dan Bulan
const years = Array.from({ length: 6 }, (_, i) => 2025 + i); // Tahun 2025-2030
const months = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

const selectedYear = ref(new Date().getFullYear()); // Default: Tahun saat ini
const selectedMonth = ref(new Date().getMonth() + 1); // Default: Bulan saat ini

// Filter data berdasarkan tahun, bulan, dan pencarian
const filteredIncomes = computed(() => {
    return props.incomes.filter(item => {
        const date = new Date(item.date);
        const matchesYear = date.getFullYear() === selectedYear.value;
        const matchesMonth = date.getMonth() + 1 === selectedMonth.value;
        const matchesSearch = item.source.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                              item.sub_source?.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                              item.payment.toLowerCase().includes(searchQuery.value.toLowerCase());

        return matchesYear && matchesMonth && matchesSearch;
    });
});

// Filter sub sumber berdasarkan source_id yang dipilih
const filteredSubSources = computed(() => {
    return props.subSources.filter(sub => sub.source_id === form.source_id);
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    }).format(value);
};

const form = useForm({
    id: '',
    date: '',
    amount: '',
    source_id: '',
    sub_source_id: null,
    payment: '', // Default payment
    account_id: null, // Default account_id
});

const openModal = (mode, item = null) => {
    isEditMode.value = mode === 'edit';
    
    if (isEditMode.value && item) {
        form.id = item.id;
        form.date = item.date;
        form.amount = item.amount;
        form.source_id = item.source_id;
        form.sub_source_id = item.sub_source_id;
        form.payment = item.payment;
        form.account_id = item.account_id;
    } else {
        form.reset();
    }
    
    modalOpen.value = true;
};

const closeModal = () => {
    form.reset();
    modalOpen.value = false;
};

const submitForm = () => {
    if (isEditMode.value) {
        form.put(route('income.update', form.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('income.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const confirmDelete = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus pemasukan ini?')) {
        router.delete(route('income.destroy', id), {
            onSuccess: () => {
                // Hapus dari daftar tanpa reload
                const index = props.incomes.findIndex((e) => e.id === id);
                if (index !== -1) {
                    props.incomes.splice(index, 1);
                }
            },
            onError: (errors) => {
                alert('Gagal menghapus pemasukan. Silakan coba lagi.');
            },
        });
    }
};


</script>