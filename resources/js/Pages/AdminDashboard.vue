<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const pageProps = usePage().props;
const bookings = ref(pageProps.bookings ?? []);
</script>

<template>
    <Head title="Admin Dashboard" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold">All Bookings</h3>
                <table class="min-w-full table-auto mt-4">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">User name</th>
                            <th class="border px-4 py-2">Email</th>
                            <th class="border px-4 py-2">Phone</th>
                            <th class="border px-4 py-2">Appointment Date</th>
                            <th class="border px-4 py-2">Appointment Time</th>
                            <th class="border px-4 py-2">Date Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="booking in bookings" :key="booking.id" class="text-center">
                            <td class="border px-4 py-2">{{ booking.user?.name }}</td>
                            <td class="border px-4 py-2">{{ booking.user?.email }}</td>
                            <td class="border px-4 py-2">{{ booking.user?.phone }}</td>
                            <td class="border px-4 py-2">{{ booking.date }}</td>
                            <td class="border px-4 py-2">{{ booking.time }}</td>
                            <td class="border px-4 py-2">{{ new Date(booking.created_at).toLocaleString() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
