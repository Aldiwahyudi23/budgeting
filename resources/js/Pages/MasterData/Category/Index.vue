<template>
    <AppLayout title="Category">
        <div class="p-4">

                  <!-- Catatan -->
      <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
        <p class="text-sm">
          Centang 'Publik' di bawah jika ingin data ini dapat digunakan oleh pengguna lain.
        </p>
      </div>

           <!-- Bagian Header: Tombol Tambah, Pencarian & Link ke Categories Manage -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
            <div class="flex space-x-2">
                <PrimaryButton @click="openModal('create')">Tambah Kategori</PrimaryButton>
                <Link :href="route('categories.manage')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    Kelola Kategori
                </Link>
            </div>
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

    
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full border bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Public</th> <!-- Kolom checkbox -->
                            <th class="px-4 py-2 text-left">Nama</th>
                            <th class="px-4 py-2 text-left">Deskripsi</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in filteredCategories" :key="item.id" class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2">{{ index + 1 }}</td>
                            <!-- Kolom checkbox -->
                            <td class="px-4 py-2">
                                <input
                                    type="checkbox"
                                    :checked="item.public"
                                    @change="updatePublicStatus(item)"
                                    class="form-checkbox h-5 w-5 text-blue-600"
                                />
                            </td>
                            <td class="px-4 py-2">{{ item.name }}</td>
                            <td class="px-4 py-2">{{ item.description || '-' }}</td>
                            <td class="px-4 py-2 text-center">
                                <span v-if="item.is_active" class="px-2 py-1 text-green-700 bg-green-200 rounded-full text-sm">Aktif</span>
                                <span v-else class="px-2 py-1 text-red-700 bg-red-200 rounded-full text-sm">Tidak Aktif</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <SecondaryButton v-if="settings.btn_edit" @click="openModal('edit', item)">Edit</SecondaryButton>
                                <PrimaryButton v-if="settings.btn_delete" class="ml-2 bg-red-600 hover:bg-red-700" @click="confirmDelete(item.id)">Hapus</PrimaryButton>
                                <PrimaryButton class="ml-2 bg-blue-600 hover:bg-blue-700" @click="openSubSourceModal(item)">+ Sub</PrimaryButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
                
            <!-- Modal Create / Edit Kategori -->
            <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Kategori' : 'Tambah Kategori'" @close="closeModal">
                <template #content>
                    <form @submit.prevent="submitForm">
                        <div class="mb-4">
                            <InputLabel for="name">
                                Nama Kategori
                                <span class="text-red-500 text-sm">*</span>
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

            <!-- Modal Tambah Sub Kategori -->
            <CustomModal :show="subSourceModalOpen" title="Tambah Sub Kategori" @close="closeSubSourceModal">
                <template #content>
                    <form @submit.prevent="submitSubSourceForm">
                        <div class="mb-4">
                            <InputLabel for="category_id">
                                Kategori
                                <span class="text-red-500 text-sm">*</span>
                            </InputLabel>
                            <select id="category_id" v-model="subSourceForm.category_id" class="block w-full border rounded-md p-2">
                                <option v-for="category in categories" 
                                    :key="category.id" 
                                    :value="category.id" 
                                    :disabled="!category.is_active">
                                    {{ category.name }} <span v-if="!category.is_active">(Tidak Aktif)</span>
                                </option>
                            </select>
                            <InputError :message="subSourceForm.errors.category_id" />
                        </div>
    
                        <div class="mb-4">
                            <InputLabel for="name">
                                Nama Sub Kategori
                                <span class="text-red-500 text-sm">*</span>
                            </InputLabel>
                            <TextInput id="name" v-model="subSourceForm.name" class="block w-full" />
                            <InputError :message="subSourceForm.errors.name" />
                        </div>
    
                        <div class="mb-4">
                            <InputLabel for="description" value="Deskripsi" />
                            <TextInput id="description" v-model="subSourceForm.description" class="block w-full" />
                            <InputError :message="subSourceForm.errors.description" />
                        </div>
    
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" v-model="subSourceForm.is_active" class="mr-2" />
                            <label for="is_active">Aktif</label>
                        </div>
    
                        <div class="flex justify-end mt-4">
                            <SecondaryButton type="button" @click="closeSubSourceModal">Batal</SecondaryButton>
                            <PrimaryButton class="ml-3" type="submit">Simpan</PrimaryButton>
                        </div>
                    </form>
                </template>
            </CustomModal>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, reactive, computed } from 'vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import CustomModal from '@/Components/CustomModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

// State untuk kategori
const categories = reactive([...usePage().props.categories]);
const modalOpen = ref(false);
const subSourceModalOpen = ref(false);
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

// Form default untuk kategori
const defaultForm = {
    id: '',
    name: '',
    description: '',
    is_active: false,
};

// Form default untuk sub kategori
const defaultSubSourceForm = {
    category_id: '',
    name: '',
    description: '',
    is_active: false,
};

const form = useForm({ ...defaultForm });
const subSourceForm = useForm({ ...defaultSubSourceForm });

// Buka modal kategori
const openModal = (mode, item = null) => {
    isEditMode.value = mode === 'edit';
    
    if (isEditMode.value && item) {
        form.id = item.id;
        form.name = item.name;
        form.description = item.description;
        form.is_active = Boolean(item.is_active);
    } else {
        form.reset();
    }
    
    modalOpen.value = true;
};

// Buka modal sub kategori
const openSubSourceModal = (item) => {
    subSourceForm.category_id = item.id; // Set category_id dari data yang dipilih
    subSourceModalOpen.value = true;
};

// Tutup modal kategori
const closeModal = () => {
    form.reset();
    modalOpen.value = false;
};

// Tutup modal sub kategori
const closeSubSourceModal = () => {
    subSourceForm.reset();
    subSourceModalOpen.value = false;
};

// Submit form kategori
const submitForm = () => {
    if (isEditMode.value) {
        form.put(route('category.update', form.id), {
            onSuccess: () => {
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
                categories.unshift(response.props.categories[0]);
                closeModal();
            }
        });
    }
};

// Submit form sub kategori
const submitSubSourceForm = () => {
    subSourceForm.post(route('sub-category.store'), {
        onSuccess: () => {
            closeSubSourceModal();
        }
    });
};

// Hapus kategori
const confirmDelete = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
        form.delete(route('category.destroy', id), {
            onSuccess: () => {
                const index = categories.findIndex((c) => c.id === id);
                if (index !== -1) {
                    categories.splice(index, 1);
                }
            }
        });
    }
};

const hasPublicDuplicate = (source) => {
    return subCategories.value.some(
        (item) => item.name === source.name && item.public === true && item.id !== source.id
    );
};

// Fungsi untuk mengupdate status public
const updatePublicStatus = async (category) => {
    try {
        // Toggle status public
        category.public = !category.public;

        // Kirim permintaan ke backend untuk mengupdate status
        await axios.patch(`/categories/${category.id}/update-public`, {
            public: category.public,
        });

        // Tampilkan pesan sukses
        // alert('Status berhasil diupdate!');
    } catch (error) {
        // Jika gagal, kembalikan status ke semula
        category.public = !category.public;
        // alert('Gagal mengupdate status. Silakan coba lagi.');
    }
};
</script>