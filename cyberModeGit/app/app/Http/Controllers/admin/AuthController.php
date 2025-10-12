<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Dcblogdev\MsGraph\Facades\MsGraph;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function connect()
    {
        // Additional check if you want to verify domain, etc.
        return MsGraph::connect();
    }

    public function logout()
    {
        // Optional: Log activity before logout
        if (auth()->check()) {
            auth()->user()->update(['last_logout_at' => now()]);
        }

        return MsGraph::disconnect();
    }
}
