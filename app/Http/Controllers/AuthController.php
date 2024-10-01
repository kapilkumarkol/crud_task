<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Exception;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['message' => 'Registration successful', 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json(['token' => $token, 'user' => $user],200);
            }

            return response()->json(['message' => 'Invalid login credentials'], 401);
        }
        catch(Exception $e){
            return response()->json(['message' => 'Something went wrong',"error"=>$e->getMessage()], 500);
        }

    }
}
