<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoginRequest;
use App\Mylibs\Myclass;

class LoginController extends Controller
{
    //
    public function index()
    {
        if (\Cookie::get('mcul_token') !== null) {
            return redirect('/admin/dashboard');
        } else {
            return view('login');
        }

    }

    public function store(StoreLoginRequest $request)
    {
        $username = $request->username;
        $password = $request->password;
        $args = array('username' => $username, 'password' => $password);
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/authentication", $args);
        if ($arg->status) {
            $token = $arg->token;
            $cookie = cookie('mcul_token', $token, 1440);
            return redirect()->route('dashboard')->cookie($cookie);
        } else {
            return redirect('login')->with('status', 'Username or Password is incorrect !');
        }

    }

    public function logout()
    {
        return redirect('/login')->withCookie(\Cookie::forget('mcul_token'));
    }
}
