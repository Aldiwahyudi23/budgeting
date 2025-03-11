<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);
const showProfileDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};

const toggleProfileDropdown = () => {
    showProfileDropdown.value = !showProfileDropdown.value;
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <!-- Header -->
            <nav class="bg-sky-500 border-b border-gray-100 fixed w-full top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-12">
                        <!-- Logo -->
                          <!-- Logo -->
                            <div class="shrink-0 flex items-center text-2xl font-bold">
                                <span class="text-white">ATUR Yukkk</span>
                            </div>

                        <!-- Menu Desktop (Tampil di atas pada laptop) -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <div class="hidden space-x-8 sm:-my-px sm:flex">
                                <NavLink :href="route('home')" :active="route().current('home')">
                                    Dashboard
                                </NavLink>
                                <NavLink :href="route('expense.index')" :active="route().current('expense.index')">
                                    Expenses
                                </NavLink>
                                <NavLink :href="route('income.index')" :active="route().current('income.index')">
                                    Income
                                </NavLink>
                                <NavLink :href="route('aset')" :active="route().current('aset')">
                                    Aset
                                </NavLink>
                                <NavLink :href="route('laporan')" :active="route().current('laporan')">
                                    Laporan
                                </NavLink>
                            </div>

                            <!-- Profil dan Logout (Desktop) -->
                            <div class="ms-3 relative ">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition ">
                                            <img class="size-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Profile
                                        </DropdownLink>

                                         <DropdownLink :href="route('setupData')">
                                            Setup Data
                                        </DropdownLink>

                                         <DropdownLink :href="route('settings.index')">
                                            Setting
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-200" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger Menu (Mobile) -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="size-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Profile
                                        </DropdownLink>

                                        <DropdownLink :href="route('setupData')">
                                            Setup Data
                                        </DropdownLink>

                                        <DropdownLink :href="route('settings.index')">
                                            Setting
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-200" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

         <nav class="md:hidden fixed bottom-0 w-full bg-sky-500 shadow-lg z-50 rounded-t-2xl">
            <div class="flex justify-around items-center py-3">
                <!-- Home -->
                <Link
                :href="route('home')"
                class="flex flex-col items-center text-white hover:text-blue-200 transition-colors duration-300"
                :class="{ 'text-blue-200 border-b-2 border-blue-200': $page.url === '/home' }"
                >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                    ></path>
                </svg>
                <span class="text-xs mt-1">Home</span>
                </Link>

                <!-- Transaksi (Modal) -->
                <button
                @click="toggleModal"
                class="flex flex-col items-center text-white hover:text-blue-200 transition-colors duration-300 focus:outline-none"
                >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
                </svg>
                <span class="text-xs mt-1">Transaksi</span>
                </button>

                <!-- Modal untuk Pengeluaran dan Pemasukan -->
                <div
                v-if="isModalOpen"
                class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
                >
                <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">
                    Pilih Jenis Transaksi
                    </h3>
                    <div class="flex gap-6 justify-center">
                    <!-- Card Pengeluaran -->
                    <Link
                        :href="route('expense.index')"
                        class="bg-red-50 p-6 rounded-lg shadow-md text-center hover:bg-red-100 transition-colors duration-300 flex flex-col items-center"
                    >
                        <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-10 w-10 text-red-600 mb-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                        </svg>
                        <span class="text-lg font-semibold text-red-600">Pengeluaran</span>
                    </Link>

                    <!-- Card Pemasukan -->
                    <Link
                        :href="route('income.index')"
                        class="bg-green-50 p-6 rounded-lg shadow-md text-center hover:bg-green-100 transition-colors duration-300 flex flex-col items-center"
                    >
                        <svg
                        class="w-10 h-10 text-green-500 mb-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        ></path>
                        </svg>
                        <span class="text-lg font-semibold text-green-600">Pemasukan</span>
                    </Link>
                    </div>
                    <!-- Tombol Batal -->
                    <div class="mt-6 text-center">
                    <button
                        @click="closeModal"
                        class="text-gray-600 hover:text-gray-800 font-medium transition-colors duration-300"
                    >
                        Batal
                    </button>
                    </div>
                </div>
                </div>

                <!-- Keuangan -->
                <Link
                :href="route('aset')"
                class="flex flex-col items-center text-white hover:text-blue-200 transition-colors duration-300"
                :class="{ 'text-blue-200 border-b-2 border-blue-200': $page.url === '/aset' }"
                >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    ></path>
                </svg>
                <span class="text-xs mt-1">Aset</span>
                </Link>

                <!-- Laporan -->
                <Link
                :href="route('laporan')"
                class="flex flex-col items-center text-white hover:text-blue-200 transition-colors duration-300"
                :class="{ 'text-blue-200 border-b-2 border-blue-200': $page.url === '/laporan' }"
                >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                    ></path>
                    <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                    ></path>
                </svg>
                <span class="text-xs mt-1">Laporan</span>
                </Link>
            </div>
        </nav>

            <!-- Page Content -->
            <main class="pt-10 pb-16 md:pb-0">
                <slot />
            </main>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
            isModalOpen: false
        };
    },
    methods: {
        toggleModal() {
            this.isModalOpen = !this.isModalOpen;
        },
        closeModal() {
            this.isModalOpen = false;
        }
    }
};
</script>

<style scoped>
/* Animasi Fade In */
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s;
}
.modal-enter,
.modal-leave-to {
    opacity: 0;
}

.modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
