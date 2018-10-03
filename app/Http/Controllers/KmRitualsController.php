<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;

class KmRitualsController extends Controller
{
    public function __construct()
    {
        $this->middleware('Mid_auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("GET", "8080", "rituals/api/v1/list", [], $token);
        $data_object = [];
        if ($arg->status) {
            $data_object = $arg->data_object;
        }
        return view('knowledge.rituals_index', [
            'title' => 'จัดการข้อมูลองค์ความรู้ ฐานข้อมูลประเพณีท้องถิ่น',
            'header' => 'จัดการข้อมูลองค์ความรู้ ฐานข้อมูลประเพณีท้องถิ่น',
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
        return view('knowledge.rituals_create', [
            'title' => 'เพิ่ม ฐานข้อมูลประเพณีท้องถิ่น',
            'header' => 'เพิ่ม ฐานข้อมูลประเพณีท้องถิ่น',
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
            'content_name' => 'required|max:255',
            'other_name' => 'required|max:255',
            'type' => 'required|max:255',
            'keyword' => 'required|max:255',
            'rituals_month' => 'required|max:255',
            'rituals_time' => 'required|max:255',
            'zone' => 'required|max:255',
            'location' => 'required|max:255',
            'content_url' => 'max:255',
            'content_img' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = [];
        $files = [];
        if ($request->hasfile('content_img')) {
            $file = $request->file('content_img');
            $name = md5($file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/files/', $name);
            $files[] = public_path('files/' . $name);
        }

        $args = array(
            'content_name' => $request->content_name,
            'other_name' => $request->other_name,
            'type' => $request->type,
            'keyword' => $request->keyword,
            'rituals_month' => $request->rituals_month,
            'rituals_time' => $request->rituals_time,
            'zone' => $request->zone,
            'content_url' => $request->content_url,
            'location' => $request->location,
        );

        $token = \Cookie::get('mcul_token');
        $arg = Myclass::buildMultiPartRequest("POST", "8080", "rituals/api/v1/add", $args, $files, $token);
        if ($arg->status) {
            $id = $arg->content_id;
            return redirect("/km/rituals/$id/edit")->with('status', 'Create Success');
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
        $arg = Myclass::mculter_service("GET", "8080", "rituals/api/v1/details/". $id, [], $token);
        $data_object = [];
        if ($arg->status) {
            $data_object = $arg->data_object;
        }
        return view('knowledge.rituals_edit', [
            'title' => 'แก้ไข ฐานข้อมูลประเพณีท้องถิ่น',
            'header' => 'แก้ไข ฐานข้อมูลประเพณีท้องถิ่น',
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
            'content_name' => 'required|max:255',
            'other_name' => 'required|max:255',
            'type' => 'required|max:255',
            'keyword' => 'required|max:255',
            'rituals_month' => 'required|max:255',
            'rituals_time' => 'required|max:255',
            'zone' => 'required|max:255',
            'location' => 'required|max:255',
            'content_url' => 'max:255',
            'content_img' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = [];
        $files = [];
        if ($request->hasfile('content_img')) {
            $file = $request->file('content_img');
            $name = md5($file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/files/', $name);
            $files[] = public_path('files/' . $name);
        }

        $args = array(
            'content_name' => $request->content_name,
            'other_name' => $request->other_name,
            'type' => $request->type,
            'keyword' => $request->keyword,
            'rituals_month' => $request->rituals_month,
            'rituals_time' => $request->rituals_time,
            'zone' => $request->zone,
            'content_url' => $request->content_url,
            'location' => $request->location,
            'content_id' => $id
        );

        $token = \Cookie::get('mcul_token');
        $arg = Myclass::buildMultiPartRequest("POST", "8080", "rituals/api/v1/update", $args, $files, $token);
        if ($arg->status) {
            return redirect("/km/rituals/$id/edit")->with('status', 'Update Success');
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
        $obj = Myclass::mculter_service("GET", "8080", "rituals/api/v1/delete/".$id, ['' => ''], $token);
        return json_encode($obj);
    }
}
