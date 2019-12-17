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
        if($request->role) {
            if($request->role === 'driver') {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone' => $request->phone,
                    'role' => $request->role,
                    'status' => 'inactive'
                ]);
            } else {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone' => $request->phone,
                    'role' => $request->role,
                ]);
            }
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone
            ]);
        }
        
        
        if(!$token = auth()->guard('api')->attempt($request->only('email', 'password'))) {
            return abort(401);
        }
        return (new UserResource($request->user('api')))->additional([
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
        if(!$token = auth()->guard('api')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'error' => [
                    'message' => ['Wrong details']
                ]
                ], 422);
        }
        return (new UserResource($request->user('api')))->additional([
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
        if(!auth()->guard('api')->check()) {
            return response()->json([
                'error' => [
                    'message' => ['Wrong details']
                ]
                ], 401);
        }
        return new UserResource($request->user('api'));
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if(!auth()->guard('api')->check()) {
            return response()->json([
                'error' => [
                    'message' => ['Wrong details']
                ]
                ], 401);
        }
        auth()->guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    /**
     * Set user role
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setRole(Request $request)
    {
        $user = auth()->user('api');
        if($request->role === 'driver') {
            $user->status = 'inactive';
        }
        $user->role = $request->role;
        $user->save();

        return new UserResource($user);
    }

    /**
     * Update (user's profile)
     *
     * @param UserUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request) 
    {
        $user = auth()->user('api');
        $user->name = $request->name;
        if($request->password) {
            if($user->email === $request->email && $user->phone === $request->phone) {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:191',
                    'password'  => 'string|max:191|min:8|confirmed',
                ]);
            } elseif($user->email === $request->email) {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:191',
                    'phone'  => 'required|string|max:191|min:6|unique:users',
                    'password'  => 'string|max:191|min:8|confirmed',
                ]);
            } elseif($user->phone === $request->phone) {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:191',
                    'email' => 'required|max:191|email|unique:users',
                    'password'  => 'string|max:191|min:8|confirmed',
                ]);
            } else {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:191',
                    'email' => 'required|max:191|email|unique:users',
                    'password'  => 'string|max:191|min:8|confirmed',
                    'phone'  => 'required|string|max:191|min:6|unique:users'
                ]);
            }
        } else  {
            if($user->email === $request->email && $user->phone === $request->phone) {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:191'
                ]);
            } elseif($user->email === $request->email) {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:191',
                    'phone'  => 'required|string|max:191|min:6|unique:users'
                ]);
            } elseif($user->phone === $request->phone) {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:191',
                    'email' => 'required|max:191|email|unique:users'
                ]);
            } else {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:191',
                    'email' => 'required|max:191|email|unique:users',
                    'phone'  => 'required|string|max:191|min:6|unique:users'
                ]);
            }
        }
        $user->email = $request->email;
        $user->phone = $request->phone;
        if($request->password) {
            $user->password = $request->password;
        }
        $user->save();
        return new UserResource($user);
    }
}
