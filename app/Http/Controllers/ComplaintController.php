<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;

class ComplaintController extends Controller
{
    public function complaint_improper_media()
    {
        $media_type = Myclass::mculter_service("GET", "8080", "data/api/v1/get_mediatype");
        return view('complaint.improper_media', [
            'title' => 'ร้องเรียน/ร้องทุกข์ - สื่อไม่เหมาะสม', 'media_type' => $media_type->data_object,
        ]);
    }

    // ยังไม่ test ขาด lat long
    public function complaint_improper_media_save(Request $request)
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

    public function complaint_deviate()
    {
        return view('complaint.deviate', [
            'title' => 'ร้องเรียน/ร้องทุกข์ - พฤติกรรมเบี่ยงเบน',
        ]);
    }

    // ยังไม่ test ขาด lat long
    public function complaint_deviate_save(Request $request)
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

    public function complaint_employee()
    {
        return view('complaint.employee', [
            'title' => 'ร้องเรียน/ร้องทุกข์ - บุคคลากร/เจ้าหน้าที่',
        ]);
    }

    // ยังไม่ test
    public function complaint_employee_save(Request $request)
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

            'organize_id' => 'numeric|required',

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

            'organize_id' => $request->organize_id,

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

    public function complaint_commerce()
    {
        $get_commerce = Myclass::mculter_service("GET", "8080", "data/api/v1/get_commerce");
        return view('complaint.commerce', [
            'title' => 'ร้องเรียน/ร้องทุกข์ - ร้านเกม/ร้านคาราโอเกะ/ร้านขาย DVD เถื่อน', 'get_commerce' => $get_commerce->data_object,
        ]);
    }

    // ยังไม่ test
    public function complaint_commerce_save(Request $request)
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

            'commerce_type_id' => 'numeric|required',
            'business_name' => 'nullable|string|max:255',

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

            'commerce_type_id' => $request->commerce_type_id,
            'business_name' => $request->business_name,

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

    public function complaint_religion()
    {
        $get_religion = Myclass::mculter_service("GET", "8080", "data/api/v1/get_religion");
        return view('complaint.religion', [
            'title' => 'ร้องเรียน/ร้องทุกข์ - ศาสนา', 'get_religion' => $get_religion->data_object,
        ]);
    }

    // ยังไม่ test
    public function complaint_religion_save(Request $request)
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

            'religion_id' => 'numeric|required',

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
            // 'IFDATA_DATE' => ($request->IFDATA_DATE) ? date("Y-m-d", strtotime($request->IFDATA_DATE)) : null,
            // 'IFDATA_TIMES' => $request->IFDATA_TIMES,
            'sub_district_id' => $request->sub_district_id,
            'topic_details' => $request->topic_details,
            'topic_remark' => $request->topic_remark,

            'religion_id' => $request->religion_id,

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

    public function complaint_culture()
    {
        return view('complaint.culture', [
            'title' => 'ร้องเรียน/ร้องทุกข์ - ศิลปะ/วัฒนธรรม',
        ]);
    }

    // ยังไม่ test
    public function complaint_culture_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic_title' => 'required|string|max:255',
            'file.*' => 'nullable',
            'topic_details' => 'string|nullable',
            'topic_remark' => 'string|nullable',
            // 'IFDATA_OPENTIME' => 'string|nullable',
            // 'IFDATA_CLOSETIME' => 'string|nullable',

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
            // 'IFDATA_DATE' => ($request->IFDATA_DATE) ? date("Y-m-d", strtotime($request->IFDATA_DATE)) : null,
            // 'IFDATA_TIMES' => $request->IFDATA_TIMES,
            'topic_details' => $request->topic_details,
            'topic_remark' => $request->topic_remark,

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

    public function complaint_other()
    {
        return view('complaint.other', [
            'title' => 'ร้องเรียน/ร้องทุกข์ - อื่นๆ',
        ]);
    }

    // ยังไม่ test
    public function complaint_other_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic_title' => 'required|string|max:255',
            'province_id' => 'numeric|nullable',
            'district_id' => 'numeric|nullable',
            'sub_district_id' => 'numeric|nullable',
            'file.*' => 'nullable',
            'topic_details' => 'string|nullable',
            // 'IFDATA_OPENTIME' => 'string|nullable',
            // 'IFDATA_CLOSETIME' => 'string|nullable',

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
            'sub_district_id' => $request->sub_district_id,
            // 'IFDATA_DATE' => ($request->IFDATA_DATE) ? date("Y-m-d", strtotime($request->IFDATA_DATE)) : null,
            // 'IFDATA_TIMES' => $request->IFDATA_TIMES,
            'topic_details' => $request->topic_details,

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
