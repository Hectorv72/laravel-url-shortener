<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthController extends Controller
{
    private function serverErrorMessage(Exception $e)
    {
        error_log($e->getMessage());
        return response()->json(['message' => 'Lo sentimos, ocurrió un error vuelva a intentarlo más tárde'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function register(Request $request)
    {
        try {
            // valida los datos
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed'
            ]);

            // agrega el usuario
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->save();

            return response()->json($user, Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return $this->serverErrorMessage($e);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $token = Auth::user()->createToken('token')->plainTextToken;
                $cookie = cookie('cookie_token', $token, 60 * 24);
                return response(["token" => $token], Response::HTTP_OK)->withCookie($cookie);
            } else {
                return response(["message" => "Credenciales invalidas"], Response::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            return $this->serverErrorMessage($e);
        }
    }

    public function profile()
    {
        try {
            return response()->json([
                "message" => "user profile ok",
                "user" => auth()->user(),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->serverErrorMessage($e);
        }
    }

    public function logout()
    {
        try {
            $cookie = Cookie::forget('cookie_token');
            return response(["message" => "Cierre de session ok"], Response::HTTP_ACCEPTED)->withCookie($cookie);
        } catch (Exception $e) {
            return $this->serverErrorMessage($e);
        }
    }

    public function all()
    {
        try {
            return response()->json(["users" => User::all()]);
        } catch (Exception $e) {
            return $this->serverErrorMessage($e);
        }
    }
}
