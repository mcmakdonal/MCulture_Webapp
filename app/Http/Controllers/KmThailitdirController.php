<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mylibs\Myclass;
use Validator;

class KmThailitdirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("GET", "8080", "thailitdir/api/v1/list", [], $token);
        $data_object = [];
        if ($arg->status) {
            $data_object = $arg->data_object;
        }
        return view('knowledge.thailitdir_index', [
            'title' => 'จัดการข้อมูลองค์ความรู้ ข้อมูลนามานุกรมวรรณคดีไทย',
            'header' => 'จัดการข้อมูลองค์ความรู้ ข้อมูลนามานุกรมวรรณคดีไทย',
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
        return view('knowledge.thailitdir_create', [
            'title' => 'เพิ่ม ข้อมูลนามานุกรมวรรณคดีไทย',
            'header' => 'เพิ่ม ข้อมูลนามานุกรมวรรณคดีไทย'
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
            'title_main' => 'required|max:255',
            'composition' => 'required|max:255',
            'composer' => 'required|max:255',
            'author' => 'required|max:255',
            'story' => 'required',
            'content_url' => 'max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = [];
        $args = array(
            'title_main' => $request->title_main,
            'composition' => $request->composition,
            'composer' => $request->composer,
            'author' => $request->author,
            'story' => $request->story,
            'content_url' => $request->content_url,
        );

        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("POST", "8080", "thailitdir/api/v1/add", $args, $token);
        if ($arg->status) {
            $id = $arg->content_id;
            return redirect("/km/thailitdir/$id/edit")->with('status', 'Create Success');
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
        $arg = Myclass::mculter_service("GET", "8080", "thailitdir/api/v1/details/". $id, [], $token);
        $data_object = [];
        if ($arg->status) {
            $data_object = $arg->data_object;
        }
        return view('knowledge.thailitdir_edit', [
            'title' => 'แก้ไข ข้อมูลนามานุกรมวรรณคดีไทย',
            'header' => 'แก้ไข ข้อมูลนามานุกรมวรรณคดีไทย',
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
            'title_main' => 'required|max:255',
            'composition' => 'required|max:255',
            'composer' => 'required|max:255',
            'author' => 'required|max:255',
            'story' => 'required',
            'content_url' => 'max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = [];
        $args = array(
            'title_main' => $request->title_main,
            'composition' => $request->composition,
            'composer' => $request->composer,
            'author' => $request->author,
            'story' => $request->story,
            'content_url' => $request->content_url,
            'content_id' => $id
        );

        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("POST", "8080", "thailitdir/api/v1/update", $args, $token);
        if ($arg->status) {
            return redirect("/km/thailitdir/$id/edit")->with('status', 'Update Success');
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
        $obj = Myclass::mculter_service("GET", "8080", "thailitdir/api/v1/delete/".$id, ['' => ''], $token);
        return json_encode($obj);
    }
}
