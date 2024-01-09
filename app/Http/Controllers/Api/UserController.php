<?php

// UserController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (auth()->attempt($request->only('email', 'password'))) {
            $user = auth()->user();
            $token = $user->createToken('auth_token')->accessToken;

            // Return user and token
            return response()->json(['user' => $user, 'access_token' => $token], 200);
        }

        // Authentication failed
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate token for the registered user
        $token = $user->createToken('auth_token')->accessToken;

        // Return user and token
        return response()->json(['user' => $user, 'access_token' => $token], 201);
    }

    public function update($id, Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'string|min:6',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user
        $user->update($request->all());

        // Return the updated user
        return response()->json($user, 200);
    }

    public function logout(Request $request)
    {
        // Revoke the user's access token
        $request->user()->token()->revoke();

        // Return success response
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function query(Request $request){
        return response()->json(User::where($request->all())->get(), 200);
    }
}

