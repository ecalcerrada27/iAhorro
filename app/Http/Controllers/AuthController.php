<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

final class AuthController extends Controller
{
    /**
     * @param App\Http\Requests\LoginUserFormRequest $request
     * @return Illuminate\Http\JsonResponse
     */
    public function login(LoginUserFormRequest $request): JsonResponse
    {
        if(auth('web')->attempt($request->only('email', 'password'))){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Bienvendido '.$user->name,
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
            ]
        );
    }

    /**
     * @return Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Hasta pronto']);
    }

}
