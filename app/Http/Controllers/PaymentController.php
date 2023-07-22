<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Booking;

class PaymentController extends Controller
{
        /**
     * @OA\Post(
     *     path="/api/payment/{id}",
     *     summary="Process payment for a travel booking",
     *     tags={"Payment"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the travel to book",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="stripe_token", type="string", example="tok_visa")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error or payment failure",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string"),
     *         )
     *     ),
     * )
     */
    public function processPayment(Request $request, $bookingId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $booking = Booking::findOrFail($bookingId);
        $travel = $booking->travel; 

        $amountInIDR = $travel->price * 100; // Stripe requires the amount in the smallest currency unit (cents for USD, etc.)

        $source = $request->input('stripe_token');

        try {
            $charge = Charge::create([
                'amount' => $amountInIDR,
                'currency' => 'idr',
                'source' => $source,
            ]);

            $booking->status = 'paid'; 
            $booking->save(); 

            // Send confirmation email to the user
            // Mail::to($booking->user->email)->send(new BookingConfirmation($booking));

            return response()->json(['message' => 'Payment successful']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Payment failed', 'error' => $e->getMessage()]);
        }
    }
}