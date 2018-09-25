<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;

class HilightController extends Controller
{
    public function index()
    {
        return view('hilight', [
            'title' => 'Hilight',
        ]);
    }

    public function res_hilight(Request $request)
    {
        $page = ($request->page) ? $request->page : 1;
        $query_string = ($request->query_string) ? $request->query_string : "";
        $field = array(
            "page" => $page, "query_string" => $query_string,
        );
        $arg = Myclass::mculter_service("POST", "8080", "data/api/v1/list_calendar", $field);
        // $data_object = [];
        // if ($arg->status) {
        //     $data_object = $arg->data_object;
        // }

        return response()->json($arg);
    }
}
