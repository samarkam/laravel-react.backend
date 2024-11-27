<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;


class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request) 
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'avatar' => 'nullable',  
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => "CLIENT",
            'avatar' => $request->avatar,  
            'isActive' => false, 
        ]);
    
        return response()->json(['message' => 'User created successfully'], 201);
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        try {
            // Add minutes with a properly cast integer value
            $expiry = Carbon::now()->addMinutes((int) 60)->timestamp;
    
            \Log::info('Expiry Timestamp: ' . $expiry); // Log for debugging
    
            if (!$token = JWTAuth::attempt($credentials, ['exp' => $expiry])) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); // Capture unexpected errors
        }
    
        return response()->json(compact('token'));
    }
    // Logout user (invalidate the token)
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    // Get user details using the JWT token
    public function user(Request $request)
    {
        return response()->json(auth()->user());
    }
    public function validateToken(Request $request)
    {
        try {
            // Get the token from the request
            $token = JWTAuth::getToken();

            if (!$token) {
                return response()->json(['message' => 'Token not provided'], 400);
            }

            // Validate the token
            $user = JWTAuth::authenticate($token);

            return response()->json([
                'message' => 'Token is valid',
                'user' => $user, // Include user details if needed
            ]);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Token is invalid'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

}

