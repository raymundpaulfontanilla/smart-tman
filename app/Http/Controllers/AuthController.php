<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
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

    function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 'EMAIL_OR_PASSWORD_INCORRECT',
                'message' => 'email or password is incorrect',
                'user' => null
            ], 404);
        }

        $salt = $user->salt;
        $storedHash = $user->password;

        $passwordWithSalt = $request->password . $salt;
        $hashedInput = hash('sha256', $passwordWithSalt);

        if ($hashedInput == $storedHash) {
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'Successfully logged in. Welcome ' . $user->name,
                'user' => ([
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 'EMAIL_OR_PASSWORD_INCORRECT',
                'message' => 'email or password is incorrect',
                'user' => null
            ], 404);
        }
    }
}
