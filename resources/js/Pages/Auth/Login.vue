<template>
  <Head title="Log in" />

  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
      <div class="bg-white shadow-lg rounded-lg p-6">
        <!-- Logo atau Judul -->
        <div class="text-center mb-6">
          <div class="text-4xl font-bold text-indigo-600">
            ATUR Yukkk
          </div>
        </div>

        <!-- Pesan Status -->
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
          {{ status }}
        </div>

        <!-- Form Login -->
        <form @submit.prevent="submit" class="space-y-4">
          <!-- Input Email -->
          <div>
            <InputLabel for="email" value="Email" />
            <TextInput
              id="email"
              v-model="form.email"
              type="email"
              class="mt-1 block w-full"
              required
              autofocus
              autocomplete="username"
            />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <!-- Input Password -->
          <div>
            <InputLabel for="password" value="Kata Sandi" />
            <TextInput
              id="password"
              v-model="form.password"
              type="password"
              class="mt-1 block w-full"
              required
              autocomplete="current-password"
            />
            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <!-- Checkbox Remember Me -->
          <div class="block mt-4">
            <label class="flex items-center">
              <Checkbox v-model:checked="form.remember" name="remember" />
              <span class="ms-2 text-sm text-gray-600">Tetep Abus Tanpa Login</span>
            </label>
          </div>

          <!-- Tombol dan Tautan -->
          <div class="flex items-center justify-between mt-4">
            <Link
              v-if="canResetPassword"
              :href="route('password.request')"
              class="underline text-sm text-indigo-600 hover:text-indigo-500"
            >
              Poho Sandi Maneh?
            </Link>

            <PrimaryButton
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Cusss ATUR
            </PrimaryButton>
          </div>
        </form>

        <!-- Tautan ke Login OTP -->
        <div class="text-center mt-4">
          <Link
            :href="route('login-otp')"
            class="text-sm text-indigo-600 hover:text-indigo-500"
          >
            Masuk Menggunakan Nomor HP
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<style scoped>
/* Responsive Design */
@media (max-width: 640px) {
  .w-full {
    width: 100%;
  }
  .max-w-md {
    max-width: 90%;
  }
}
</style>