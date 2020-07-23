<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    private $ctrl;
    private $user;

    public function __construct(LoginController $ctrl, User $user)
    {
        $this->ctrl = $ctrl;
        $this->user = $user;
    }

    /**
     * API: POST /user/self
     */
    public function get_self(Request $request)
    {
        if ($this->ctrl->is_login($request)) {
            $user_data = Auth::user();
            return response()->json($user_data);
        }
        return response()->json(['message' => 'login failed'], 401);
    }
}

