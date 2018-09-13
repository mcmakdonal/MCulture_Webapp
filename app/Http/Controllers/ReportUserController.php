<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;

class ReportUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('Mid_auth');
    }

    public function index()
    {

    }

    public function user_fb(Request $request)
    {
        $start_date = "";
        $end_date = "";
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
                'user_type' => 'M',
            );
        } else {
            $args = array(
                'user_type' => 'M',
                'start_date' => $start_date,
                'end_date' => $end_date,
            );
        }

        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/report/user", $args, $token);
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        // dd($paginatedItems);
        return view('report.users', [
            'title' => 'Report รายชื่อและข้อมูลผู้ที่เข้าสู่ระบบด้วย Facebook',
            'header' => 'Report รายชื่อและข้อมูลผู้ที่เข้าสู่ระบบด้วย Facebook',
            'content' => $paginatedItems,
            'datetime' => $originalDate,
        ]);
    }

    public function user_nm(Request $request)
    {
        $start_date = "";
        $end_date = "";
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
                'user_type' => 'N',
            );
        } else {
            $args = array(
                'user_type' => 'N',
                'start_date' => $start_date,
                'end_date' => $end_date,
            );
        }

        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/report/user", $args, $token);
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        return view('report.users', [
            'title' => 'Report รายชื่อข้อมูลผู้ที่ส่งเรื่องทั้งหมด (แบบไม่ได้ Login ด้วย Facebook)',
            'header' => 'Report รายชื่อข้อมูลผู้ที่ส่งเรื่องทั้งหมด (แบบไม่ได้ Login ด้วย Facebook)',
            'content' => $paginatedItems,
            'datetime' => $originalDate,
        ]);
    }

}
