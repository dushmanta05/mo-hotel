<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationEmail;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $otp = $this->generateAndStoreOtp($user->email);

        // Mail::to($request->email)->send(new OtpVerificationEmail());

        return response()->json(['data' => ['message' => 'User registered successfully.', 'data' => $user, 'otp'  => $otp]], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $otp = $this->generateAndStoreOtp($request->email);

        return response()->json(['message' => 'OTP generated successfully.', 'otp' => $otp], 200);
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

    public function verification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => "required|string|email",
            'otp' => 'required|string|size:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $otpData = Verification::where('email', $request->email)->first();

        if (!$otpData || $otpData->otp !== $request->otp) {
            return response()->json(['error' => 'Invalid OTP'], 400);
        }

        $currentTime = now();
        $otpUpdatedAt = $otpData->updated_at;

        if ($otpUpdatedAt->addMinutes(10)->greaterThanOrEqualTo($currentTime)) {

            $user = User::where('email', $request->email)->first();

            if ($user) {
                $token = $user->createToken('Token Name')->accessToken;

                return response()->json(['message' => 'Email has been verified successfully', 'access_token' => $token], 200);
            } else {
                return response()->json(['error' => 'User not found'], 404);
            }
        } else {
            return response()->json(['error' => 'OTP has expired'], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
