<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email', // Validate the email format
            'password' => 'required', // Validate the password
        ]); // Validate the request data

        $user = \App\Models\User::where('email', $request->email)->first(); // Find the user by email

        if (!$user) { // If the user does not exist
            throw ValidationException::withMessages([ // Throw a validation exception
                'email' => ['The provided credentials are incorrect.'] // Custom error message
            ]);
        }

        if (!Hash::check($request->password, $user->password)) { // Check if the password is correct
            throw ValidationException::withMessages([ // Throw a validation exception
                'email' => ['The provided credentials are incorrect.'] // Custom error message
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken; // Create a new token for the user
        
        return response()->json([ // Return a JSON response
            'token' => $token // The generated token
        ]);
    }

    public function logout(Request $request){
        
    }
}
