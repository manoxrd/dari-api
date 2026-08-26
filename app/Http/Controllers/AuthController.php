<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
  public function register(RegisterRequest $request)
  {
    $user = User::create($request->only('name', 'email', 'phone', 'password'));

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
      'token' => $token,
      'token_type' => 'Bearer',
      'user' => $user
    ], 201);
  }
}
