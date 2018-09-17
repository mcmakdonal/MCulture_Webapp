<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;

class OtherController extends Controller
{
    public function other_other()
    {
        return view('other.other', [
            'title' => 'อื่นๆ'
        ]);
    }

    // ยังไม่ test ขาด lat long
    public function other_other_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic_title' => 'required|string|max:255',
            'province_id' => 'numeric|nullable',
            'district_id' => 'numeric|nullable',
            'sub_district_id' => 'numeric|nullable',
            'file.*' => 'nullable',
            'topic_details' => 'string|nullable',
            'topic_remark' => 'string|nullable',
            // 'IFDATA_OPENTIME' => 'string|nullable',
            // 'IFDATA_CLOSETIME' => 'string|nullable',

            'media_type_id' => 'numeric|required',

            'communicant_fullname' => 'string|max:150|nullable',
            'communicant_email' => 'email|max:150|nullable',
            'communicant_phone' => 'numeric|digits_between:0,50|nullable',
            'communicant_identification' => 'numeric|digits_between:0,13|nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $files = [];
        if ($request->hasfile('file')) {
            foreach ($request->file('file') as $file) {
                $name = md5($file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
                $file->move(public_path() . '/files/', $name);
                $files[] = public_path('files/' . $name);
            }
        }

        $args = array(
            'topic_main_type_id' => session('type')['main_id'],
            'topic_sub_type_id' => session('type')['sub_id'],
            'topic_title' => $request->topic_title,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            // 'IFDATA_DATE' => ($request->IFDATA_DATE) ? date("Y-m-d", strtotime($request->IFDATA_DATE)) : null,
            // 'IFDATA_TIMES' => $request->IFDATA_TIMES,
            'sub_district_id' => $request->sub_district_id,
            'topic_details' => $request->topic_details,
            'topic_remark' => $request->topic_remark,

            'media_type_id' => $request->media_type_id,

            'communicant_fullname' => $request->communicant_fullname,
            'communicant_email' => $request->communicant_email,
            'communicant_phone' => $request->communicant_phone,
            'communicant_identification' => $request->communicant_identification,
        );
        $token = (\Cookie::get('mct_user_id') !== null) ? \Cookie::get('mct_user_id') : null;
        $arg = Myclass::buildMultiPartRequest("POST", "8080", "topic/api/v1/add", $args, $files, $token);
        if ($arg->status) {
            return redirect()->back()->with('status', $arg->description);
        } else {
            return redirect()->back()->withErrors($arg->description);
        }
    }
}
