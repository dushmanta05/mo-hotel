<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'dob' => 'required|date|date_format:Y-m-d',
            'gender' => 'required|in:male,female,other',
            'hotel_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->first_name . " " . $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'number' => $request->number,
        ]);

        $staff = Staff::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'hotel_id' => $request->input('hotel_id'),
            'user_id' => $user->id,
        ]);

        return response()->json(['data' => ['message' => 'User and staff registered successfully.', 'user' => $user, 'staff' => $staff]], 200);
    }

    public function get($id, Request $request)
    {
        $staff = Staff::find($id);

        if (!$staff) {
            return response()->json(['error' => 'Staffs not found'], 404);
        }

        return response()->json(['staff' => $staff], 200);
    }

    public function delete($id, Request $request)
    {
        $staff = Staff::find($id);

        if (!$staff) {
            return response()->json(['error' => 'Staff not found'], 404);
        }

        $user = $staff->user;
        $staff->delete();
        $user->delete();

        return response()->json(['message' => 'Staff and user deleted successfully'], 200);
    }
}
