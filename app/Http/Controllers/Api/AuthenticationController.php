<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        return response()->json(['data' => ['message' => 'User registered successfully.', 'data' => $request->all()]], 200);
    }
}
