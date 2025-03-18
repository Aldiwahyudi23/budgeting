<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
      <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-center text-2xl font-semibold mb-6">
          {{ otpSent ? 'Masukkan Kode OTP' : 'Login dengan Nomor HP' }}
        </h2>

        <!-- Form Nomor HP -->
        <form v-if="!otpSent" @submit.prevent="sendOtp" class="space-y-4">
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor HP</label>
            <input
              id="phone"
              v-model="form.phone"
              type="text"
              required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              placeholder="08xxxxxxxxxx"
            />
            <InputError :message="form.errors.phone" />
          </div>

          <div>
            <button
              type="submit"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Kirim OTP
            </button>
          </div>
        </form>

        <!-- Form OTP -->
        <form v-else @submit.prevent="verifyOtp" class="space-y-4">
          <div class="flex justify-center space-x-2">
            <input
              v-for="(digit, index) in otpDigits"
              :key="index"
              v-model="otpDigits[index]"
              type="text"
              maxlength="1"
              :id="`otp-${index}`"
              class="w-12 h-12 text-center border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm md:w-16 md:h-16 lg:w-20 lg:h-20"
              @input="handleOtpInput(index)"
              @keydown.delete="handleOtpDelete(index)"
            />
          </div>

          <!-- Pesan Error OTP -->
          <InputError class="text-center" :message="form.errors.otp" />

          <!-- Countdown dan Resend OTP -->
          <div v-if="countdown > 0" class="text-center text-sm text-gray-600">
            Kode OTP berlaku dalam {{ countdown }} detik.
          </div>
          <div v-else class="text-center text-sm text-gray-600">
            Kode OTP sudah tidak berlaku.
            <button
              type="button"
              @click="resendOtp"
              class="text-indigo-600 hover:text-indigo-500"
            >
              Kirim Ulang OTP
            </button>
          </div>
        </form>

        <!-- Tautan ke Login Email -->
        <div class="text-center mt-4">
          <a
            href="/login"
            class="text-sm text-indigo-600 hover:text-indigo-500"
          >
            Masuk Menggunakan Email
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue'; // Import komponen InputError

const form = useForm({
  phone: '',
  otp: '',
});

const otpSent = ref(false);
const otpDigits = ref(['', '', '', '']);
const countdown = ref(90); // 2 menit

// Fungsi untuk menangani input OTP
const handleOtpInput = (index) => {
  if (otpDigits.value[index].length === 1 && index < 3) {
    // Pindah ke input berikutnya
    document.getElementById(`otp-${index + 1}`).focus();
  }
  if (otpDigits.value.every((digit) => digit.length === 1)) {
    // Jika semua digit terisi, gabungkan dan kirim OTP
    form.otp = otpDigits.value.join('');
    verifyOtp();
  }
};

// Fungsi untuk menangani tombol delete
const handleOtpDelete = (index) => {
  if (otpDigits.value[index].length === 0 && index > 0) {
    // Pindah ke input sebelumnya
    document.getElementById(`otp-${index - 1}`).focus();
  }
};

// Kirim OTP
const sendOtp = () => {
  form.post('/check-phone', {
    onSuccess: () => {
      otpSent.value = true;
      startCountdown();
    },
  });
};

// Verifikasi OTP
const verifyOtp = () => {
  form.post('/verify-otp', {
    onSuccess: () => {
      router.visit('/dashboard');
    },
    onError: () => {
      // Reset OTP digits jika terjadi error
      otpDigits.value = ['', '', '', ''];
      document.getElementById('otp-0').focus(); // Fokus kembali ke input pertama
    },
  });
};

// Kirim ulang OTP
const resendOtp = () => {
  form.post('/resend-otp', {
    onSuccess: () => {
      countdown.value = 90;
      startCountdown();
    },
  });
};

// Mulai hitung mundur
const startCountdown = () => {
  const interval = setInterval(() => {
    if (countdown.value > 0) {
      countdown.value--;
    } else {
      clearInterval(interval);
    }
  }, 1000);
};

onMounted(() => {
  if (otpSent.value) {
    startCountdown();
  }
});
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
  .w-12 {
    width: 3rem;
    height: 3rem;
  }
}

@media (min-width: 641px) and (max-width: 1024px) {
  .md\:w-16 {
    width: 4rem;
    height: 4rem;
  }
}

@media (min-width: 1025px) {
  .lg\:w-20 {
    width: 5rem;
    height: 5rem;
  }
}
</style>