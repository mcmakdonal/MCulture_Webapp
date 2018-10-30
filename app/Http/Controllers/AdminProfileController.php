<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;

class AdminProfileController extends Controller
{
    public function index()
    {
        $token = \Cookie::get('mcul_token');
        $id = \Cookie::get('mcul_id');
        $content = [];
        $arg = Myclass::mculter_service("GET", "8080", "admin/api/v1/uid/" . $id, [], $token);
        $content = $arg->data_object;

        return view('administrator.profile', [
            'title' => 'โปรไฟล์ ผู้ดูแลระบบ', 'header' => 'โปรไฟล์ ผู้ดูแลระบบ', 'content' => $content,
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ADMIN_FULLNAME' => 'required|max:150',
            'ADMIN_PASSWORD' => 'max:150',
            'C_ADMIN_PASSWORD' => 'max:150',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->ADMIN_PASSWORD != $request->C_ADMIN_PASSWORD) {
            return redirect()->back()->withErrors("รหัสผ่าน กับ ยืนยัน รหัสผ่านไม่ตรงกัน");
        }

        $args = array(
            'fullname' => $request->ADMIN_FULLNAME,
            'password' => ($request->ADMIN_PASSWORD == "") ? $request->ADMIN_PASSWORD_OLD : $request->ADMIN_PASSWORD,
            'user_id' => \Cookie::get('mcul_id'),
            'role' => \Cookie::get('mcul_role')
        );
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/update_user", $args, $token);
        if ($arg->status) {
            return redirect()->back()->with('status', 'อัพเดตสำเร็จ');
        } else {
            return redirect()->back()->withErrors($arg->description);
        }
    }
}
