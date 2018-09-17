<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;

class RecommendController extends Controller
{

    public function __construct()
    {
        $this->middleware('CheckType', ['except' => [
            'index',
            'route_path',
        ]]);
    }

    public function index()
    {
        $main_type = MyClass::mculter_service("get", "8080", "data/api/v1/get_maintype");
        // dd($main_type->data_object);
        return view('recommend-index', [
            'title' => 'MCulture',
            'main_type' => $main_type->data_object,
        ]);
    }

    public function route_path(Request $request)
    {
        $topic_main_type_id = $request->topic_main_type_id;
        $topic_sub_type_id = $request->topic_sub_type_id;
        $path = Myclass::map_path($topic_main_type_id, $topic_sub_type_id);
        session(['type' => [
            'main_id' => $topic_main_type_id,
            'sub_id' => $topic_sub_type_id,
        ]]);
        return redirect($path['path']);
    }

    public function recommend_activity()
    {
        return view('recommend.activity', [
            'title' => 'แนะนำ/ติชม - กิจกรรม',
        ]);
    }

    public function recommend_activity_save(Request $request)
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

    public function recommend_place()
    {
        return view('recommend.place', [
            'title' => 'แนะนำ/ติชม - สถานที่',
        ]);
    }

    // ยังไม่ test
    public function recommend_place_save(Request $request)
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

            'admission_fee_type_id.*' => 'numeric|required',
            'admission_charge.*' => 'string|required',

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

        $admission_fees = [];
        foreach ($request->admission_fee_type_id as $k => $v) {
            $admission_fees[] = [
                'admission_charge' => $request->admission_charge[$k],
                'admission_fee_type_id' => $v,
            ];
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
            'admission_fees' => $admission_fees,
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

    public function recommend_knowledge()
    {
        return view('recommend.knowledge', [
            'title' => 'แนะนำ/ติชม - องค์ความรู้',
        ]);
    }

    // ยังไม่ test
    public function recommend_knowledge_save(Request $request)
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

            'reference' => 'string|nullable',

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
            'reference' => $request->reference,
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

    public function recommend_service()
    {
        return view('recommend.service', [
            'title' => 'แนะนำ/ติชม - บริการ',
        ]);
    }

    // ยังไม่ test
    public function recommend_service_save(Request $request)
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

    public function recommend_employee()
    {
        return view('recommend.employee', [
            'title' => 'แนะนำ/ติชม - บุคคลากร/เจ้าหน้าที่',
        ]);
    }

    // ยังไม่ test
    public function recommend_employee_save(Request $request)
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

    public function recommend_other()
    {
        return view('recommend.other', [
            'title' => 'แนะนำ/ติชม - อื่นๆ',
        ]);
    }

    // ยังไม่ test
    public function recommend_other_save(Request $request)
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
            // 'IFDATA_DATE' => ($request->IFDATA_DATE) ? date("Y-m-d", strtotime($request->IFDATA_DATE)) : null,
            // 'IFDATA_TIMES' => $request->IFDATA_TIMES,
            'sub_district_id' => $request->sub_district_id,
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
