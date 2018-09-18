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

    // ยังไม่ test
    public function complaint_improper_media_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'media_type_id' => 'numeric|required',
            'topic_title' => 'required|string|max:255',
            'topic_details' => 'string|nullable',
            'topic_location' => 'string|nullable',
            'topic_latitude' => 'string|nullable',
            'topic_longitude' => 'string|nullable',
            'file.*' => 'nullable',
            'topic_remark' => 'string|nullable',

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
            'media_type_id' => $request->media_type_id,
            'topic_title' => $request->topic_title,
            'topic_details' => $request->topic_details,
            'topic_location' => $request->topic_location,
            'topic_latitude' => $request->topic_latitude,
            'topic_longitude' => $request->topic_longitude,
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

    public function complaint_deviate()
    {
        return view('complaint.deviate', [
            'title' => 'ร้องเรียน/ร้องทุกข์ - พฤติกรรมเบี่ยงเบน',
        ]);
    }

    // ยังไม่ test
    public function complaint_deviate_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic_title' => 'required|string|max:255',
            'topic_details' => 'string|nullable',
            'topic_location' => 'string|nullable',
            'topic_latitude' => 'string|nullable',
            'topic_longitude' => 'string|nullable',
            'file.*' => 'nullable',
            'topic_remark' => 'string|nullable',

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
            'topic_details' => $request->topic_details,
            'topic_location' => $request->topic_location,
            'topic_latitude' => $request->topic_latitude,
            'topic_longitude' => $request->topic_longitude,
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
            'organize_id' => 'numeric|required',
            'start_date' => 'string|nullable',
            'start_time' => 'string|nullable',
            'province_id' => 'numeric|nullable',
            'district_id' => 'numeric|nullable',
            'sub_district_id' => 'numeric|nullable',
            'topic_details' => 'string|nullable',
            'file.*' => 'nullable',
            'topic_remark' => 'string|nullable',

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
            'organize_id' => $request->organize_id,
            'start_date' => ($request->start_date) ? date("Y-m-d", strtotime($request->start_date)) : null,
            'start_time' => $request->start_time,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
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
            'commerce_type_id' => 'numeric|required',
            'topic_title' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'topic_details' => 'string|nullable',
            'file.*' => 'nullable',
            'topic_remark' => 'string|nullable',

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
            'commerce_type_id' => $request->commerce_type_id,
            'topic_title' => $request->topic_title,
            'business_name' => $request->business_name,
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
            'religion_id' => 'numeric|required',
            'topic_title' => 'required|string|max:255',
            'topic_details' => 'string|nullable',
            'file.*' => 'nullable',
            'topic_remark' => 'string|nullable',

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
            'religion_id' => $request->religion_id,
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
            'topic_details' => 'string|nullable',
            'file.*' => 'nullable',
            'topic_remark' => 'string|nullable',

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
            'topic_details' => 'string|nullable',
            'topic_location' => 'string|nullable',
            'topic_latitude' => 'string|nullable',
            'topic_longitude' => 'string|nullable',
            'file.*' => 'nullable',

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
            'topic_details' => $request->topic_details,
            'topic_location' => $request->topic_location,
            'topic_latitude' => $request->topic_latitude,
            'topic_longitude' => $request->topic_longitude,
            
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
