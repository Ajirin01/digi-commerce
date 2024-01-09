<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    function updateCartAtAuth($request)
    {
        if($request->cart != null){
            foreach (json_decode($request->cart) as $key => $cart) {
              $product_id = $cart->product_id;

              $product_from_cart = Cart::where('product_id', $product_id)->where('user_id', Auth::user()->id)->first();

              if($product_from_cart == null){
                $data = [
                  "product_id"=> $cart->product_id,
                  "quantity"=> $cart->quantity,
                  "user_id"=> Auth::user()->id,
                  "price"=> $cart->price,
                  "variations"=> $cart->variations
                ];
                  
                Cart::create($data);
              }else{
                  $product_from_cart->product_quantity = $product_from_cart->product_quantity + $cart->product_quantity;
                  $product_from_cart->save();
              }
            }
        }
    }

    // Function to login user
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            Auth::login($user);

            // return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token]);
            return redirect($request->previousRoute);
        }

        $this->updateCartAtAuth($request);

        return redirect()->back()->with('error', 'Invalid login credentials');
        // return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function register(Request $request)
    {
        // Validate the request
        $userData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'password' => 'required|string|min:6',
            'previousRoute' => 'nullable|string',
        ]);

        // Combine first_name and last_name into name
        $userData['name'] = $userData['first_name'] . " " . $userData['last_name'];

        // Hash the password
        $userData['password'] = Hash::make($userData['password']);

        // Set a default role
        $userData['role'] = 'user';

        // Check if the email already exists
        if (User::where('email', $userData['email'])->exists()) {
            return redirect()->back()->withErrors(['email' => 'The email address is already in use.']);
        }

        // Create the user
        $user = User::create($userData);

        // Log in the user
        Auth::login($user);

        $this->updateCartAtAuth($request);

        // Redirect to the previous route or a default route
        if ($userData['previousRoute'] === route('register') || $userData['previousRoute'] === route('submitRegister')) {
            return redirect('/');
        }

        return redirect($userData['previousRoute'] ?? '/')->with(['message' => 'User registered successfully']);
    }


    public function loginView(Request $request)
    {
        // return response()->json(auth() == null);
        if(auth()->check()){
            return redirect('/');
        }
        return view("shop.login", ['previousRoute'=> url()->previous()]);
        // return response()->json(url()->previous() === route('login'));
    }

    // Function to register user
    public function registerView(Request $request)
    {
        return view("shop.register", ['previousRoute'=> url()->previous()]);
    }

    // Function to logout user
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        auth()->logout();

        return response()->json(['message' => 'Logout successful']);
    }

    // Function to update user account
    public function updateUserAccount(Request $request)
    {
        $user = $request->user();

        $userData = $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'string|min:6',
            'phone' => 'string',
            'role' => 'string',
            // Add any other fields you want to update
        ]);

        if ($request->has('password')) {
            $userData['password'] = bcrypt($userData['password']);
        }

        $user->update($userData);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    // Function to get user profile
    public function getUserProfile(Request $request)
    {
        $user = $request->user();

        return response()->json(['user' => $user]);
    }
}
