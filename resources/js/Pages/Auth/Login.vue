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
            <div class="relative mt-1">
              <TextInput
                id="password"
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                class="block w-full pr-10"
                required
                autocomplete="current-password"
              />
              <button
                type="button"
                class="absolute inset-y-0 right-0 flex items-center pr-3"
                @click="showPassword = !showPassword"
              >
                <svg
                  v-if="showPassword"
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 text-gray-500"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                  />
                </svg>
                <svg
                  v-else
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 text-gray-500"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                  />
                </svg>
              </button>
            </div>
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
import { ref } from 'vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const showPassword = ref(false);

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