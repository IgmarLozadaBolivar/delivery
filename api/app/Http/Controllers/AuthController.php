<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\CamioneroRequest;
use App\Models\Camionero;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, CamioneroRequest $camioneroRequest)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'camionero',
            'telefono' => $request->telefono
        ]);
        $user->assignRole('camionero');

        $camionero = Camionero::create([
            'documento' => $camioneroRequest->documento,
            'fecha_nacimiento' => $camioneroRequest->fecha_nacimiento,
            'licencia' => $camioneroRequest->licencia,
            'user_id' => $user->id
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'      => $user,
            'camionero' => $camionero,
            'token'     => $token,
        ]);
    }

    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $token = Str::random(10);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciales no correctas',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente',
        ]);
    }
}
