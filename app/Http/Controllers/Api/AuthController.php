<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreRegisterRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(StoreRegisterRequest $request)
    {
        $return = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        try {
            $return->save();
        } catch (\Exception $errors) {
            $return = $this->format(
                '10',
                'Get item error',
                $errors->getMessage()
            );
            return response()->json($return);
        }

        $return = $this->format(
            '0',
            'Get item success',
            $return
        );

        return response()->json($return);
    }

    public function login(StoreLoginRequest $request)
    {
        $credential = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credential)) {
            return response()->json([
                'message' => 'Email or Password is incorrect'
            ], 401);
        } else {
            return response()->json([
                'user' => auth()->guard('api')->user(),
                'token' => $token
            ], 201);
        }
    }

    public function getUser()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->noContent();
    }
}