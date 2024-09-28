<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        // Create a validator instance
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', // Requires confirmation
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Automatically log in the user
        Auth::login($user);

        // Generate a token for the user (if using Sanctum)
        $token = $user->createToken('API Token')->plainTextToken;

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'User registered and logged in successfully!',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Log in a user and return a token.
     */
    public function login(Request $request)
    {
        // Create a validator instance
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8', // Adjust as needed
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a JSON response with errors
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422); // HTTP status 422 Unprocessable Entity
        }

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // If successful, get the authenticated user
            $user = Auth::user();

            // Generate a token for the user (if using Sanctum)
            $token = $user->createToken('API Token')->plainTextToken;

            // Return a success response with user information and token
            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'user' => $user,
                'token' => $token, // Include token for authenticated requests
            ], 200); // HTTP status 200 OK
        }

        // Return an error response if login failed
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials.',
        ], 401); // HTTP status 401 Unauthorized
    }

    /**
     * Log out the authenticated user.
     */
    public function logout(Request $request)
    {
        // Delete all tokens for the authenticated user
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the authenticated user's profile.
     */
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }
}