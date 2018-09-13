<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;

class ReplyComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $args = array(
            'type_id' => $request->CPTYPE_ID,
            'REPLY_STATUS' => $request->REPLY_STATUS
        );
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/complaint/list", $args, $token);
        // dd($arg);
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        $arg = Myclass::mculter_service("GET", "8080", "data/api/v1/get_cptype");
        $get_cptype = [];
        if ($arg->status) {
            $get_cptype = $arg->data_object;
        }

        return view('reply.complaint', [
            'title' => 'ตอบกลับข้อมูลการ "ร้องเรียน"',
            'header' => 'ตอบกลับข้อมูลการ "ร้องเรียน"',
            'content' => $paginatedItems,
            'select' => $get_cptype,
            'select_type' => $request->CPTYPE_ID,
            'reply_type' => $request->REPLY_STATUS
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
        //
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
        $token = \Cookie::get('mcul_token');
        $read = Myclass::mculter_service("GET", "8080", "admin/api/v1/complaint/update_read/" . $id, ['' => ''], $token);
        if (!$read->status) {
            return redirect()->back()->withErrors($read->description);
        }
        $arg = [];
        $arg = Myclass::mculter_service("GET", "8080", "admin/api/v1/complaint/details/" . $id, ['' => ''], $token);
        dd($arg);
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        return view('reply.complaint-reply', [
            'title' => 'ตอบกลับข้อมูลการ "ร้องเรียน"',
            'header' => 'ตอบกลับข้อมูลการ "ร้องเรียน"',
            'content' => $paginatedItems,
        ]);
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
        // dd($request);
        $token = \Cookie::get('mcul_token');
        $validator = Validator::make($request->all(), [
            'CPDATA_DETAILREPLY' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'cpdata_detail_reply' => $request->CPDATA_DETAILREPLY,
            'cpdata_id' => $id,
        );

        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/complaint/reply", $args, $token);
        if ($arg->status) {
            $nof = Myclass::send_nofti(['device_token' => $request->device_token, 'message' => $request->CPDATA_DETAILREPLY]);
            if($nof){
                return redirect()->back()->with('status', 'Reply Success');
            }else{
                return redirect()->back()->with('status', 'Reply Success But Notification not send');
            }
        } else {
            return redirect()->back()->withErrors($arg->description);
        }
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
