<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;

class InformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arg = Myclass::mculter_service("GET", "8080", "data/api/v1/get_iftype");
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        return view('inform.index', [
            'title' => 'ให้ข้อมูล', 'content' => 'content', 'select' => $paginatedItems,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'IFTYPE_ID' => 'required',
            'IFDATA_NAME' => 'required|string|max:250',
            'IFDATA_DETAILS' => 'required|max:500',
            'IFDATA_DATE' => 'string|nullable',
            'IFDATA_TIMES' => 'string|nullable',
            'IMAGE_NAME.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096|nullable',
            'PROVINCE_ID' => 'numeric|nullable',
            'DISTRICT_ID' => 'numeric|nullable',
            'SUB_DISTRICT_ID' => 'numeric|nullable',
            'IFDATA_PRICE' => 'string|nullable',
            'IFDATA_OPENTIME' => 'string|nullable',
            'IFDATA_CLOSETIME' => 'string|nullable',
            'IFDATA_LOCATION' => 'string|nullable',
            'IFDATA_LATITUDE' => 'string|nullable',
            'IFDATA_LONGITUDE' => 'string|nullable',
            'USER_FULLNAME' => 'string|max:150|nullable',
            'USER_EMAIL' => 'email|max:150|nullable',
            'USER_PHONENUMBER' => 'numeric|digits_between:0,50|nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $files = [];
        if ($request->hasfile('IMAGE_NAME')) {
            foreach ($request->file('IMAGE_NAME') as $file) {
                $name = $file->getClientOriginalName();
                $file->move(public_path() . '/files/', $name);
                $files[] = public_path('files/'.$name);

                // $new = ($image);
                // array_push($file, $request->file('IMAGE_NAME')[$key]->getPathName());
                // array_push($file,curl_file_create(public_path('assets/img/user.png'),'image/png','test_name'));
                // array_push($file, public_path('assets/img/user.png'));
                // array_push($file, "C:\Windows\Temp\php9CF3.jpg");
            }

        }

        $args = array(
            'IFTYPE_ID' => $request->IFTYPE_ID,
            'IFDATA_NAME' => $request->IFDATA_NAME,
            'IFDATA_DETAILS' => $request->IFDATA_DETAILS,
            'IFDATA_DATE' => ($request->IFDATA_DATE) ? date("Y-m-d", strtotime($request->IFDATA_DATE)) : null,
            'IFDATA_TIMES' => $request->IFDATA_TIMES,
            // 'IMAGE_NAME' => $request->IMAGE_NAME,
            'PROVINCE_ID' => $request->PROVINCE_ID,
            'DISTRICT_ID' => $request->DISTRICT_ID,
            'SUB_DISTRICT_ID' => $request->SUB_DISTRICT_ID,
            'IFDATA_PRICE' => $request->IFDATA_PRICE,
            'IFDATA_OPENTIME' => $request->IFDATA_OPENTIME,
            'IFDATA_CLOSETIME' => $request->IFDATA_CLOSETIME,
            'IFDATA_LOCATION' => $request->IFDATA_LOCATION,
            'IFDATA_LATITUDE' => $request->IFDATA_LATITUDE,
            'IFDATA_LONGITUDE' => $request->IFDATA_LONGITUDE,
            // 'USER_ID' => (\Cookie::get('mct_user_id') !== null) ? \Cookie::get('mct_user_id') : null,
            'USER_FULLNAME' => $request->USER_FULLNAME,
            'USER_EMAIL' => $request->USER_EMAIL,
            'USER_PHONE' => $request->USER_PHONENUMBER, // แปลง field ตาม m
        );
        // $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/inform/add", $args);
        $token = (\Cookie::get('mct_user_id') !== null) ? \Cookie::get('mct_user_id') : null;
        $arg = Myclass::buildMultiPartRequest("POST","8080","admin/api/v1/inform/add", $args, $files,$token);
        // dd($arg);
        // if ($arg->status === 403) {
        //     return redirect()->back()->withErrors($arg->message);
        // } elseif ($arg->status == true) {
        //     return redirect()->back()->with('status', $arg->description);
        // } else {
        //     return redirect()->back()->withErrors($arg->description);
        // }

        if ($arg->status) {
            return redirect()->back()->with('status', $arg->description);
        } else {
            return redirect()->back()->withErrors($arg->description);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
