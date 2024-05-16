<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationEmail;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
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

        $otp = $this->generateAndStoreOtp($user->email);

        // Mail::to($request->email)->send(new OtpVerificationEmail());

        return response()->json(['data' => ['message' => 'User registered successfully.', 'data' => $user, 'otp'  => $otp]], 200);
    }

    public function login(Request $request)
    {
    }

    public function generateAndStoreOtp($email)
    {
        $otp = rand(100000, 999999);

        Verification::updateOrCreate(
            ['email' => $email],
            [
                'email' => $email,
                'otp' => $otp,
            ]
        );

        return $otp;
    }
}
