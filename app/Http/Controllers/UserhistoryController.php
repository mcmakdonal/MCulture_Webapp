<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Crypt;

class UserhistoryController extends Controller
{
    public function index()
    {
        $arg = Myclass::mculter_service("GET", "8080", "user/api/v1/history", ['' => ''], \Cookie::get("mct_user_id"));
        // dd($arg);
        $obj = [];
        if ($arg->status) {
            $obj = $arg->data_object->topic_data;
        }

        return view('history', [
            'title' => 'History', 'obj' => $obj
        ]);
    }

}
