<template>
    <AppLayout title="Sub Category">
        <div class="p-4">
            <!-- Tombol Tambah Data -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
                <PrimaryButton @click="openModal('create')">Tambah Sub Kategori</PrimaryButton>
    
                <!-- Filter & Search -->
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
                    <!-- Filter Kategori -->
                    <select v-model="selectedCategory" class="border rounded px-4 py-2 w-full md:w-48">
                        <option value="">Semua Kategori</option>
                        <option v-for="category in props.category" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
    
                    <!-- Kolom Pencarian -->
                    <div class="relative">
                        <TextInput v-model="searchQuery" placeholder="Cari Sub Kategori..." class="w-full md:w-48 pl-10 pr-4 py-2 border" />
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z" />
                        </svg>
                    </div>
                </div>
            </div>
    
            <!-- Tabel Sub Kategori -->
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full border bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Kategori</th>
                            <th class="px-4 py-2 text-left">Nama</th>
                            <th class="px-4 py-2 text-left">Deskripsi</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th v-if="settings.btn_edit || settings.btn_delete" class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(subCategory, index) in filteredSubCategory" :key="subCategory.id" class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2">{{ index + 1 }}</td>
                            <td class="px-4 py-2">{{ subCategory.category.name }}</td>
                            <td class="px-4 py-2">{{ subCategory.name }}</td>
                            <td class="px-4 py-2">{{ subCategory.description || '-' }}</td>
                            <td class="px-4 py-2 text-center">
                                <span v-if="subCategory.is_active" class="px-2 py-1 text-green-700 bg-green-200 rounded-full text-sm">Aktif</span>
                                <span v-else class="px-2 py-1 text-red-700 bg-red-200 rounded-full text-sm">Tidak Aktif</span>
                            </td>
                            <td v-if="settings.btn_edit || settings.btn_delete" class="px-4 py-2 text-center">
                                <SecondaryButton v-if="settings.btn_edit" @click="openModal('edit', subCategory)">Edit</SecondaryButton>
                                <PrimaryButton v-if="settings.btn_delete" class="ml-2 bg-red-600 hover:bg-red-700" @click="confirmDelete(subCategory.id)">Hapus</PrimaryButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
            <!-- Modal Create / Edit -->
            <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Sub Kategori' : 'Tambah Sub Kategori'" @close="closeModal">
                <template #content>
                    <form @submit.prevent="submitForm">
                        <div class="mb-4">
                            <InputLabel for="category_id" value="Kategori" />
                            <select id="category_id" v-model="form.category_id" class="block w-full border rounded-md p-2">
                                <option v-for="category in props.category" 
                                    :key="category.id" 
                                    :value="category.id" 
                                    :disabled="!category.is_active">
                                    {{ category.name }} <span v-if="!category.is_active">(Tidak Aktif)</span>
                                </option>
                            </select>

                            <InputError :message="form.errors.category_id" />
                        </div>
    
                        <div class="mb-4">
                            <InputLabel for="name" value="Nama Sub Kategori" />
                            <TextInput id="name" v-model="form.name" class="block w-full" />
                            <InputError :message="form.errors.name" />
                        </div>
    
                        <div class="mb-4">
                            <InputLabel for="description" value="Deskripsi" />
                            <TextInput id="description" v-model="form.description" class="block w-full" />
                            <InputError :message="form.errors.description" />
                        </div>
    
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" v-model="form.is_active" class="mr-2" />
                            <label for="is_active">Aktif</label>
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
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import CustomModal from '@/Components/CustomModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    subCategory: Array,
    category: Array,
});

const modalOpen = ref(false);
const isEditMode = ref(false);

// Ambil data settings dari props
const settings = ref(usePage().props.settings);


const form = useForm({
    id: null,
    category_id: '',
    name: '',
    description: '',
    is_active: false,
});

// Filter & Pencarian
const selectedCategory = ref('');
const searchQuery = ref('');

// Filter data berdasarkan kategori dan pencarian
const filteredSubCategory = computed(() => {
    return props.subCategory.filter((item) => {
        const matchCategory = selectedCategory.value ? item.category_id === selectedCategory.value : true;
        const matchSearch = item.name.toLowerCase().includes(searchQuery.value.toLowerCase());
        return matchCategory && matchSearch;
    });
});

const openModal = (mode, subCategory = null) => {
    isEditMode.value = mode === 'edit';
    if (isEditMode.value && subCategory) {
        form.id = subCategory.id;
        form.category_id = subCategory.category_id;
        form.name = subCategory.name;
        form.description = subCategory.description;
        form.is_active = Boolean(subCategory.is_active);
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
        form.put(route('sub-category.update', form.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('sub-category.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const confirmDelete = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus sub kategori ini?')) {
        form.delete(route('sub-category.destroy', id));
    }
};
</script>