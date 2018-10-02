<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;

class AdministratorController extends Controller
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
    public function index(Request $request)
    {
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("GET", "8080", "admin/api/v1/list_user", [], $token);
        $data_object = [];
        if ($arg->status) {
            $data_object = $arg->data_object;
            // $items = $arg->data_object;
            // $currentPage = LengthAwarePaginator::resolveCurrentPage();
            // $itemCollection = collect($items);
            // $perPage = 1;
            // $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            // $paginatedItems = new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            // $paginatedItems->setPath($request->url());
        }

        return view('administrator.index', [
            'title' => 'Administrator', 'header' => 'Administrator', 'content' => $data_object,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrator.create', [
            'title' => 'Administrator', 'header' => 'Administrator Create', 'content' => '',
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
            'ADMIN_FULLNAME' => 'required|max:150',
            'ADMIN_USERNAME' => 'required|max:150',
            'ADMIN_PASSWORD' => 'required|max:150',
            'C_ADMIN_PASSWORD' => 'required|max:150',
            'role' => 'required|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->ADMIN_PASSWORD != $request->C_ADMIN_PASSWORD) {
            return redirect()->back()->withErrors("Password and Confirm Password Not Macth");
        }
        $args = array(
            'fullname' => $request->ADMIN_FULLNAME,
            'username' => $request->ADMIN_USERNAME,
            'password' => $request->ADMIN_PASSWORD,
            'role' => $request->role
        );
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/add_user", $args, $token);
        if ($arg->status) {
            return redirect('/admin/administrator/' . $arg->user_id . '/edit')->with('status', 'Create Success');
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
        $content = [];
        $arg = Myclass::mculter_service("GET", "8080", "admin/api/v1/uid/" . $id, [], $token);
        if ($arg->status) {
            $content = $arg->data_object;
        } else {
            return redirect('/admin/administrator')->withErrors("Can't read user data");
        }

        return view('administrator.edit', [
            'title' => 'Administrator', 'header' => 'Administrator Edit', 'content' => $content,
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
            'ADMIN_FULLNAME' => 'required|max:150',
            'ADMIN_PASSWORD' => 'max:150',
            'C_ADMIN_PASSWORD' => 'max:150',
            'role' => 'required|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->ADMIN_PASSWORD != $request->C_ADMIN_PASSWORD) {
            return redirect()->back()->withErrors("Password and Confirm Password Not Macth");
        }

        $args = array(
            'fullname' => $request->ADMIN_FULLNAME,
            'password' => ($request->ADMIN_PASSWORD == "") ? $request->ADMIN_PASSWORD_OLD : $request->ADMIN_PASSWORD,
            'user_id' => $id,
            'role' => $request->role
        );
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/update_user", $args, $token);
        if ($arg->status) {
            return redirect()->back()->with('status', 'Update Success');
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
        $args = array(
            'user_id' => $id,
        );
        $token = \Cookie::get('mcul_token');
        $obj = Myclass::mculter_service("POST", "8080", "admin/api/v1/delete_user", $args, $token);
        return json_encode($obj);
    }
}
