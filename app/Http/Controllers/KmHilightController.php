<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;

class KmHilightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("GET", "8080", "activity/api/v1/list", [], $token);
        $data_object = [];
        if ($arg->status) {
            $data_object = $arg->data_object;
        }
        return view('knowledge.hilight_index', [
            'title' => 'จัดการข้อมูล ไฮไลท์',
            'header' => 'จัดการข้อมูล ไฮไลท์',
            'data' => $data_object
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('knowledge.hilight_create', [
            'title' => 'เพิ่ม ไฮไลท์',
            'header' => 'เพิ่ม ไฮไลท์'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'activity_name' => 'required|max:255',
            'link_ref' => 'max:255',
            'start_date' => 'max:255',
            'start_time' => 'max:5',
            'end_time' => 'max:5',
            'activity_location' => 'max:255',
            'activity_details' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $start_date = "";
        $end_date = "";
        if ($request->datetime) {
            $date = explode(" - ", $request->datetime);
            $start_date = date("Y-m-d", strtotime($date[0]));
            $end_date = date("Y-m-d", strtotime($date[1]));
        }

        $args = [];
        $args = array(
            'activity_name' => $request->activity_name,
            'link_ref' => $request->link_ref,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'activity_location' => $request->activity_location,
            'activity_details' => $request->activity_details,
        );

        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("POST", "8080", "activity/api/v1/add", $args, $token);
        if ($arg->status) {
            return redirect('/km/hilight')->with('status', 'Create Success');
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
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("GET", "8080", "activity/api/v1/details/". $id, [], $token);
        $data_object = [];
        if ($arg->status) {
            $data_object = $arg->data_object;
        }
        return view('knowledge.hilight_edit', [
            'title' => 'แก้ไข ไฮไลท์',
            'header' => 'แก้ไข ไฮไลท์',
            'data' => $data_object,
            'id' => $id
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
        $validator = Validator::make($request->all(), [
            'activity_name' => 'required|max:255',
            'link_ref' => 'max:255',
            'start_date' => 'max:255',
            'start_time' => 'max:5',
            'end_time' => 'max:5',
            'activity_location' => 'max:255',
            'activity_details' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $start_date = "";
        $end_date = "";
        if ($request->datetime) {
            $date = explode(" - ", $request->datetime);
            $start_date = date("Y-m-d", strtotime($date[0]));
            $end_date = date("Y-m-d", strtotime($date[1]));
        }

        $args = [];
        $args = array(
            'activity_name' => $request->activity_name,
            'link_ref' => $request->link_ref,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'activity_location' => $request->activity_location,
            'activity_details' => $request->activity_details,
            'activity_id' => $id
        );

        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("POST", "8080", "activity/api/v1/update", $args, $token);
        if ($arg->status) {
            return redirect('/km/hilight')->with('status', 'Update Success');
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
        $token = \Cookie::get('mcul_token');
        $obj = Myclass::mculter_service("GET", "8080", "activity/api/v1/delete/".$id, ['' => ''], $token);
        return json_encode($obj);
    }
}
