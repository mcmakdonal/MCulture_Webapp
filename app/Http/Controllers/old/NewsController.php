<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $page = 1;
        $arg = Myclass::mculter_service("GET", "8080", "data/api/v1/get_calendar/".$page);
        $paginatedItems = [];
        $total = 0;
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
            $total = $arg->total;
        }

        return view('news.index', [
            'title' => 'ข้อมูลข่าวสาร', 'content' => $paginatedItems, 'total' => $total, 'page' => $page
        ]);
    }

    public function change_page(Request $request)
    {
        $page = $request->page;
        $arg = Myclass::mculter_service("GET", "8080", "data/api/v1/get_calendar/" . $page);

        return response()->json($arg);
    }
}
