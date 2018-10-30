<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mylibs\Myclass;
use Validator;

class KmFolkartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("GET", "8080", "folkarts/api/v1/list", [], $token);
        $data_object = [];
        if ($arg->status) {
            $data_object = $arg->data_object;
        }
        return view('knowledge.folkart_index', [
            'title' => 'จัดการข้อมูลองค์ความรู้ ศิลปะพื้นถิ่น',
            'header' => 'จัดการข้อมูลองค์ความรู้ ศิลปะพื้นถิ่น',
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
        return view('knowledge.folkart_create', [
            'title' => 'เพิ่ม ศิลปะพื้นถิ่น',
            'header' => 'เพิ่ม ศิลปะพื้นถิ่น'
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
            'folkart_name' => 'required|max:255',
            'about' => 'required|max:255',
            'history' => 'required',
            'content_url' => 'max:255',
            'folkart_img' => 'required',
            'link_video' => 'nullable|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = [];
        $files = [];
        if ($request->hasfile('folkart_img')) {
            $file = $request->file('folkart_img');
            $name = md5($file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/files/', $name);
            $files[] = public_path('files/' . $name);
        }

        $args = array(
            'folkart_name' => $request->folkart_name,
            'about' => $request->about,
            'history' => $request->history,
            'content_url' => $request->content_url,
            'link_video' => $request->link_video,
        );

        $token = \Cookie::get('mcul_token');
        $arg = Myclass::buildMultiPartRequest("POST", "8080", "folkarts/api/v1/add", $args, $files, $token);
        if ($arg->status) {
            $id = $arg->content_id;
            return redirect("/km/folkart/$id/edit")->with('status', 'สำเร็จ');
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
        $arg = Myclass::mculter_service("GET", "8080", "folkarts/api/v1/details/". $id, [], $token);
        $data_object = [];
        if ($arg->status) {
            $data_object = $arg->data_object;
        }
        return view('knowledge.folkart_edit', [
            'title' => 'แก้ไข ประเพณี',
            'header' => 'แก้ไข ประเพณี',
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
            'folkart_name' => 'required|max:255',
            'about' => 'required|max:255',
            'history' => 'required',
            'content_url' => 'max:255',
            'folkart_img' => 'nullable',
            'link_video' => 'nullable|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = [];
        $files = [];
        if ($request->hasfile('folkart_img')) {
            $file = $request->file('folkart_img');
            $name = md5($file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/files/', $name);
            $files[] = public_path('files/' . $name);
        }

        $args = array(
            'folkart_name' => $request->folkart_name,
            'about' => $request->about,
            'history' => $request->history,
            'content_url' => $request->content_url,
            'link_video' => $request->link_video,
            'content_id' => $id
        );

        $token = \Cookie::get('mcul_token');
        $arg = Myclass::buildMultiPartRequest("POST", "8080", "folkarts/api/v1/update", $args, $files, $token);
        if ($arg->status) {
            return redirect("/km/folkart/$id/edit")->with('status', 'อัพเดตสำเร็จ');
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
        $obj = Myclass::mculter_service("GET", "8080", "folkarts/api/v1/delete/".$id, ['' => ''], $token);
        return json_encode($obj);
    }
}
