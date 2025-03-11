<template>
    <AppLayout title= "Saving (Tabungan)">
        <div class="p-4">
                     <!-- Tampilkan flash message jika ada -->
        <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
          {{ $page.props.flash.success }}
        </div>
    
        <div v-if="$page.props.flash.error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
          {{ $page.props.flash.error }}
        </div>
        <!-- Tampilkan Saldo per Sub Kategori -->
     <div class="mb-2">
         <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
             <div v-for="subCategory in subCategoryBalances" :key="subCategory.id" class="bg-white p-4 rounded-lg shadow-md">
                 <h3 class="text-gray-700 font-medium">{{ subCategory.name }}</h3>
                 <p class="text-2xl font-bold" :class="subCategory.balance < 0 ? 'text-red-600' : 'text-green-600'">
                     {{ formatCurrency(subCategory.balance) }}
                 </p>
             </div>
         </div>
     </div>
            <!-- Bagian Header: Tombol Tambah & Pencarian -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
               
                <!-- <PrimaryButton @click="openModal('create')">Tambah Tabungan</PrimaryButton> -->
                <div class="relative">
                    <TextInput 
                        v-model="searchQuery" 
                        placeholder="Cari Tabungan..." 
                        class="pl-10 pr-4 py-2 border rounded-md w-64"
                    />
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z" />
                    </svg>
                </div>
            </div>
    
            <!-- Tabel Data -->
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full border bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Kategori</th>
                            <th class="px-4 py-2 text-left">Catatan</th>
                            <th class="px-4 py-2 text-left">Masuk</th>
                            <th class="px-4 py-2 text-left">Keluar</th>
                            <th class="px-4 py-2 text-left">Saldo</th>
                            <!-- Kolom Aksi hanya muncul jika btn_edit atau btn_delete true -->
                            <th v-if="settings.btn_edit || settings.btn_delete" class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in paginatedSavings" :key="item.id" class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2">{{ (currentPage - 1) * perPage + index + 1 }}</td>
                            <td class="px-4 py-2">{{ item.date }}</td>
                            <td class="px-4 py-2">{{ item.sub_category?.name || '-' }}</td>
                            <td class="px-4 py-2">{{ item.note || '-' }}</td>
                            <td class="px-4 py-2 text-green-600">
                                {{ item.amount > 0 ? formatCurrency(item.amount) : '-' }}
                            </td>
                            <td class="px-4 py-2 text-red-600">
                                {{ item.amount < 0 ? formatCurrency(Math.abs(item.amount)) : '-' }}
                            </td>
                            <td class="px-4 py-2">{{ formatCurrency(item.balance) }}</td>
                            <!-- Kolom Aksi hanya muncul jika btn_edit atau btn_delete true -->
                            <td v-if="settings.btn_edit || settings.btn_delete" class="px-4 py-2 text-center">
                                <!-- Tombol Edit hanya muncul jika btn_edit true -->
                                <SecondaryButton v-if="settings.btn_edit" @click="openModal('edit', item)">Edit</SecondaryButton>
                                <!-- Tombol Hapus hanya muncul jika btn_delete true -->
                                <PrimaryButton v-if="settings.btn_delete" class="ml-2 bg-red-600 hover:bg-red-700" @click="confirmDelete(item.id)">Hapus</PrimaryButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
            <!-- Pagination -->
            <div class="flex justify-between items-center mt-4">
                <div class="flex items-center space-x-2">
                    <!-- <span class="text-sm text-gray-700">Menampilkan</span> -->
                    <select v-model="perPage" class="border rounded-md p-1 text-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <!-- <span class="text-sm text-gray-700">data per halaman</span> -->
                </div>
                <div class="flex space-x-2">
                    <button 
                        @click="prevPage" 
                        :disabled="currentPage === 1" 
                        class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 disabled:opacity-50"
                    >
                        back
                    </button>
                    <button 
                        @click="nextPage" 
                        :disabled="currentPage === totalPages" 
                        class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 disabled:opacity-50"
                    >
                        next
                    </button>
                </div>
            </div>
    
            <!-- Modal Create / Edit -->
            <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Tabungan' : 'Tambah Tabungan'" @close="closeModal">
                <template #content>
                    <form @submit.prevent="submitForm">
                        <div class="mb-4">
                            <InputLabel for="date" value="Tanggal" />
                            <TextInput id="date" type="date" v-model="form.date" class="block w-full" required />
                            <InputError :message="form.errors.date" />
                        </div>
    
                        <div class="mb-4">
                            <InputLabel for="amount" value="Jumlah" />
                            <TextInput id="amount" type="number" v-model="form.amount" class="block w-full" required />
                            <InputError :message="form.errors.amount" />
                        </div>
    
                        <div class="mb-4">
                            <InputLabel for="note" value="Catatan" />
                            <TextInput id="note" v-model="form.note" class="block w-full" />
                            <InputError :message="form.errors.note" />
                        </div>
    
                       <div class="mb-4">
                            <InputLabel for="category_id" value="Tabungan" />
                            <select id="category_id" v-model="form.category_id" class="block w-full border rounded-md p-2" @change="form.sub_category_id = null">
                                <option disabled value="">Pilih Tabungan</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                            </select>
                            <InputError :message="form.errors.category_id" />
                        </div>
    
                        <div class="mb-4">
                            <InputLabel for="sub_category_id" value="Data Tabungan" />
                            <select id="sub_category_id" v-model="form.sub_category_id" class="block w-full border rounded-md p-2" :disabled="!form.category_id">
                                <option disabled value="">Pilih Data Tabungan</option>
                                <option v-for="subCategory in filteredSubCategories" :key="subCategory.id" :value="subCategory.id">{{ subCategory.name }}</option>
                            </select>
                            <InputError :message="form.errors.sub_category_id" />
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
import { ref, reactive, computed } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import CustomModal from '@/Components/CustomModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { handleFlashMessages } from '@/Plugins/sweetalert';

// Tangkap flash message dari Laravel
const page = usePage();
console.log(page.props.flash); // Periksa isi flash message
handleFlashMessages(page);

const props = defineProps({
    savings: Array,
    categories: Array,
    subCategories: Array,
});

const settings = ref(usePage().props.settings);
const searchQuery = ref('');
const modalOpen = ref(false);
const isEditMode = ref(false);
const currentPage = ref(1);
const perPage = ref(10);
const selectedSubCategory = ref('');

// Filter tabungan berdasarkan pencarian dan sub kategori
const filteredSavings = computed(() => {
    return props.savings.filter(item => 
        item.category.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        item.sub_category?.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        item.note.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const findSavingCategoryId = () => {
    const savingCategory = props.categories.find(category => category.name === 'Saving');
    return savingCategory ? savingCategory.id : null;
};

// Filter sub kategori berdasarkan category_id yang dipilih
const filteredSubCategories = computed(() => {
    return props.subCategories.filter(sub => sub.category_id === form.category_id);
});

// Pagination
const paginatedSavings = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return filteredSavings.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredSavings.value.length / perPage.value));

const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
};

const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--;
};

// Saldo per Sub Kategori (berdasarkan balance terbaru)
const subCategoryBalances = computed(() => {
    const balances = {};
    props.savings.forEach(item => {
        // Jika sub kategori belum ada di balances atau item ini lebih baru
        if (!balances[item.sub_category_id] || new Date(item.date) > new Date(balances[item.sub_category_id].date)) {
            balances[item.sub_category_id] = {
                id: item.sub_category_id,
                name: item.sub_category?.name || 'Tanpa Sub Kategori',
                balance: item.balance, // Menggunakan balance dari entri terbaru
                date: item.date, // Menyimpan tanggal untuk perbandingan
            };
        }
    });
    return Object.values(balances);
});

// Format jumlah uang ke dalam format mata uang
const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    }).format(value || 0);
};

// Form default (di-reset setiap kali modal dibuka)
const defaultForm = {
    id: '',
    date: '',
    amount: 0,
    note: '',
    category_id: '',
    sub_category_id: null,
};

// Menggunakan form reaktif
const form = useForm({ ...defaultForm });

const openModal = (mode, item = null) => {
    isEditMode.value = mode === 'edit';
    
    if (isEditMode.value && item) {
        form.id = item.id;
        form.date = item.date;
        form.amount = item.amount;
        form.note = item.note;
        form.category_id = item.category_id;
        form.sub_category_id = item.sub_category_id;
    } else {
        form.reset(); // Reset data form ketika membuka modal Create
   form.category_id = findSavingCategoryId(); // Setel ke kategori "Saving"
    }
    
    modalOpen.value = true;
};

const closeModal = () => {
    form.reset(); // Reset form saat modal ditutup
    modalOpen.value = false;
};

const submitForm = () => {
    if (isEditMode.value) {
        form.put(route('savings.update', form.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('savings.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const confirmDelete = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus tabungan ini?')) {
        router.delete(route('savings.destroy', id), {
            onSuccess: () => {
                // Hapus dari daftar tanpa reload
                const index = props.savings.findIndex((s) => s.id === id);
                if (index !== -1) {
                    props.savings.splice(index, 1);
                }
            },
        });
    }
};
</script>