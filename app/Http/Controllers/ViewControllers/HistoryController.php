<?php

namespace App\Http\Controllers\ViewControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

class HistoryController extends Controller
{
    public function index()
    {
        $bookingController = new BookingController();

        $bookings = $bookingController->getUserBookings();

        return view('pages.booking', compact('bookings'));
    }

    public function cancelBooking($bookingId)
    {
        $bookingController = new BookingController();

        $bookingController->cancelBooking($bookingId);

        $bookings = $bookingController->getUserBookings();

        return view('pages.booking', compact('bookings'));
    }

    public function payBooking(Request $request, $bookingId)
    {
        $paymentController = new PaymentController();
        $bookingController = new BookingController();
    
        $paymentResponse = $paymentController->processPayment($request, $bookingId);

        $bookings = $bookingController->getUserBookings();

        return view('pages.booking', compact('bookings'));
    }
}
