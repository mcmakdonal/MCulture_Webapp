<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;

class CommentformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arg = Myclass::mculter_service("GET", "8080", "data/api/v1/get_cmtype");
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        return view('commentform.index', [
            'title' => 'ติชม', 'content' => 'content', 'select' => $paginatedItems,
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
            'CMTYPE_ID' => 'required',
            'CMDATA_NAME' => 'required|string|max:150',
            'CMDATA_DETAILS' => 'required|max:150',
            'CMDATA_PERSONNAME' => 'required|max:150',
            'USER_FULLNAME' => 'max:150|nullable',
            'USER_EMAIL' => 'email|max:150|nullable',
            'USER_PHONENUMBER' => 'numeric|digits_between:0,50|nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'CMTYPE_ID' => $request->CMTYPE_ID,
            'CMDATA_NAME' => $request->CMDATA_NAME,
            'CMDATA_DETAILS' => $request->CMDATA_DETAILS,
            'CMDATA_PERSON_NAME' => $request->CMDATA_PERSONNAME, // แปลง field ตาม m
            // 'USER_ID' => (\Cookie::get('mct_user_id') !== null) ? \Cookie::get('mct_user_id') : null,
            'USER_FULLNAME' => $request->USER_FULLNAME,
            'USER_EMAIL' => $request->USER_EMAIL,
            'USER_PHONE' => $request->USER_PHONENUMBER, // แปลง field ตาม m
        );
        $token = (\Cookie::get('mct_user_id') !== null) ? \Cookie::get('mct_user_id') : null;
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/comment/add", $args,$token );
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
