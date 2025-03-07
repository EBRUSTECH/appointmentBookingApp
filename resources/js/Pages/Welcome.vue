<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-center text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Trading Soft Appointment Booking
            </h2>

            <div class="mt-6 flex flex-col items-center">
                <Link
                    v-if="canLogin"
                    :href="route('login')"
                    class="w-full text-center py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300"
                >
                    Log in to book
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="w-full text-center mt-4 py-2 px-4 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition duration-300"
                >
                    Register to book
                </Link>
            </div>
        </div>
    </div>
</template>
