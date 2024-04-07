<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        info($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required | string | min:2',
            'email' => 'required | email | unique:users',
            'password' => 'required | string | min:6'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Mail::to($request->email)->send(new OtpVerificationEmail());

        return response()->json(['data' => ['message' => 'User registered successfully.', 'data' => $user]], 200);
    }
}
