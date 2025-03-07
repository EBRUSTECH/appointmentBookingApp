<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Exception;

class BookingService
{
    public function getAvailableSlots($date)
    {
        try {
            $startTime = strtotime('08:00');
            $endTime = strtotime('17:00');
            $interval = 30 * 60; // 30-minute slots

            $bookedSlots = Booking::where('date', $date)->pluck('time')->toArray();
            $availableSlots = [];

            for ($time = $startTime; $time < $endTime; $time += $interval) {
                $slot = date('H:i', $time);
                if (!in_array($slot, $bookedSlots)) {
                    $availableSlots[] = $slot;
                }
            }
            return $availableSlots;
        } catch (Exception $e) {
            return ['error' => 'Failed to fetch slots: ' . $e->getMessage()];
        }
    }

    public function bookSlot($date, $time)
    {
        try {
            $userId = Auth::id();
            $bookingDate = \Carbon\Carbon::parse($date);

            // Prevent weekend bookings
            if ($bookingDate->isWeekend()) {
                return ['error' => 'Bookings are only allowed from Monday to Friday.'];
            }

            // Prevent duplicate bookings for the same time slot
            if (Booking::where('date', $date)->where('time', $time)->exists()) {
                return ['error' => 'Time slot is already booked.'];
            }

            // Prevent users from booking more than once per day
            if (Booking::where('user_id', $userId)->where('date', $date)->exists()) {
                return ['error' => 'You can only book one slot per day.'];
            }

            // Create the booking
            $booking = Booking::create([
                'user_id' => $userId,
                'date' => $date,
                'time' => $time
            ]);

            return ['success' => 'Booking successful!', 'booking' => $booking];
        } catch (\Exception $e) {
            return ['error' => 'Booking failed: ' . $e->getMessage()];
        }
    }

    public function getAllBookings()
    {
        try {
            return Booking::with('user')->get();
        } catch (Exception $e) {
            return ['error' => 'Failed to fetch bookings: ' . $e->getMessage()];
        }
    }

    public function getUserBookings()
    {
        return Booking::where('user_id', Auth::id())->latest()->take(10)->get();
    }
}
