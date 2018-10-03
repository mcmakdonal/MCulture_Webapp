<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mylibs\Myclass;
use Validator;

class KmTraditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("GET", "8080", "tradition/api/v1/list", [], $token);
        $data_object = [];
        if ($arg->status) {
            $data_object = $arg->data_object;
        }
        return view('knowledge.tradition_index', [
            'title' => 'จัดการข้อมูลองค์ความรู้ ประเพณี',
            'header' => 'จัดการข้อมูลองค์ความรู้ ประเพณี',
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
        return view('knowledge.tradition_create', [
            'title' => 'เพิ่ม ประเพณี',
            'header' => 'เพิ่ม ประเพณี',
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
            'article_name' => 'required|max:255',
            'about' => 'required|max:255',
            'event_date' => 'required|max:255',
            'location' => 'required|max:255',
            'history' => 'required',
            'content_url' => 'max:255',
            'article_img' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = [];
        $files = [];
        if ($request->hasfile('article_img')) {
            $file = $request->file('article_img');
            $name = md5($file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/files/', $name);
            $files[] = public_path('files/' . $name);
        }

        $args = array(
            'article_name' => $request->article_name,
            'about' => $request->about,
            'event_date' => $request->event_date,
            'history' => $request->history,
            'content_url' => $request->content_url,
            'location' => $request->location,
        );

        $token = \Cookie::get('mcul_token');
        $arg = Myclass::buildMultiPartRequest("POST", "8080", "tradition/api/v1/add", $args, $files, $token);
        if ($arg->status) {
            $id = $arg->content_id;
            return redirect("/km/tradition/$id/edit")->with('status', 'Create Success');
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
        $arg = Myclass::mculter_service("GET", "8080", "tradition/api/v1/details/". $id, [], $token);
        $data_object = [];
        if ($arg->status) {
            $data_object = $arg->data_object;
        }
        return view('knowledge.tradition_edit', [
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
            'article_name' => 'required|max:255',
            'about' => 'required|max:255',
            'event_date' => 'required|max:255',
            'location' => 'required|max:255',
            'history' => 'required',
            'content_url' => 'max:255',
            'article_img' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = [];
        $files = [];
        if ($request->hasfile('article_img')) {
            $file = $request->file('article_img');
            $name = md5($file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/files/', $name);
            $files[] = public_path('files/' . $name);
        }

        $args = array(
            'article_name' => $request->article_name,
            'about' => $request->about,
            'event_date' => $request->event_date,
            'history' => $request->history,
            'content_url' => $request->content_url,
            'location' => $request->location,
            'content_id' => $id
        );

        $token = \Cookie::get('mcul_token');
        $arg = Myclass::buildMultiPartRequest("POST", "8080", "tradition/api/v1/update", $args, $files, $token);
        if ($arg->status) {
            return redirect("/km/tradition/$id/edit")->with('status', 'Update Success');
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
        $obj = Myclass::mculter_service("GET", "8080", "tradition/api/v1/delete/".$id, ['' => ''], $token);
        return json_encode($obj);
    }
}
