<template>
    <Teleport to="body">
        <!-- Latar belakang gelap -->
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <!-- Konten Modal -->
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md max-h-[80vh] overflow-y-auto">
                <!-- Header Modal -->
                <div class="flex justify-between items-center border-b pb-2">
                    <h2 class="text-lg font-semibold">{{ title }}</h2>
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>

                <!-- Konten Utama Modal -->
                <div class="mt-4">
                    <slot name="content"></slot>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
defineProps({
    show: Boolean,
    title: String,
});

const emit = defineEmits(['close']);

const closeModal = () => {
    emit('close');
};
</script>