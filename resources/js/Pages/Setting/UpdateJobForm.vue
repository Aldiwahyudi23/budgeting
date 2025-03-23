<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SectionTitle from '@/Components/SectionTitle.vue';

const props = defineProps({
    job: Object, // Data pekerjaan (jika ada)
    userId: Number, // ID pengguna yang login
});

// Inertia form untuk membuat atau memperbarui job
const form = useForm({
    company_name: props.job?.company_name || '',
    job_title: props.job?.job_title || '',
    job_description: props.job?.job_description || '',
    salary: props.job?.salary || '',
    bpjs: props.job?.bpjs || false,
    bpjs_company_percentage: props.job?.bpjs_company_percentage || '',
    bpjs_employee_percentage: props.job?.bpjs_employee_percentage || '',
    benefits: props.job?.benefits || '',
});

// Cek apakah user sudah memiliki job
const jobExists = computed(() => !!props.job);

// Fungsi untuk menyimpan atau memperbarui job
const saveJob = () => {
    if (jobExists.value) {
        // Jika job sudah ada, lakukan update
        form.put(route('job.update', props.job.id), {
            preserveScroll: true,
            onSuccess: () => alert('Job updated successfully!'),
        });
    } else {
        // Jika job belum ada, lakukan create
        form.post(route('job.store'), {
            preserveScroll: true,
            onSuccess: () => alert('Job added successfully!'),
        });
    }
};
</script>

<template>
    <div class="mt-4 sm:mt-0 p-4 sm:p-6 bg-white shadow rounded-lg max-w-3xl mx-auto">
        <form @submit.prevent="saveJob" class="mt-4 space-y-6">
            <!-- Company Name -->
            <div>
                <InputLabel for="company_name" value="Company Name" class="block text-sm font-medium text-gray-700" />
                <TextInput id="company_name" v-model="form.company_name" required autofocus
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <InputError :message="form.errors.company_name" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Job Title -->
            <div>
                <InputLabel for="job_title" value="Job Title" class="block text-sm font-medium text-gray-700" />
                <TextInput id="job_title" v-model="form.job_title" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <InputError :message="form.errors.job_title" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Job Description -->
            <div>
                <InputLabel for="job_description" value="Job Description" class="block text-sm font-medium text-gray-700" />
                <textarea id="job_description" v-model="form.job_description"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                <InputError :message="form.errors.job_description" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Salary -->
            <div>
                <InputLabel for="salary" value="Salary" class="block text-sm font-medium text-gray-700" />
                <TextInput id="salary" v-model="form.salary" type="number"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <InputError :message="form.errors.salary" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- BPJS -->
            <div class="flex items-center">
                <input id="bpjs" type="checkbox" v-model="form.bpjs"
                    class="h-4 w-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500" />
                <label for="bpjs" class="ml-2 text-sm text-gray-700">Has BPJS?</label>
            </div>

            <!-- BPJS Percentages -->
            <div v-if="form.bpjs" class="space-y-4">
                <div>
                    <InputLabel for="bpjs_company_percentage" value="BPJS - Company Contribution (%)"
                        class="block text-sm font-medium text-gray-700" />
                    <TextInput id="bpjs_company_percentage" v-model="form.bpjs_company_percentage" type="number" step="0.01"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <InputError :message="form.errors.bpjs_company_percentage" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <InputLabel for="bpjs_employee_percentage" value="BPJS - Employee Contribution (%)"
                        class="block text-sm font-medium text-gray-700" />
                    <TextInput id="bpjs_employee_percentage" v-model="form.bpjs_employee_percentage" type="number" step="0.01"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <InputError :message="form.errors.bpjs_employee_percentage" class="mt-2 text-sm text-red-600" />
                </div>
            </div>

            <!-- Benefits -->
            <div>
                <InputLabel for="benefits" value="Benefits" class="block text-sm font-medium text-gray-700" />
                <textarea id="benefits" v-model="form.benefits"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                <InputError :message="form.errors.benefits" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <PrimaryButton :disabled="jobExists && form.isDirty"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>