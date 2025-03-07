<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Swal from 'sweetalert2';

const pageProps = usePage().props;
const bookings = ref(pageProps.bookings ?? []);
const availableSlots = ref(pageProps.availableSlots ?? []);
const form = useForm({ date: '', time: '' });

const isWeekend = computed(() => {
    if (!form.date) return false;
    const day = new Date(form.date).getDay();
    return day === 6 || day === 0;
});

const hasBookedToday = computed(() => {
    return bookings.value.some(booking => booking.date === form.date);
});

const bookSlot = () => {
    if (isWeekend.value) return;
    if (hasBookedToday.value) {
        Swal.fire({ title: "Booking Error!", text: "You have already booked a slot today.", icon: "error" });
        return;
    }

    form.post(route('bookSlot'), {
        onSuccess: () => {
            Swal.fire({ title: "Success!", text: "Your booking was successful.", icon: "success" });
            form.reset('time');
        }
    });
};
</script>

<template>
    <Head title="User Booking" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold">Book a Slot</h3>
                <input
                    type="date"
                    v-model="form.date"
                    class="border rounded p-2 my-2"
                    placeholder="Select Date"
                />
                <p v-if="isWeekend" class="text-red-500 text-sm">Booking is only allowed from Monday to Friday.</p>
                <p v-if="hasBookedToday" class="text-red-500 text-sm">You have already booked a slot today.</p>
                <select v-model="form.time" class="border rounded p-2 my-2 mx-4" :disabled="isWeekend || hasBookedToday">
                    <option value="" disabled selected>Select Time</option>
                    <option v-for="slot in availableSlots" :key="slot" :value="slot">{{ slot }}</option>
                </select>
                <button @click="bookSlot" class="bg-blue-500 text-white px-4 py-2 rounded mt-2"
                    :disabled="form.processing || isWeekend || hasBookedToday">
                    Book Slot
                </button>

                <h3 class="text-lg font-semibold mt-6">My Bookings</h3>
                <table class="min-w-full table-auto mt-4">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Date</th>
                            <th class="border px-4 py-2">Time</th>
                            <th class="border px-4 py-2">Date Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="booking in bookings" :key="booking.id" class="text-center">
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
