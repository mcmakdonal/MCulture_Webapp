<?php

namespace App\Http\Controllers;
use App\Mylibs\Myclass;

use Illuminate\Http\Request;

class ReportComplaintController extends Controller
{
    //
    public function complaint(Request $request)
    {
        $start_date = "";
        $end_date = "";
        $CPTYPE_ID = $request->CPTYPE_ID;
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
                'type_id' => $CPTYPE_ID,
            );
        } else {
            $args = array(
                'start_date' => $start_date,
                'end_date' => $end_date,
                'type_id' => $CPTYPE_ID,
            );
        }
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/complaint/list", $args, $token);
        // dd($arg);
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        $arg = Myclass::mculter_service("GET", "8080", "data/api/v1/get_cptype");
        $get_cptype = [];
        if ($arg->status) {
            $get_cptype = $arg->data_object;
        }

        return view('report.complaint', [
            'title' => 'Report ข้อมูลการ "ร้องเรียน" ทั้งหมด',
            'header' => 'Report ข้อมูลการ "ร้องเรียน" ทั้งหมด',
            'content' => $paginatedItems,
            'datetime' => $originalDate,
            'select' => $get_cptype,
            'select_type' => $CPTYPE_ID,
        ]);
    }
}
