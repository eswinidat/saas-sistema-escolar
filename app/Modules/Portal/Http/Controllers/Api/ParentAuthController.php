<?php

namespace App\Modules\Portal\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ParentAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        if (! Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            throw ValidationException::withMessages(['email' => ['Credenciales incorrectas.']]);
        }

        $user = $request->user();

        if (! $user->hasRole('Padre')) {
            Auth::logout();
            throw ValidationException::withMessages(['email' => ['Acceso solo para apoderados.']]);
        }

        $token = $user->createToken($credentials['device_name'] ?? 'portal-mobile')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Sesión cerrada.']);
    }
}
