<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;

class KnowledgesController extends Controller
{
    public function index()
    {
        return view('knowledges', [
            'title' => 'Knowledges',
        ]);
    }

    public function res_knowledge(Request $request)
    {
        $know_id = ($request->know_id) ? $request->know_id : 1;
        $page = ($request->page) ? $request->page : 1;
        $query_string = ($request->query_string) ? $request->query_string : "";
        $path = "";
        switch ((int) $know_id) {
            case 1:
                $path = "list_rituals";
                break;
            case 2:
                $path = "list_tradition";
                break;
            case 3:
                $path = "list_folkart";
                break;
            case 4:
                $path = "list_thailitdir";
                break;
            default:
                $path = "list_rituals";
        }
        $field = array(
            "page" => $page, "query_string" => $query_string,
        );
        $arg = Myclass::mculter_service("POST", "8080", "data/api/v1/$path", $field);
        // $data_object = [];
        // if ($arg->status) {
        //     $data_object = $arg->data_object;
        // }

        return response()->json($arg);
    }
}
