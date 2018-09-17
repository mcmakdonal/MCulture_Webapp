<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Socialize;
use Validator;

class IndexController extends Controller
{
    //

    public function index(Request $request)
    {
        return view('index', [
            'title' => 'MCulture', 'content' => 'content',
        ]);
    }

    public function facebookAuthRedirect()
    {
        return Socialize::with('facebook')->redirect();
    }

    public function facebookSuccess()
    {
        $user = Socialize::driver('facebook')->user();
        // dd($user); // print value debug.
        if ($user) {
            $arg = array(
                'user_email' => $user->email,
            );
            // dd($arg);
            $result = Myclass::mculter_service("POST", "8080", "user/api/v1/check_email", $arg);
            // dd($result);
            if (array_key_exists("token", $result)) {
                // มี email ในระบบแล้ว
                $cookie = cookie('mct_user_id', $result->token, 1440);
                return redirect()->route('index')->cookie($cookie);
            } else {
                $arg = array(
                    'user_fbname' => $user->name,
                    'user_fullname' => $user->name,
                    'user_email' => $user->email,
                    'user_phone' => '',
                    'user_type' => 'M',
                );
                $result = Myclass::mculter_service("POST", "8080", "user/api/v1/add_user", $arg);
                // dd($result);
                if ($result->status) {
                    $USER_FULLNAME = cookie('USER_FULLNAME', $user->name, 1440);
                    $USER_EMAIL = cookie('USER_EMAIL', $user->email, 1440);
                    $token = cookie('mct_user_id', $result->token, 1440);
                    return redirect()->route('index')->withCookie($token)->withCookie($USER_FULLNAME)->withCookie($USER_EMAIL);
                } else {
                    return redirect('index')->with('status', 'Incorrect to add user!');
                }
            }
        } else {
            return redirect('index')->with('status', 'Incorrect to get data!');
        }
    }

    public function first_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'USER_FULLNAME' => 'required|max:150',
            'USER_EMAIL' => 'required|max:150',
            'USER_PHONENUMBER' => 'required|max:150',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'user_fbname' => $request->USER_FULLNAME,
            'user_fullname' => $request->USER_FULLNAME,
            'user_email' => $request->USER_EMAIL,
            'user_phone' => $request->USER_PHONENUMBER,
            'user_type' => "M",
        );
        $arg = Myclass::mculter_service("POST", "8080", "user/api/v1/update_user", $args, \Cookie::get("mct_user_id"));
        if ($arg->status) {
            return redirect()->route('index')->withCookie(\Cookie::forget('USER_EMAIL'))->withCookie(\Cookie::forget('USER_FULLNAME'))->with('status', 'Update Profile Success!');
        } else {
            return redirect()->back()->withErrors($arg->description);
        }
    }

    public function facebooklogout()
    {
        return redirect('/')->withCookie(\Cookie::forget('mct_user_id'));
    }



}
