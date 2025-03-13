<template>
    <AppLayout title="Category">
        <div class="p-4">
            <!-- Bagian Header: Tombol Tambah & Pencarian -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
                <PrimaryButton @click="openModal('create')">Tambah Kategori</PrimaryButton>
                <div class="relative">
                    <TextInput 
                        v-model="searchQuery" 
                        placeholder="Cari Kategori..." 
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
                <th class="px-4 py-2 text-left">Nama</th>
                <th class="px-4 py-2 text-left">Deskripsi</th>
                <th class="px-4 py-2 text-center">Status</th>
                <!-- Kolom Aksi hanya muncul jika btn_edit atau btn_delete true -->
                <th v-if="settings.btn_edit || settings.btn_delete" class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in filteredCategories" :key="item.id" class="border-b hover:bg-gray-100">
                <td class="px-4 py-2">{{ index + 1 }}</td>
                <td class="px-4 py-2">{{ item.name }}</td>
                <td class="px-4 py-2">{{ item.description || '-' }}</td>
                <td class="px-4 py-2 text-center">
                    <span v-if="item.is_active" class="px-2 py-1 text-green-700 bg-green-200 rounded-full text-sm">Aktif</span>
                    <span v-else class="px-2 py-1 text-red-700 bg-red-200 rounded-full text-sm">Tidak Aktif</span>
                </td>
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
    
            <!-- Modal Create / Edit -->
            <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Kategori' : 'Tambah Kategori'" @close="closeModal">
                <template #content>
                    <form @submit.prevent="submitForm">
                        <div class="mb-4">
                            <InputLabel for="name">
                            Nama Kategori
                            <span class="text-red-500 text-sm" >*</span>
                            </InputLabel>
                            <TextInput id="name" v-model="form.name" class="block w-full" required />
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
import { ref, reactive, computed } from 'vue'; // Pastikan `computed` diimpor
import { useForm, usePage } from '@inertiajs/vue3';
import CustomModal from '@/Components/CustomModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

// State untuk kategori (dapat diperbarui langsung)
const categories = reactive([...usePage().props.categories]);
const modalOpen = ref(false);
const isEditMode = ref(false);
const searchQuery = ref('');


// Ambil data settings dari props
const settings = ref(usePage().props.settings);

// Filter kategori berdasarkan pencarian
const filteredCategories = computed(() => {
    return categories.filter(item => 
        item.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Form default (di-reset setiap kali modal dibuka)
const defaultForm = {
    id: '',
    name: '',
    description: '',
    is_active: false,
};

// Menggunakan form reaktif
const form = useForm({ ...defaultForm });

const openModal = (mode, item = null) => {
    isEditMode.value = mode === 'edit';
    
    if (isEditMode.value && item) {
        // Pastikan `is_active` benar-benar boolean (bukan null atau string)
        form.id = item.id;
        form.name = item.name;
        form.description = item.description;
        form.is_active = Boolean(item.is_active);
    } else {
        form.reset(); // Reset data form ketika membuka modal Create
    }
    
    modalOpen.value = true;
};

const closeModal = () => {
    form.reset(); // Reset form saat modal ditutup
    modalOpen.value = false;
};

const submitForm = () => {
    if (isEditMode.value) {
        form.put(route('category.update', form.id), {
            onSuccess: () => {
                // Perbarui kategori dalam state tanpa reload
                const index = categories.findIndex((c) => c.id === form.id);
                if (index !== -1) {
                    categories[index] = { ...form.data() };
                }
                closeModal();
            }
        });
    } else {
        form.post(route('category.store'), {
            onSuccess: (response) => {
                // Tambahkan kategori baru ke daftar tanpa reload
                categories.unshift(response.props.categories[0]);
                closeModal();
            }
        });
    }
};

const confirmDelete = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
        form.delete(route('category.destroy', id), {
            onSuccess: () => {
                // Hapus dari daftar tanpa reload
                const index = categories.findIndex((c) => c.id === id);
                if (index !== -1) {
                    categories.splice(index, 1);
                }
            }
        });
    }
};
</script>