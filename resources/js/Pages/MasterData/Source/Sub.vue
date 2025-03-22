<template>
    <AppLayout title="Sub Source">
        <div class="p-4">
             <!-- Tombol Tambah Data -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
                <PrimaryButton @click="openModal('create')">Tambah Sub Sumber (Source)</PrimaryButton>
    
                <!-- Filter & Search -->
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
                    <!-- Filter Kategori -->
                    <select v-model="selectedSource" class="border rounded px-4 py-2 w-full md:w-48">
                        <option value="">Semua Sumber (Source)</option>
                        <option v-for="source in props.sources" 
                        :key="source.id" 
                        :value="source.id">
                            {{ source.name }}
                        </option>
                    </select>
    
                    <!-- Kolom Pencarian -->
                     <div class="relative">
                         <TextInput v-model="searchQuery" placeholder="Cari Sub Sumber (Source)..." class="w-full md:w-48 pl-10 pr-4 py-2 border" />
                          <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z" />
                         </svg>
                     </div>
                </div>
            </div>
    
            <!-- Tabel Sub Sources -->
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full border bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-center">Public</th>
                            <th class="px-4 py-2 text-left">Sumber</th>
                            <th class="px-4 py-2 text-left">Nama</th>
                            <!-- <th class="px-4 py-2 text-left">Deskripsi</th> -->
                            <th class="px-4 py-2 text-center">Status</th>
                            <th v-if="settings.btn_edit || settings.btn_delete" class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                       <tr v-for="(subSource, index) in filteredSubSources" :key="subSource.id" class="border-b hover:bg-gray-100">
                           <td class="px-4 py-2">{{ index + 1 }}</td>
                           <!-- Kolom checkbox -->
                          <td class="px-4 py-2">
                              <input
                                  type="checkbox"
                                  :checked="subSource.public"
                                  @change="updatePublicStatus(subSource)"
                                  class="form-checkbox h-5 w-5 text-blue-600"
                              />
                          </td>
                        <td class="px-4 py-2">{{ subSource.source.name }}</td>
                        <td class="px-4 py-2">{{ subSource.name }}</td>
                        <!-- <td class="px-4 py-2">{{ subSource.description || '-' }}</td> -->
                        <td class="px-4 py-2 text-center">
                            <span v-if="subSource.is_active" class="px-2 py-1 text-green-700 bg-green-200 rounded-full text-sm">Aktif</span>
                            <span v-else class="px-2 py-1 text-red-700 bg-red-200 rounded-full text-sm">Tidak Aktif</span>
                        </td>
                        <td v-if="settings.btn_edit || settings.btn_delete" class="px-4 py-2 text-center">
                            <SecondaryButton v-if="settings.btn_edit" @click="openModal('edit', subSource)">Edit</SecondaryButton>
                            <PrimaryButton v-if="settings.btn_delete" class="ml-2 bg-red-600 hover:bg-red-700" @click="confirmDelete(subSource.id)">Hapus</PrimaryButton>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
    
            <!-- Modal Create / Edit -->
            <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Sub Source' : 'Tambah Sub Source'" @close="closeModal">
                <template #content>
                    <form @submit.prevent="submitForm">
                        <div class="mb-4">
                            <InputLabel for="source_id" >
                                Sumber (Source)
                                <span class="text-red-500 tsxt-m">*</span>
                            </InputLabel>
                            <select id="source_id" v-model="form.source_id" class="block w-full border rounded-md p-2">
                                <option v-for="source in sources" 
                                :key="source.id" 
                                :value="source.id"
                                :disabled="!source.is_active"
                                >{{ source.name }} <span v-if="!source.is_active">(Tidak Aktif)</span>
                            </option>
                            </select>
                            <InputError :message="form.errors.source_id" />
                        </div>
    
                        <div class="mb-4">
                            <InputLabel for="name" >
                            Nama Sub Sumber (Source)
                            <span class="text-red-500 tsxt-m">*</span>
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
    subSources: Array,
    sources: Array,
});

const modalOpen = ref(false);
const isEditMode = ref(false);

// Ambil data settings dari props
const settings = ref(usePage().props.settings);

const form = useForm({
    id: null,
    source_id: '',
    name: '',
    description: '',
    is_active: false,
});

// Filter & Pencarian
const selectedSource = ref('');
const searchQuery = ref('');

// Filter data berdasarkan kategori dan pencarian
const filteredSubSources = computed(() => {
    return props.subSources.filter((item) => {
        const matchSource = selectedSource.value ? item.source_id === selectedSource.value : true;
        const matchSearch = item.name.toLowerCase().includes(searchQuery.value.toLowerCase());
        return matchSource && matchSearch;
    });
});

const openModal = (mode, subSource = null) => {
    isEditMode.value = mode === 'edit';
    if (isEditMode.value && subSource) {
        form.id = subSource.id;
        form.source_id = subSource.source_id;
        form.name = subSource.name;
        form.description = subSource.description;
        form.is_active = Boolean(subSource.is_active);
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
        form.put(route('sub-sources.update', form.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('sub-sources.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const confirmDelete = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus sub source ini?')) {
        form.delete(route('sub-sources.destroy', id));
    }
};

// Fungsi untuk mengupdate status public
const updatePublicStatus = async (subSource) => {
    try {
        // Toggle status public
        subSource.public = !subSource.public;

        // Kirim permintaan ke backend untuk mengupdate status
        await axios.patch(`/sub-sources/${subSource.id}/update-public`, {
            public: subSource.public,
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