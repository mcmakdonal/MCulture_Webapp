<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;

class ReportCommentController extends Controller
{
    public function index()
    {

    }

    public function comment(Request $request)
    {
        $start_date = "";
        $end_date = "";
        $CMTYPE_ID = $request->CMTYPE_ID;
        $originalDate = "";
        if ($request->DATETIME) {
            $originalDate = $request->DATETIME;
            $date = explode(" - ", $request->DATETIME);
            $start_date = date("Y-m-d", strtotime($date[0]));
            $end_date = date("Y-m-d", strtotime($date[1]));
        }

        $args = [];
        if ($start_date == "" && $end_date == "") {
            $args = array(
                'type_id' => $CMTYPE_ID,
            );
        } else {
            $args = array(
                'start_date' => $start_date,
                'end_date' => $end_date,
                'type_id' => $CMTYPE_ID,
            );
        }
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

        return view('report.comment', [
            'title' => 'Report ข้อมูลการ "ติชม" ทั้งหมด',
            'header' => 'Report ข้อมูลการ "ติชม" ทั้งหมด',
            'content' => $paginatedItems,
            'datetime' => $originalDate,
            'select' => $get_cmtype,
            'select_type' => $CMTYPE_ID
        ]);
    }
}
