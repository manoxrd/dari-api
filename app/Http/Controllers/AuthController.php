<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

  public function login(LoginRequest $request) {
    $validated = $request->validated();

    $user = User::where('email', $validated['email'])->first();

    if(! $user || ! Hash::check($validated['password'], $user->password)) throw ValidationException::withMessages(['email' => 'sorry these credentials does not match']);

    $user->tokens()->delete();
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
      'user' => $user,
      'token' => $token,
      'token_type' => 'Bearer'
    ]);
  }
}
