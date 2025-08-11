<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * Register new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole('user');

        // Create related records
        $user->onboardingProgress()->create(['current_step' => 1]);
        $user->notificationSettings()->create([]);

        $success['token'] = $user->createToken('TRIMESTRA')->plainTextToken;
        $success['user'] = $user;

        return $this->sendResponse($success, 'User registered successfully.');
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('TRIMESTRA')->plainTextToken;
            $success['user'] = $user;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorized', ['error' => 'Invalid credentials'], 401);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return $this->sendResponse([], 'User logged out successfully.');
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        return $this->sendResponse(auth()->user(), 'User retrieved successfully.');
    }
}
