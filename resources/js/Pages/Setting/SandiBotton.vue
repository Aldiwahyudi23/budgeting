<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    hasPassword: Boolean
});

const form = useForm({
    current_password: '',
    new_password: '',
    confirm_new_password: ''
});

const submit = () => {
    if (props.hasPassword) {
        form.put(route('sandi-botton.update'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: () => {
                if (form.errors.current_password) {
                    form.reset('current_password');
                }
            }
        });
    } else {
        form.post(route('sandi-botton.update'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
        });
    }
};

const passwordRequirements = computed(() => [
    { text: 'Minimal 4 karakter', valid: form.new_password.length >= 4 },
    { text: 'Maksimal 20 karakter', valid: form.new_password.length <= 20 },
    { text: 'Konfirmasi sandi cocok', valid: form.new_password === form.confirm_new_password }
]);
</script>

<template>
    <AppLayout title="Kelola Sandi Botton">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelola Sandi Botton
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-md mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <!-- Current Password (only shown if hasPassword) -->
                            <div v-if="hasPassword" class="mb-4">
                                <label for="current_password" class="block text-sm font-medium text-gray-700">
                                    Sandi Saat Ini
                                </label>
                                <input
                                    id="current_password"
                                    v-model="form.current_password"
                                    type="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    autocomplete="current-password"
                                />
                                <p v-if="form.errors.current_password" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.current_password }}
                                </p>
                            </div>

                            <!-- New Password -->
                            <div class="mb-4">
                                <label for="new_password" class="block text-sm font-medium text-gray-700">
                                    {{ hasPassword ? 'Sandi Baru' : 'Buat Sandi Botton' }}
                                </label>
                                <input
                                    id="new_password"
                                    v-model="form.new_password"
                                    type="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    autocomplete="new-password"
                                />
                                <p v-if="form.errors.new_password" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.new_password }}
                                </p>
                            </div>

                            <!-- Confirm New Password -->
                            <div class="mb-4">
                                <label for="confirm_new_password" class="block text-sm font-medium text-gray-700">
                                    Konfirmasi Sandi Baru
                                </label>
                                <input
                                    id="confirm_new_password"
                                    v-model="form.confirm_new_password"
                                    type="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    autocomplete="new-password"
                                />
                                <p v-if="form.errors.confirm_new_password" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.confirm_new_password }}
                                </p>
                            </div>

                            <!-- Password Requirements -->
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-700">Persyaratan Sandi:</p>
                                <ul class="text-sm text-gray-600">
                                    <li v-for="(req, index) in passwordRequirements" :key="index" 
                                        :class="req.valid ? 'text-green-600' : 'text-gray-500'">
                                        {{ req.valid ? '✓' : '•' }} {{ req.text }}
                                    </li>
                                </ul>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center justify-end">
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition"
                                    :disabled="form.processing || !form.new_password || (hasPassword && !form.current_password) || form.new_password !== form.confirm_new_password"
                                >
                                    {{ form.processing ? 'Memproses...' : hasPassword ? 'Perbarui Sandi' : 'Simpan Sandi' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>