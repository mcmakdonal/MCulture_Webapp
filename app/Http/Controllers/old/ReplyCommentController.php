<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;

class ReplyCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $args = array(
            'type_id' => $request->CMTYPE_ID,
            'REPLY_STATUS' => $request->REPLY_STATUS,
        );
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/comment/list", $args, $token);
        // dd($arg);
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        $arg = Myclass::mculter_service("GET", "8080", "data/api/v1/get_cmtype");
        $get_cmtype = [];
        if ($arg->status) {
            $get_cmtype = $arg->data_object;
        }

        return view('reply.comment', [
            'title' => 'ตอบกลับข้อมูลการ แนะนำ/ติชม',
            'header' => 'ตอบกลับข้อมูลการ แนะนำ/ติชม',
            'content' => $paginatedItems,
            'select' => $get_cmtype,
            'select_type' => $request->CMTYPE_ID,
            'reply_type' => $request->REPLY_STATUS,
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
        // read status
        $read = Myclass::mculter_service("GET", "8080", "admin/api/v1/comment/update_read/" . $id, ['' => ''], $token);
        if (!$read->status) {
            return redirect()->back()->withErrors($read->description);
        }
        $arg = [];
        $arg = Myclass::mculter_service("GET", "8080", "admin/api/v1/comment/details/" . $id, ['' => ''], $token);
        // dd($arg);
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        return view('reply.comment-reply', [
            'title' => 'ตอบกลับข้อมูลการ "ติชม"',
            'header' => 'ตอบกลับข้อมูลการ "ติชม"',
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
            'CMDATA_DETAILREPLY' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'cmdata_detail_reply' => $request->CMDATA_DETAILREPLY,
            'cmdata_id' => $id,
        );

        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/comment/reply", $args, $token);
        if ($arg->status) {
            $nof = Myclass::send_nofti(['device_token' => $request->device_token, 'message' => $request->CMDATA_DETAILREPLY]);
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
