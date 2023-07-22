<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Travel;
use App\Http\Resources\BookingResource;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema(
 *     schema="Booking",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="travel_id", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 */

class BookingController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/bookings",
     *     summary="Book a travel",
     *     tags={"Booking"},
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="travel_id", type="integer", example="1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Booking successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="booking", ref="#/components/schemas/Booking"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden. Only customers can book travels",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found. Travel with provided ID not found",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     * )
     */
    public function bookTravel(Request $request)
    {
        try {
            $user = Auth::user();
            $validatedData = $request->validate([
                'travel_id' => 'required|exists:travel,id',
            ]);
    
            // Check if the user is a customer (role 0)
            if ($user->role !== 0) {
                return response()->json(['message' => 'Only customers can book travels'], Response::HTTP_FORBIDDEN);
            }
    
            // Find the travel based on the travel_id
            $travel = Travel::findOrFail($validatedData['travel_id']);
    
            // Additional checks for travel availability, capacity, etc.
            // Perform the necessary validations and checks before creating the booking.
    
            $booking = Booking::create([
                'user_id' => $user->id,
                'travel_id' => $travel->id,
            ]);
    
            return response()->json(['message' => 'Booking successful', 'booking' => new BookingResource($booking)], Response::HTTP_CREATED);
    
        } catch (ValidationException $e) {
            // Return validation error response
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], Response::HTTP_BAD_REQUEST);
    
        } catch (ModelNotFoundException $e) {
            // Return not found error response
            return response()->json(['message' => 'Travel not found'], Response::HTTP_NOT_FOUND);
    
        } catch (\Exception $e) {
            // Return generic error response
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/bookings",
     *     summary="Get bookings for the authenticated user",
     *     tags={"Booking"},
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="bookings", type="array", @OA\Items(ref="#/components/schemas/Booking"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     * )
     */
    public function getUserBookings()
    {
        $user = Auth::user();

        $bookings = $user->bookings()->with('travel')->get();

        return BookingResource::collection($bookings); 
    }

        /**
     * @OA\Delete(
     *     path="/api/bookings/{id}",
     *     summary="Cancel a booking",
     *     tags={"Booking"},
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the booking to cancel",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Booking cancelled successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden. Only the user who made the booking can cancel it",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found. Booking with provided ID not found",
     *     ),
     * )
     */
    public function cancelBooking($bookingId)
    {
        $user = Auth::user();

        $booking = Booking::where('user_id', $user->id)->findOrFail($bookingId);

        if (!$booking) 
        { 
            return response()->json(['message' => 'Booking is already cancelled'], 404);
        } elseif ($booking->status === 'cancelled') {
            return response()->json(['message' => 'Booking is already cancelled'], 400);
        } elseif ($booking->status === 'paid') {
            return response()->json(['message' => 'Cannot cancel a paid booking'], 422);
        } else {
            $booking->status = 'cancelled';
            $booking->save();
        }

        return response()->json(['message' => 'Booking cancelled successfully'], 200);
    }
}
