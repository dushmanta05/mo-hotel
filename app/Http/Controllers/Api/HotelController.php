<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'location' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }


        $hotel = Hotel::create([
            'name' => $request->name,
            'location' => $request->location
        ]);

        return response()->json(['message' => 'Hotel created successfully', 'data' => $hotel], 201);
    }

    public function get($id, Request $request)
    {
        $hotel = Hotel::with('rooms')->find($id);

        if (!$hotel) {
            return response()->json(['error' => 'Hotel not found'], 404);
        }

        return response()->json(['data' => $hotel], 200);
    }
}
