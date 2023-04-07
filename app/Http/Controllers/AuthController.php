<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nette\Schema\Expect;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth:api", ["except" => ["register", "login"]]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"     => "required",
            "email"    => "required|string|email|unique:users",
            "password" => "required|string|confirmed|min:8",
            "password_confirmation" => "required|string|min:8",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            [
                "password" => bcrypt($request->password),
                "password_confirmation" => bcrypt($request->password_confirmation)
            ]
        ));
        return response()->json(["message" => "User Is Created Success", "user" => $user], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email"    => "required",
            "password" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $token = auth()->attempt($validator->validated());
        if (!$token) {
            return response()->json(["message" => "User UnAuthentication"], 401);
        }
        return $this->createNewToken($token);
    }

    public function createNewToken($token)
    {
        return response()->json([
            "access_token" => $token,
            "expires_in" => auth()->factory()->getTTL(),
            "user" => auth()->user(),
        ]);
    }

    public function profile()
    {
        return response()->json(auth()->user(), 200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(["message" => "User is Logout"], 200);
    }
}
