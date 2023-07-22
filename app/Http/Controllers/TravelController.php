<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Travel;
use App\Http\Resources\TravelResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Travel",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="price", type="number", format="float"),
 *     @OA\Property(property="origin", type="string"),
 *     @OA\Property(property="destination", type="string"),
 *     @OA\Property(property="departure_time", type="string", format="date-time", example="2023-07-21 12:00:00"),
 * )
 * @OA\Schema(
 *     schema="AddTravelRequest",
 *     type="object",
 *     required={"price", "origin", "destination", "departure_time"},
 *     @OA\Property(property="price", type="number", format="float"),
 *     @OA\Property(property="origin", type="string"),
 *     @OA\Property(property="destination", type="string"),
 *     @OA\Property(property="is_available", type="boolean"),
 *     @OA\Property(property="departure_time", type="string", format="date-time", example="2023-07-21 12:00:00"),
 * )
 */

class TravelController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/travel",
     *     summary="Get a list of available travels",
     *     tags={"Travel"},
     *     @OA\Parameter(
     *         name="price",
     *         in="query",
     *         description="Filter by price",
     *         required=false,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter(
     *         name="origin",
     *         in="query",
     *         description="Filter by origin",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="destination",
     *         in="query",
     *         description="Filter by destination",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="departure_time",
     *         in="query",
     *         description="Filter by departure time",
     *         required=false,
     *         @OA\Schema(type="string", format="date-time")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Travel")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     * )
     */
    public function index(Request $request)
    {
        $travels = Travel::query();

        if ($request->has('price')) {
            $travels->where('price', '<=', $request->input('price'));
        }

        if ($request->has('origin')) {
            $travels->where('origin', 'like', '%' . $request->input('origin') . '%');
        }

        if ($request->has('destination')) {
            $travels->where('destination', 'like', '%' . $request->input('destination') . '%');
        }

        if ($request->has('departure_time')) {
            $travels->where('departure_time', '>=', $request->input('departure_time'));
        }

        return TravelResource::collection($travels->get());
    }

    /**
     * @OA\Get(
     *     path="/api/travel/{id}",
     *     summary="Get details of a specific travel",
     *     tags={"Travel"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the travel",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Travel")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     * )
     */
    public function show($id)
    {
        $travel = Travel::find($id);
    
        if (!$travel) {
            return response()->json(['message' => 'Travel package not found'], 404);
        }
    
        return new TravelResource($travel);
    }

    /**
     * @OA\Post(
     *     path="/api/travel",
     *     summary="Add a new travel",
     *     tags={"Travel"},
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AddTravelRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Travel added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
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
    public function addTravel(Request $request)
    {
        $validatedData = $request->validate([
            'price' => 'required|numeric|min:0',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'departure_time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $userId = Auth::id();

        Travel::create([
            'price' => $validatedData['price'],
            'origin' => $validatedData['origin'],
            'destination' => $validatedData['destination'],
            'departure_time' => $validatedData['departure_time'],
            'user_id' => $userId,
        ]);

        return response()->json(['message' => 'Travel added successfully'], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/travel/{id}",
     *     summary="Update a travel",
     *     tags={"Travel"},
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the travel to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AddTravelRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Travel updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
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
    public function updateTravel(Request $request, $id)
    {
        $validatedData = $request->validate([
            'price' => 'required|numeric|min:0',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'departure_time' => 'required|date_format:Y-m-d H:i:s',
            'is_available' => 'required|boolean'
        ]);

        $travel = Travel::findOrFail($id);

        if ($travel->user_id !== Auth::id()) {
            return response()->json(['message' => 'You are not authorized to update this travel'], 403);
        }

        $travel->update([
            'price' => $validatedData['price'],
            'origin' => $validatedData['origin'],
            'destination' => $validatedData['destination'],
            'departure_time' => $validatedData['departure_time'],
            'is_available' => $validatedData['is_available'],
        ]);

        return response()->json(['message' => 'Travel updated successfully'], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/travel/{id}",
     *     summary="Delete a travel",
     *     tags={"Travel"},
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the travel to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Travel deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden. You are not authorized to delete this travel",
     *     ),
     * )
     */
    public function deleteTravel($id)
    {
        $travel = Travel::findOrFail($id);

        if ($travel->user_id !== Auth::id()) {
            return response()->json(['message' => 'You are not authorized to delete this travel'], 403);
        }

        $travel->delete();

        return response()->json(['message' => 'Travel deleted successfully'], 200);
    }

}
