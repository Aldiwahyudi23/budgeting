<template>
  <AppLayout title="Kelola Kategori">
    <div class="p-4">
      <div class="container mx-auto p-2">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-xl font-semibold text-gray-800">Kelola Kategori</h3>
          <PrimaryButton @click="saveSelected">Simpan Kategori Dipilih</PrimaryButton>
        </div>

<!-- Tabel Category dan SubCategory -->
<div class="bg-white rounded-lg shadow-md overflow-x-auto">
  <table class="min-w-full table-auto">
    <thead class="bg-gray-200">
      <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pilih</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kategori</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      <!-- Loop melalui kategori yang unik -->
      <template v-if="uniqueCategories.length > 0">
        <template v-for="category in uniqueCategories" :key="category.id">
          <!-- Baris untuk Category -->
          <tr :class="{ 'disabled-row bg-blue-100': isCategoryDisabled(category) }">
            <td class="px-6 py-4 whitespace-nowrap">
              <input 
                type="checkbox" 
                v-model="selectedCategories" 
                :value="category.id" 
                :disabled="isCategoryDisabled(category)"
                @change="onCategorySelect(category)"
              />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="category-name font-medium">
                {{ category.name }}
                <span v-if="isCategoryDisabled(category)" class="text-xs text-red-500 ml-2">(Sudah Ada)</span>
              </div>
              <div class="text-xs text-gray-500">{{ category.description }}</div> <!-- Deskripsi kategori -->
            </td>
          </tr>

          <!-- Loop melalui subkategori yang sesuai dengan kategori -->
          <tr 
            v-for="subCategory in getAllSubCategories(category.id)" 
            :key="subCategory.id" 
            :class="{ 'disabled-row': isSubCategoryDisabled(subCategory) }"
          >
            <td class="px-6 py-4 whitespace-nowrap subcategory-indent">
              <input 
                type="checkbox" 
                v-model="selectedSubCategories" 
                :value="subCategory.id" 
                :disabled="isSubCategoryDisabled(subCategory)"
                @change="onSubCategorySelect(subCategory)"
              />
            </td>
            <td class="px-6 py-4 whitespace-nowrap subcategory-indent">
              <div class="subcategory-name font-medium">
                {{ subCategory.name }}
                <span v-if="isSubCategoryDisabled(subCategory)" class="text-xs text-red-500 ml-2">(Sudah Ada)</span>
              </div>
              <div class="text-xs text-gray-500">{{ subCategory.description }}</div> <!-- Deskripsi subkategori -->
            </td>
          </tr>
        </template>
      </template>
      <template v-else>
        <tr>
          <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data kategori.</td>
        </tr>
      </template>
    </tbody>
  </table>
</div>

      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';

// Props dari controller
const props = defineProps({
  categories: Array, // Data kategori dari backend
  subCategories: Array, // Data sub kategori dari backend
  userCategories: Array, // Data kategori yang sudah dimiliki user
  userSubCategories: Array, // Data sub kategori yang sudah dimiliki user
});

// State untuk menyimpan data yang dipilih
const selectedCategories = ref([]);
const selectedSubCategories = ref([]);

// Filter kategori unik (nama yang sama hanya diambil satu)
const uniqueCategories = computed(() => {
  const uniqueNames = new Set();
  return props.categories.filter(category => {
    if (!uniqueNames.has(category.name)) {
      uniqueNames.add(category.name);
      return true;
    }
    return false;
  });
});

// Ambil semua subkategori berdasarkan category_id
const getAllSubCategories = (category_id) => {
  return props.subCategories.filter(sub => sub.category_id === category_id);
};

// Cek apakah kategori sudah dimiliki oleh user
const isCategoryDisabled = (category) => {
  return props.userCategories.some(userCat => userCat.name === category.name);
};

// Cek apakah subkategori sudah dimiliki oleh user
const isSubCategoryDisabled = (subCategory) => {
  return props.userSubCategories.some(userSubCat => userSubCat.name === subCategory.name);
};

// Otomatis pilih kategori jika subkategori dipilih
const onSubCategorySelect = (subCategory) => {
  if (selectedSubCategories.value.includes(subCategory.id)) {
    if (!selectedCategories.value.includes(subCategory.category_id)) {
      selectedCategories.value.push(subCategory.category_id);
    }
  } else {
    const hasOtherSelectedSubCategories = props.subCategories.some(
      sub => sub.category_id === subCategory.category_id && selectedSubCategories.value.includes(sub.id)
    );
    if (!hasOtherSelectedSubCategories) {
      selectedCategories.value = selectedCategories.value.filter(id => id !== subCategory.category_id);
    }
  }
};

// Jika category di-uncheck, hapus semua subkategori yang terkait
const onCategorySelect = (category) => {
  if (!selectedCategories.value.includes(category.id)) {
    selectedSubCategories.value = selectedSubCategories.value.filter(
      subId => !getAllSubCategories(category.id).some(sub => sub.id === subId)
    );
  }
};

// Simpan data yang dipilih
const saveSelected = () => {
  router.post(route('categories.save'), {
    categories: selectedCategories.value,
    subCategories: selectedSubCategories.value,
  }, {
    onSuccess: () => {

      selectedCategories.value = [];
      selectedSubCategories.value = [];
    },
  });
};
</script>

<style scoped>
/* Indentasi untuk SubCategory */
.subcategory-indent {
  padding-left: 2rem;
}

/* Efek redup untuk data yang sudah ada */
.disabled-row {
  opacity: 0.5;
}

/* Tampilan checkbox */
input[type="checkbox"] {
  margin-right: 0.5rem;
}

/* Tampilan teks "Sudah Ada" */
.already-exists {
  font-size: 0.875rem;
  color: #ef4444;
  margin-left: 0.5rem;
}

/* Tampilan teks Category */
.category-name {
  font-size: 1.125rem;
  font-weight: bold;
}

/* Tampilan teks SubCategory */
.subcategory-name {
  font-size: 0.875rem;
}
</style>