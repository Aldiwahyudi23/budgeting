<template>
    <AppLayout title="Source">
        <div class="p-4">

                      <!-- Catatan -->
      <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
        <p class="text-sm">
          Centang 'Publik' di bawah jika ingin data ini dapat digunakan oleh pengguna lain.
        </p>
      </div>
            <!-- Bagian Header: Tombol Tambah & Pencarian -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
                
                 <div class="flex space-x-2">
               <PrimaryButton @click="openModal('create')">Tambah Sumber (Source)</PrimaryButton>
                <Link :href="route('sources.manage')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    Kelola Sumber
                </Link>
            </div>
                <div class="relative">
                    <TextInput 
                        v-model="searchQuery" 
                        placeholder="Cari Source..." 
                        class="pl-10 pr-4 py-2 border rounded-md w-64"
                    />
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z" />
                    </svg>
                </div>
            </div>
    
            <!-- Tabel Data -->
            <div class="overflow-x-auto">
                <table class="min-w-full border bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-center">public</th>
                            <th class="px-4 py-2 text-left">Nama</th>
                            <th class="px-4 py-2 text-left">Deskripsi</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(source, index) in filteredSources" :key="source.id" class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2">{{ index + 1 }}</td>
                            <!-- Kolom checkbox -->
                            <td class="px-4 py-2">
                                <input
                                    type="checkbox"
                                    :checked="source.public"
                                    @change="updatePublicStatus(source)"
                                    class="form-checkbox h-5 w-5 text-blue-600"
                                />
                            </td>
                            <td class="px-4 py-2">{{ source.name }}</td>
                            <td class="px-4 py-2">{{ source.description || '-' }}</td>
                            <td class="px-4 py-2 text-center">
                                <span v-if="source.is_active" class="px-2 py-1 text-green-700 bg-green-200 rounded-full text-sm">Aktif</span>
                                <span v-else class="px-2 py-1 text-red-700 bg-red-200 rounded-full text-sm">Tidak Aktif</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <SecondaryButton v-if="settings.btn_edit" @click="openModal('edit', source)">Edit</SecondaryButton>
                                <PrimaryButton v-if="settings.btn_delete" class="ml-2 bg-red-600 hover:bg-red-700" @click="confirmDelete(source.id)">Hapus</PrimaryButton>
                                <PrimaryButton  class="ml-2 bg-blue-600 hover:bg-blue-700" @click="openSubSourceModal(source)">+ Sub</PrimaryButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
            <!-- Modal Create / Edit Source -->
            <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Sumber (Source)' : 'Tambah Sumber (Source)'" @close="closeModal">
                <template #content>
                    <form @submit.prevent="submitForm">
                        <div class="mb-4">
                            <InputLabel for="name">
                                Nama Sumber (Source)
                                <span class="text-red-500 text-sm" >*</span>
                            </InputLabel>
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

            <!-- Modal Tambah Sub Source -->
            <CustomModal :show="subSourceModalOpen" title="Tambah Sub Sumber (Source)" @close="closeSubSourceModal">
                <template #content>
                    <form @submit.prevent="submitSubSourceForm">
                        <div class="mb-4">
                            <InputLabel for="source_id">
                                Sumber (Source)
                                <span class="text-red-500 text-sm">*</span>
                            </InputLabel>
                            <select id="source_id" v-model="subSourceForm.source_id" class="block w-full border rounded-md p-2">
                                <option v-for="source in sources" 
                                    :key="source.id" 
                                    :value="source.id"
                                    :disabled="!source.is_active"
                                >
                                    {{ source.name }} <span v-if="!source.is_active">(Tidak Aktif)</span>
                                </option>
                            </select>
                            <InputError :message="subSourceForm.errors.source_id" />
                        </div>
    
                        <div class="mb-4">
                            <InputLabel for="name">
                                Nama Sub Sumber (Source)
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
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed, reactive } from 'vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import CustomModal from '@/Components/CustomModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

// State untuk daftar sumber
const sources = reactive([...usePage().props.sources]);
const modalOpen = ref(false);
const subSourceModalOpen = ref(false);
const isEditMode = ref(false);
const searchQuery = ref('');

// Ambil data settings dari props
const settings = ref(usePage().props.settings);

// Filter sumber berdasarkan pencarian
const filteredSources = computed(() => {
    return sources.filter(source => 
        source.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Form default untuk Source
const defaultForm = {
    id: '',
    name: '',
    description: '',
    is_active: false,
};

const form = useForm({ ...defaultForm });

// Form default untuk Sub Source
const defaultSubSourceForm = {
    source_id: '',
    name: '',
    description: '',
    is_active: false,
};

const subSourceForm = useForm({ ...defaultSubSourceForm });

// Buka modal Source
const openModal = (mode, source = null) => {
    isEditMode.value = mode === 'edit';
    
    if (isEditMode.value && source) {
        form.id = source.id;
        form.name = source.name;
        form.description = source.description;
        form.is_active = Boolean(source.is_active);
    } else {
        form.reset();
    }
    
    modalOpen.value = true;
};

// Buka modal Sub Source
const openSubSourceModal = (source) => {
    subSourceForm.source_id = source.id; // Set source_id dari data yang dipilih
    subSourceModalOpen.value = true;
};

// Tutup modal Source
const closeModal = () => {
    form.reset();
    modalOpen.value = false;
};

// Tutup modal Sub Source
const closeSubSourceModal = () => {
    subSourceForm.reset();
    subSourceModalOpen.value = false;
};

// Submit form Source
const submitForm = () => {
    if (isEditMode.value) {
        form.put(route('source.update', form.id), {
            onSuccess: () => {
                const index = sources.findIndex((s) => s.id === form.id);
                if (index !== -1) {
                    sources[index] = { ...form.data() };
                }
                closeModal();
            }
        });
    } else {
        form.post(route('source.store'), {
            onSuccess: (response) => {
                sources.unshift(response.props.sources[0]);
                closeModal();
            }
        });
    }
};

// Submit form Sub Source
const submitSubSourceForm = () => {
    subSourceForm.post(route('sub-sources.store'), {
        onSuccess: () => {
            closeSubSourceModal();
        }
    });
};

// Hapus Source
const confirmDelete = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus sumber ini?')) {
        form.delete(route('source.destroy', id), {
            onSuccess: () => {
                const index = sources.findIndex((s) => s.id === id);
                if (index !== -1) {
                    sources.splice(index, 1);
                }
            }
        });
    }
};

// Ambil user ID yang sedang login
const userId = usePage().props.auth.user.id;

// Kelompokkan data berdasarkan name
const groupedSources = computed(() => {
    const groups = {};
    sources.forEach(source => {
        if (!groups[source.name]) {
            groups[source.name] = [];
        }
        groups[source.name].push(source);
    });
    return groups;
});

// Fungsi untuk menentukan apakah checkbox harus muncul
const shouldShowCheckbox = (source) => {
    const group = groupedSources.value[source.name]; // Ambil semua item dengan name yang sama
    const hasPublicTrue = group.some(item => item.public === true); // Cek apakah ada yang public = true

    // Jika ada yang public = true, hanya item public true yang boleh tampil
    if (hasPublicTrue) {
        return source.public === true;
    }

    // Jika tidak ada yang public = true, semua tetap muncul
    return true;
};


// Fungsi untuk mengupdate status public
const updatePublicStatus = async (source) => {
    try {
        // Toggle status public
        source.public = !source.public;

        // Kirim permintaan ke backend untuk mengupdate status
        await axios.patch(`/sources/${source.id}/update-public`, {
            public: source.public,
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