<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\User as UserResource;

class AuthController extends Controller
{
    /**
     * Get basic user info (name and email) + JWT token
     *
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRegisterRequest $request) 
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone
        ]);
        
        if(!$token = auth()->attempt($request->only('email', 'password'))) {
            return abort(401);
        }
        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' => $token
            ]
        ]);
    }

    /**
     * Login the user and get basic user info (name and email) + JWT token
     *
     * @param UserLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserLoginRequest $request) 
    {
        if(!$token = auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'error' => [
                    'message' => ['Wrong details']
                ]
                ], 422);
        }
        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' => $token
            ]
        ]);
    }

    /**
     * Get user basic info (Maybe for future user profile)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request) 
    {
        if(!auth()->check()) {
            return response()->json([
                'error' => [
                    'message' => ['Wrong details']
                ]
                ], 401);
        }
        return new UserResource($request->user());
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if(!auth()->check()) {
            return response()->json([
                'error' => [
                    'message' => ['Wrong details']
                ]
                ], 401);
        }
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
