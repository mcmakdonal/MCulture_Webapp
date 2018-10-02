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
            return redirect('/admin');
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
            $cookie_token = cookie('mcul_token', $arg->token, 1440);
            $cookie_role = cookie('mcul_role', $arg->role, 1440);
            $cookie_id = cookie('mcul_id', $arg->user_id, 1440);
            return redirect('admin')->cookie($cookie_token)->cookie($cookie_role)->cookie($cookie_id);
        } else {
            return redirect('login')->with('status', 'Username or Password is incorrect !');
        }

    }

    public function logout()
    {
        return redirect('/login')->withCookie(\Cookie::forget('mcul_token'))->withCookie(\Cookie::forget('mcul_role'))->withCookie(\Cookie::forget('mcul_id'));
    }
}
