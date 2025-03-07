<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(): Response
    {
        $user = Auth::user();

        // if ($user->role === 'admin') {
        //     $bookings = $this->bookingService->getAllBookings();
        //     return Inertia::render('Dashboard', [
        //         'bookings' => $bookings,
        //         'role' => 'admin'
        //     ]);
        // }

        return Inertia::render('Dashboard', [
            'availableSlots' => $this->bookingService->getAvailableSlots(date('Y-m-d')),
            'bookings' => $this->bookingService->getUserBookings(),
            'role' => 'user',
        ]);
    }

    public function adminDashboard(): Response
    {
        $bookings = $this->bookingService->getAllBookings();
        return Inertia::render('AdminDashboard', ['bookings' => $bookings]);
    }

    public function bookSlot(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|string',
        ]);

        $result = $this->bookingService->bookSlot($request->date, $request->time);

        if (isset($result['error'])) {
            return Redirect::back()->withErrors(['error' => $result['error']]);
        }

        return Redirect::back()->with('success', 'Slot booked successfully!');
    }
}
