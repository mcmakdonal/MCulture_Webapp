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
            'user_fullname' => 'string|max:150|nullable',
            'user_email' => 'email|max:150|nullable',
            'user_phone' => 'numeric|digits_between:0,50|nullable',
            'user_identification' => 'numeric|digits_between:0,13|nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'user_identification' => $request->user_identification,
            'user_fullname' => $request->user_fullname,
            'user_email' => $request->user_email,
            'user_phone' => $request->user_phone,
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


    public function recommend()
    {
        $main_type = MyClass::mculter_service("get", "8080", "data/api/v1/get_maintype");
        // dd($main_type->data_object);
        return view('recommend', [
            'title' => 'MCulture',
            'main_type' => $main_type->data_object,
        ]);
    }

    public function route_path(Request $request)
    {
        $topic_main_type_id = $request->topic_main_type_id;
        $topic_sub_type_id = $request->topic_sub_type_id;
        $map_field = Myclass::map_field($topic_main_type_id, $topic_sub_type_id);
        session(['type' => [
            'main_id' => $topic_main_type_id,
            'sub_id' => $topic_sub_type_id,
        ]]);
        session(['field' => $map_field['field']]);
        session(['title' => $map_field['title']]);
        return redirect('onepage');
    }

    public function onepage(Request $request)
    {
        if (!$request->session()->has('field')) {
            return redirect('/recommend');
        }
        $media_type = Myclass::mculter_service("GET", "8080", "data/api/v1/get_mediatype");
        $get_religion = Myclass::mculter_service("GET", "8080", "data/api/v1/get_religion");
        $get_commerce = Myclass::mculter_service("GET", "8080", "data/api/v1/get_commerce");
        $get_organizations = Myclass::mculter_service("GET", "8080", "data/api/v1/get_organizations");
        return view('onepage', [
            'title' => session('title'),
            'get_commerce' => $get_commerce->data_object,
            'get_religion' => $get_religion->data_object,
            'media_type' => $media_type->data_object,
            'get_organizations' => $get_organizations->data_object,
        ]);
    }

    public function store_onepage(Request $request)
    {
        if (!$request->session()->has('type')) {
            return redirect('/recommend');
        }
        $validator = Validator::make($request->all(), [
            'topic_title' => 'required|string|max:255',

            'admission_fee_type_id.*' => 'numeric|nullable',
            'admission_charge.*' => 'string|nullable',

            'reference' => 'string|nullable',

            'organize_id' => 'numeric|nullable',

            'media_type_id' => 'numeric|nullable',

            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'start_time' => 'nullable',
            'end_time' => 'nullable',

            'topic_location' => 'string|nullable',
            'topic_latitude' => 'string|nullable',
            'topic_longitude' => 'string|nullable',

            'commerce_type_id' => 'numeric|nullable',
            'business_name' => 'nullable|string|max:255',

            'religion_id' => 'numeric|nullable',

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
        $args = [];
        $files = [];
        if ($request->hasfile('file')) {
            foreach ($request->file('file') as $file) {
                $name = md5($file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
                $file->move(public_path() . '/files/', $name);
                $files[] = public_path('files/' . $name);
            }
        }

        $admission_fees = [];
        if ($request->exists('admission_fee_type_id')) {
            foreach ($request->admission_fee_type_id as $k => $v) {
                $admission_fees[] = [
                    'admission_fee_type_id' => $v,
                    'admission_charge' => $request->admission_charge[$k],
                ];
            }
        }

        $working_times = [];
        if (session('type')['sub_id'] == 2) {
            foreach ($request->start_date as $k => $v) {
                $working_times[] = [
                    'working_start_date' => $v,
                    'working_end_date' => $request->end_date[$k],
                    'working_start_time' => $request->start_time[$k],
                    'working_end_time' => $request->end_time[$k],
                ];
            }
        } else {
            $args['start_date'] = ($request->start_date) ? date("Y-m-d", strtotime($request->start_date)) : null;
            $args['end_date'] = ($request->start_date) ? date("Y-m-d", strtotime($request->start_date)) : null;
            $args['start_time'] = $request->start_time;
            $args['end_time'] = $request->end_time;
        }

        $args['topic_main_type_id'] = session('type')['main_id'];
        $args['topic_sub_type_id'] = session('type')['sub_id'];
        $args['topic_title'] = $request->topic_title;
        $args['admission_fees'] = $admission_fees;
        $args['working_times'] = $working_times;
        $args['reference'] =  $request->reference;
        $args['organize_id'] = $request->organize_id;
        $args['media_type_id'] = $request->media_type_id;
        $args['topic_location'] = $request->topic_location;
        $args['topic_latitude'] = $request->topic_latitude;
        $args['topic_longitude'] = $request->topic_longitude;

        $args['commerce_type_id'] = $request->commerce_type_id;
        $args['business_name'] = $request->business_name;
        $args['religion_id'] = $request->religion_id;

        $args['province_id'] = $request->province_id;
        $args['district_id'] = $request->district_id;
        $args['sub_district_id'] = $request->sub_district_id;
        $args['topic_details'] = $request->topic_details;
        $args['topic_remark'] = $request->topic_remark;

        $args['communicant_fullname'] = $request->communicant_fullname;
        $args['communicant_email'] = $request->communicant_email;
        $args['communicant_phone'] = $request->communicant_phone;
        $args['communicant_identification'] = $request->communicant_identification;

        // dd($args);

        $token = (\Cookie::get('mct_user_id') !== null) ? \Cookie::get('mct_user_id') : null;
        $arg = Myclass::buildMultiPartRequest("POST", "8080", "topic/api/v1/add", $args, $files, $token);
        if ($arg->status) {
            $request->session()->forget('type');
            $request->session()->forget('field');
            $request->session()->forget('title');
            return redirect('/recommend')->with('status', $arg->description);
        } else {
            return redirect()->back()->withErrors($arg->description);
        }
    }

}
