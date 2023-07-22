<?php

namespace App\Http\Controllers\ViewControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\BookingController;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $travelController = new TravelController();

        $travels = $travelController->index($request);

        return view('pages.dashboard', compact('travels'));
    }

    public function bookTravel($id)
    {
        $bookingController = new BookingController();
    
        $bookingResponse = $bookingController->bookTravel(new Request(['travel_id' => $id]));
    
        return redirect()->route('bookings');
    }
}
