<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * API: POST /api/login
     */
    public function api_login(Request $request)
    {
        return $this->login($request);
    }

    public function login(Request $request)
    {
        $inputs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'nullable|boolean'
        ]);

        $credentials = [
            'email' => $inputs['email'],
            'password' => $inputs['password']
        ];

        if (Auth::attempt($credentials, $inputs['remember'])) {
            $user_data = Auth::user();
            return response()->json($user_data);
        }

        return response()->json(['message' => 'login failed'], 401);
    }

    public function api_logout(Request $request)
    {
        return $this->logout($request);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Logout.']);
    }

    public function is_login(Request $request = null): bool
    {
        return Auth::check();
    }

}

