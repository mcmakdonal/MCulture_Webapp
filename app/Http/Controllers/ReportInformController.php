<?php

namespace App\Http\Controllers;
use App\Mylibs\Myclass;

use Illuminate\Http\Request;

class ReportInformController extends Controller
{

    public function index()
    {

    }

    public function inform(Request $request)
    {
        $start_date = "";
        $end_date = "";
        $IFTYPE_ID = $request->IFTYPE_ID;
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
                'type_id' => $IFTYPE_ID,
            );
        } else {
            $args = array(
                'start_date' => $start_date,
                'end_date' => $end_date,
                'type_id' => $IFTYPE_ID,
            );
        }
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/inform/list", $args, $token);
        // dd($arg);
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        $arg = Myclass::mculter_service("GET", "8080", "data/api/v1/get_iftype");
        $get_iftype = [];
        if ($arg->status) {
            $get_iftype = $arg->data_object;
        }

        return view('report.inform', [
            'title' => 'Report ข้อมูลการ "ให้ข้อมูล" ทั้งหมด',
            'header' => 'Report ข้อมูลการ "ให้ข้อมูล" ทั้งหมด',
            'content' => $paginatedItems,
            'datetime' => $originalDate,
            'select' => $get_iftype,
            'select_type' => $IFTYPE_ID
        ]);
    }
}
