<template>
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Mutasi Rekening Bank: {{ accountBank.name }}</h1>

        <!-- Tabel Mutasi -->
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full border bg-white rounded-lg shadow-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Tanggal</th>
                        <th class="px-4 py-2 text-left">Aktivitas</th>
                        <th class="px-4 py-2 text-left">Perubahan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(activity, index) in activities" :key="activity.id" class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ index + 1 }}</td>
                        <td class="px-4 py-2">{{ activity.created_at }}</td>
                        <td class="px-4 py-2">{{ activity.description }}</td>
                        <td class="px-4 py-2">
                            <pre>{{ JSON.stringify(activity.properties, null, 2) }}</pre>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    accountBank: Object,
    activities: Array,
});
</script>