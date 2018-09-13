<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;

class ComplaintformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_cptype = "";
        $get_mediatype = "";
        $arg = Myclass::mculter_service("GET", "8080", "data/api/v1/get_cptype");
        if ($arg->status) {
            $get_cptype = $arg->data_object;
        } else {
            return redirect('index')->with('status', "Can't read Data cptype");
        }

        $arg = Myclass::mculter_service("GET", "8080", "data/api/v1/get_mediatype");
        if ($arg->status) {
            $get_mediatype = $arg->data_object;
        } else {
            return redirect('index')->with('status', "Can't read Data mediatype");
        }

        return view('complaintform.index', [
            'title' => 'ร้องเรียน', 'content' => 'content', 'get_cptype' => $get_cptype, 'get_mediatype' => $get_mediatype,
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
            'CPTYPE_ID' => 'required',
            'CPDATA_NAME' => 'required|string|max:150',
            'CPDATA_DETAILS' => 'required|max:500',
            'CPDATA_STORENAME' => 'string|max:250|nullable',
            'IMAGE_NAME.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096|nullable',
            'CPMEDIATYPE_ID' => 'numeric|nullable',
            'PROVINCE_ID' => 'numeric|nullable',
            'DISTRICT_ID' => 'numeric|nullable',
            'SUB_DISTRICT_ID' => 'numeric|nullable',
            'CPDATA_LOCATION' => 'string|nullable',
            'CPDATA_LATITUDE' => 'string|nullable',
            'CPDATA_LONGITUDE' => 'string|nullable',
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
            'CPTYPE_ID' => $request->CPTYPE_ID,
            'CPDATA_NAME' => $request->CPDATA_NAME,
            'CPDATA_DETAILS' => $request->CPDATA_DETAILS,
            'CPDATA_STORENAME' => $request->CPDATA_STORENAME,
            // 'IMAGE_NAME' => $request->IMAGE_NAME,
            'CPMEDIA_TYPE_ID' => $request->CPMEDIATYPE_ID,
            'PROVINCE_ID' => $request->PROVINCE_ID,
            'DISTRICT_ID' => $request->DISTRICT_ID,
            'SUB_DISTRICT_ID' => $request->SUB_DISTRICT_ID,
            'CPDATA_LOCATION' => $request->CPDATA_LOCATION,
            'CPDATA_LATITUDE' => $request->CPDATA_LATITUDE,
            'CPDATA_LONGITUDE' => $request->CPDATA_LONGITUDE,
            // 'USER_ID' => (\Cookie::get('mct_user_id') !== null) ? \Cookie::get('mct_user_id') : null,
            'USER_FULLNAME' => $request->USER_FULLNAME,
            'USER_EMAIL' => $request->USER_EMAIL,
            'USER_PHONE' => $request->USER_PHONENUMBER, // แปลง field ตาม m
        );
        $token = (\Cookie::get('mct_user_id') !== null) ? \Cookie::get('mct_user_id') : null;
        $arg = Myclass::buildMultiPartRequest("POST","8080","admin/api/v1/complaint/add", $args, $files,$token);
        // dd($arg);
        // if ($arg->status == '403') {
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
