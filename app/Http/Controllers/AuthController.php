<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(AuthRequest $request)
    {
        $validated = $request->validated();

        $temporarySalt = Str::random(32);
        $userPassword = ($validated['password']);

        $passwordWithSalt = $userPassword . $temporarySalt;
        $passwordHash = hash('sha256', $passwordWithSalt);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $passwordHash,
            'salt' => $temporarySalt
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'Successfully registered account, you may now try to login.',
            'user' => $user,
        ], 201);
    }
}
