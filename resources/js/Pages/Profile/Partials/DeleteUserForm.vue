<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
    form.delete(route('current-user.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <ActionSection>
        <template #title>
            Hapus Akun
        </template>

        <template #description>
            Hapus akun Anda secara permanen.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Setelah akun Anda dihapus, semua data dan resource yang terkait akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi yang ingin Anda simpan.
            </div>

            <div class="mt-5">
                <DangerButton @click="confirmUserDeletion">
                    Hapus Akun
                </DangerButton>
            </div>

            <!-- Modal Konfirmasi Hapus Akun -->
            <DialogModal :show="confirmingUserDeletion" @close="closeModal">
                <template #title>
                    Hapus Akun
                </template>

                <template #content>
                    Apakah Anda yakin ingin menghapus akun Anda? Setelah akun dihapus, semua data dan resource akan dihapus secara permanen. Harap masukkan password Anda untuk mengonfirmasi penghapusan akun.

                    <div class="mt-4">
                        <TextInput
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-full md:w-3/4"
                            placeholder="Password"
                            autocomplete="current-password"
                            @keyup.enter="deleteUser"
                        />

                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <SecondaryButton @click="closeModal">
                        Batal
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Hapus Akun
                    </DangerButton>
                </template>
            </DialogModal>
        </template>
    </ActionSection>
</template>

<style scoped>
/* Animasi untuk modal */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* Responsif untuk tombol dan input */
@media (max-width: 640px) {
   

    .ms-3 {
        margin-left: 0.5rem;
    }
}
</style>