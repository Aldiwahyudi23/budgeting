<template>
    <AppLayout title="Allocation">
        <div class="p-4">
            <!-- Filter Tahun dan Bulan -->
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mb-4">
                <select v-model="selectedYear" class="border rounded px-4 py-2 w-full md:w-48">
                    <option value="">Pilih Tahun</option>
                    <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                </select>
                <select v-model="selectedMonth" class="border rounded px-4 py-2 w-full md:w-48">
                    <option value="">Pilih Bulan</option>
                    <option v-for="month in months" :key="month.value" :value="month.value">{{ month.label }}</option>
                </select>
            </div>
    
            <!-- Tabel Data -->
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full border bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Kategori</th>
                            <th class="px-4 py-2 text-left">Jumlah</th>
                            <th class="px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in filteredCategories" :key="category.id" class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2">
                                <input 
                                    type="checkbox" 
                                    v-model="category.is_active" 
                                    :true-value="1" 
                                    :false-value="0"
                                    @change="updateCategoryStatus(category)"
                                    class="form-checkbox h-5 w-5 text-blue-600"
                                />
                            </td>
                            <td class="px-4 py-2">
                                <span :class="{ 'text-red-500': !category.is_active }">
                                    {{ category.name }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <TextInput 
                                    v-model="amountInputs[category.id]" 
                                    type="text" 
                                    class="block w-full" 
                                    :disabled="isSaved(category.id)"
                                    @input="handleAmountInput(category.id, $event)"
                                />
                            </td>
                            <td class="px-4 py-2">
                                <PrimaryButton 
                                    @click="isSaved(category.id) ? resetInput(category.id) : saveInput(category.id)"
                                    :class="{ 'bg-green-600 hover:bg-green-700': !isSaved(category.id), 'bg-red-600 hover:bg-red-700': isSaved(category.id) }"
                                >
                                    {{ isSaved(category.id) ? 'Reset' : 'Simpan' }}
                                </PrimaryButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    transactions: Array,
    categories: Array,
    filters: Object,
});

// State untuk filter
const selectedYear = ref(props.filters.year || new Date().getFullYear().toString());
const selectedMonth = ref(props.filters.month || (new Date().getMonth() + 1).toString().padStart(2, '0'));

// State untuk input amount
const amountInputs = ref({});
const savedInputs = ref({});

// Daftar tahun dari 2025 sampai 2030
const years = computed(() => {
    const startYear = 2025;
    const endYear = 2030;
    const years = [];
    for (let year = startYear; year <= endYear; year++) {
        years.push(year.toString());
    }
    return years;
});

// Daftar bulan dari Januari sampai Desember
const months = computed(() => {
    return [
        { value: '01', label: 'Januari' },
        { value: '02', label: 'Februari' },
        { value: '03', label: 'Maret' },
        { value: '04', label: 'April' },
        { value: '05', label: 'Mei' },
        { value: '06', label: 'Juni' },
        { value: '07', label: 'Juli' },
        { value: '08', label: 'Agustus' },
        { value: '09', label: 'September' },
        { value: '10', label: 'Oktober' },
        { value: '11', label: 'November' },
        { value: '12', label: 'Desember' },
    ];
});

// Inisialisasi amountInputs dengan data dari transaksi
const initializeInputs = () => {
    const date = `${selectedYear.value}-${selectedMonth.value}`; // Format YYYY-MM
    amountInputs.value = {}; // Reset amountInputs
    savedInputs.value = {}; // Reset savedInputs

    props.transactions.forEach(transaction => {
        if (transaction.date === date) {
            amountInputs.value[transaction.category_id] = formatCurrency(transaction.amount);
            savedInputs.value[transaction.category_id] = true; // Tandai sebagai sudah disimpan
        }
    });
};

// Panggil fungsi inisialisasi saat komponen dimuat
onMounted(initializeInputs);

// Filter kategori yang aktif
const filteredCategories = computed(() => {
    return props.categories;
});

// Filter transaksi berdasarkan tahun dan bulan
const filteredTransactions = computed(() => {
    const date = `${selectedYear.value}-${selectedMonth.value}`; // Format YYYY-MM
    return props.transactions.filter(transaction => transaction.date === date);
});

// Cek apakah input sudah disimpan
const isSaved = (categoryId) => {
    return savedInputs.value[categoryId] !== undefined;
};

// Simpan input
const saveInput = (categoryId) => {
    const date = `${selectedYear.value}-${selectedMonth.value}`; // Format YYYY-MM
    const amount = parseFloat(amountInputs.value[categoryId].replace(/[^0-9.]/g, '')); // Hapus format mata uang
    savedInputs.value[categoryId] = amount;
    useForm({
        category_id: categoryId,
        amount: amount,
        date: date,
    }).post(route('allocation-ex.store'), {
        onSuccess: () => {
            // Tambahkan data ke transactions tanpa perlu refresh
            props.transactions.push({
                id: Date.now(), // ID sementara
                category_id: categoryId,
                amount: amount,
                date: date,
                category: props.categories.find(c => c.id === categoryId),
            });
            amountInputs.value[categoryId] = formatCurrency(amount);
        },
    });
};

// Reset input
const resetInput = (categoryId) => {
    const date = `${selectedYear.value}-${selectedMonth.value}`; // Format YYYY-MM

    // Cari data transaksi yang sesuai dengan category_id dan date
    const transaction = props.transactions.find(t => t.category_id === categoryId && t.date === date);

    if (!transaction) {
        alert('Data tidak ditemukan.');
        return;
    }

    // Hapus data dari backend
    useForm({}).delete(route('allocation-ex.destroy', transaction.id), {
        onSuccess: () => {
            // Hapus data dari transactions tanpa perlu refresh
            const index = props.transactions.findIndex(t => t.id === transaction.id);
            if (index !== -1) {
                props.transactions.splice(index, 1);
            }

            // Reset input
            delete savedInputs.value[categoryId];
            amountInputs.value[categoryId] = '';
        },
    });
};
// Update status kategori
const updateCategoryStatus = (category) => {
    useForm({
        is_active: category.is_active,
    }).put(route('category_active', category.id));
};

// Format mata uang
const formatCurrency = (amount) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    }).format(amount);
};

// Handle input amount
const handleAmountInput = (categoryId, event) => {
    const value = event.target.value;
    const numericValue = value.replace(/[^0-9.]/g, ''); // Hapus karakter non-numerik
    amountInputs.value[categoryId] = numericValue; // Simpan nilai numerik
    event.target.value = formatCurrency(numericValue); // Tampilkan nilai yang diformat
};

// Watch perubahan tahun dan bulan
watch([selectedYear, selectedMonth], ([year, month]) => {
    // Me-refresh halaman saat filter berubah
    router.get(route('allocation-ex.index'), { year, month }, { preserveState: false });
});
</script>