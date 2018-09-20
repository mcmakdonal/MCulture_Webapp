<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;

class GlobalApiController extends Controller
{
    public function index()
    {

    }

    public function province()
    {
        $arg = Myclass::mculter_service("GET", "8080", "data/api/v1/get_province");
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        return response()->json($paginatedItems);
    }

    public function district($id)
    {
        $arg = Myclass::mculter_service("GET", "8080", "data/api/v1/get_district/" . $id);
        $paginatedItems = "";
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        return response()->json($paginatedItems);
    }

    public function subdistrict($id)
    {
        $arg = Myclass::mculter_service("GET", "8080", "data/api/v1/get_subdistrict/" . $id);
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        return response()->json($paginatedItems);
    }

    public function check_auth()
    {
        if (\Cookie::get('mct_user_id') === null) {
            return response()->json(array('status' => false, 'message' => 'not login'));
        } else {
            return response()->json(array('status' => true, 'message' => 'login'));
        }
    }

    public function user_detail(Request $request)
    {
        $token = \Cookie::get('mct_user_id');
        $arg = Myclass::mculter_service("GET", "8080", "user/api/v1/uid", ['' => ''], $token);
        $data_object = [];
        if ($arg->status) {
            $data_object = $arg->data_object;
        }

        return response()->json($data_object);
    }

    public function user_nofti(Request $request)
    {
        $arg = [
            'get_news_update' => $request->nofti,
        ];
        $arg = Myclass::mculter_service("POST", "8080", "user/api/v1/update_getnews", $arg, \Cookie::get('mct_user_id'));

        return response()->json($arg);
    }

    public function sub_type(Request $request)
    {
        $main_type = ($request->main_type == "") ? 1 : $request->main_type;
        $sub_type = MyClass::mculter_service("get", "8080", "data/api/v1/get_subtype/" . $main_type);
        return response()->json($sub_type->data_object);
    }

    public function get_admissionfees()
    {
        $sub_type = MyClass::mculter_service("get", "8080", "data/api/v1/get_admissionfees");
        return response()->json($sub_type->data_object);
    }

}
