<?php

namespace App\Http\Controllers;

// use App\Exports\CollectionExport;

// เดิมๆใช้แค่ 2 ตัวนี้
// use App\Exports\MainExport;
// use Maatwebsite\Excel\Facades\Excel;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MakeReportController extends Controller
{
    // private $excel;

    public function __construct()
    {
        $this->middleware('Mid_auth');
    }    

    public function index()
    {
        $title = "";
        $read_status = "";
        $reply_status = "";
        $report_type = 1;
        $currentPath = Route::getFacadeRoot()->current()->uri();
        if ($currentPath == "admin/report-all") {
            $title = "เรื่องทั้งหมดที่ได้รับข้อมูลจากประชาชน (ทุกหัวข้อ)";
            $report_type = 1;
        } else if ($currentPath == "admin/report-replyed") {
            $title = "รายการทั้งหมดที่ตอบกลับแล้ว";
            $reply_status = "Y";
            $report_type = 2;
        } else if ($currentPath == "admin/report-unreply") {
            $title = "รายการที่ยังไม่ได้ตอบกลับ";
            $reply_status = "N";
            $report_type = 3;
        } else if ($currentPath == "admin/report-unread") {
            $title = "รายการที่ยังไม่ได้อ่าน";
            $read_status = "N";
            $report_type = 4;
        }

        return view('report.index', [
            'title' => $title,
            'header' => $title,
            'read_status' => $read_status,
            'reply_status' => $reply_status,
            'report_type' => $report_type,
        ]);
    }

    public function generate(Request $request)
    {
        $start_date = "";
        $end_date = "";
        $originalDate = "";
        $report_type = ($request->report_type == "") ? 1 : $request->report_type;
        if ($request->datetime) {
            $originalDate = $request->datetime;
            $date = explode(" - ", $request->datetime);
            $start_date = date("Y-m-d", strtotime($date[0]));
            $end_date = date("Y-m-d", strtotime($date[1]));
        }

        $args = [];
        if ($start_date != "" && $end_date != "") {
            $args['start_date'] = $start_date;
            $args['end_date'] = $end_date;
        }

        if ($request->read_status != "") {
            $args['read_status'] = $request->read_status;
        }

        if ($request->reply_status != "") {
            $args['reply_status'] = $request->reply_status;
        }

        $recommend = $this->get_all(1, $args);
        $complaint = $this->get_all(2, $args);
        $other = $this->get_all(3, $args);

        $array = [
            'recommend' => $recommend,
            'complaint' => $complaint,
            'other' => $other,
        ];

        $this->report($report_type, $array);
        // dd($recommend);
    }

    public function recommend()
    {
        return view('report.index-type', [
            'title' => "ข้อมูลการแนะนำ/ติชม ทั้งหมด",
            'header' => "ข้อมูลการแนะนำ/ติชม ทั้งหมด",
            'sub_type' => MyClass::mculter_service("get", "8080", "data/api/v1/get_subtype/1")->data_object,
        ]);
    }

    public function recommend_report(Request $request)
    {
        $file_name = "Report_All_Recommend_" . date("Y-m-d");
        $start_date = "";
        $end_date = "";
        $originalDate = "";
        if ($request->datetime) {
            $originalDate = $request->datetime;
            $date = explode(" - ", $request->datetime);
            $start_date = date("Y-m-d", strtotime($date[0]));
            $end_date = date("Y-m-d", strtotime($date[1]));
        }

        $args = [];
        if ($start_date != "" && $end_date != "") {
            $args['start_date'] = $start_date;
            $args['end_date'] = $end_date;
        }

        if ($request->id != "") {
            // sub_type_id
            $args['sub_type_id'] = $request->id;
        }

        $recommend = $this->get_all(1, $args);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', 'ประเภทหลัก')
            ->setCellValue('B1', 'ประเภทย่อย')
            ->setCellValue('C1', 'หัวข้อ')
            ->setCellValue('D1', 'รายละเอียด')
            ->setCellValue('E1', 'แหล่งข้อมูล')
            ->setCellValue('F1', 'หน่วยงาน')
            ->setCellValue('G1', 'ค่าเข้าชม')
            ->setCellValue('H1', 'วันทำการ')
            ->setCellValue('I1', 'วันที่เริ่ม')
            ->setCellValue('J1', 'วันที่สิ้นสุด')
            ->setCellValue('K1', 'เวลาเริ่ม')
            ->setCellValue('L1', 'เวลาสิ้นสุด')
            ->setCellValue('M1', 'อื่นๆ')
            ->setCellValue('N1', 'จังหวัด')
            ->setCellValue('O1', 'อำเภอ')
            ->setCellValue('P1', 'ตำบล')
            ->setCellValue('Q1', 'รูปภาพ')
            ->setCellValue('R1', 'ชื่อ-นามสกุลผู้แจ้ง')
            ->setCellValue('S1', 'อีเมล')
            ->setCellValue('T1', 'หมายเลขโทรศัพท์')
            ->setCellValue('U1', 'หมายเลขบัตรประจำตัวประชาชน')
            ->setCellValue('V1', 'รายละเอียดการตอบกลับ')
            ->setCellValue('W1', 'ตอบกลับโดย');

        $start = 2;
        foreach ($recommend as $key => $row) {

            $lineReply = $start;
            $lineImg = $start;
            $lineadmission = $start;
            $lineworkdate = $start;

            $spreadsheet->getActiveSheet()->setCellValue('A' . $start, ((array_key_exists("topic_main_type_name", $row)) ? $row->topic_main_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('B' . $start, ((array_key_exists("topic_sub_type_name", $row)) ? $row->topic_sub_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('C' . $start, ((array_key_exists("topic_title", $row)) ? $row->topic_title : ""));
            $spreadsheet->getActiveSheet()->setCellValue('D' . $start, ((array_key_exists("topic_details", $row)) ? $row->topic_details : ""));
            $spreadsheet->getActiveSheet()->setCellValue('E' . $start, ((array_key_exists("reference", $row)) ? $row->reference : ""));
            $spreadsheet->getActiveSheet()->setCellValue('F' . $start, ((array_key_exists("organize_name", $row)) ? $row->organize_name : ""));

            // ค่าเข้า
            if (array_key_exists('admission_fees', $row)) {
                foreach ($row->admission_fees as $k => $v) {
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $lineadmission, "กฏเกณฑ์ : " . $v->admission_fee_type_name . " ราคา : " . $v->admission_charge);
                    $lineadmission++;
                }
            } else {
                $spreadsheet->getActiveSheet()->setCellValue('G' . $start, "");
            }

            // วันทำการ
            if (array_key_exists('working_times', $row)) {
                foreach ($row->working_times as $k => $v) {
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $lineworkdate, "วันทำการ " . $v->working_start_date . " - " . $v->working_start_date . " เวลา " . $v->working_start_time . " " . $v->working_end_time);
                    $lineworkdate++;
                }
            } else {
                $spreadsheet->getActiveSheet()->setCellValue('H' . $start, "");
            }

            $spreadsheet->getActiveSheet()->setCellValue('I' . $start, ((array_key_exists("start_date", $row)) ? $row->start_date : ""));
            $spreadsheet->getActiveSheet()->setCellValue('J' . $start, ((array_key_exists("end_date", $row)) ? $row->end_date : ""));
            $spreadsheet->getActiveSheet()->setCellValue('K' . $start, ((array_key_exists("start_time", $row)) ? $row->start_time : ""));
            $spreadsheet->getActiveSheet()->setCellValue('L' . $start, ((array_key_exists("end_time", $row)) ? $row->end_time : ""));
            $spreadsheet->getActiveSheet()->setCellValue('M' . $start, ((array_key_exists("topic_remark", $row)) ? $row->topic_remark : ""));
            $spreadsheet->getActiveSheet()->setCellValue('N' . $start, ((array_key_exists("province_name", $row)) ? $row->province_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('O' . $start, ((array_key_exists("district_name", $row)) ? $row->district_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('P' . $start, ((array_key_exists("sub_district_name", $row)) ? $row->sub_district_name : ""));
            // รูป
            foreach ($row->files as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('Q' . $lineImg, $v->file_path);
                $lineImg++;
            }

            $spreadsheet->getActiveSheet()->setCellValue('R' . $start, ((array_key_exists("user_fullname", $row)) ? $row->user_fullname : ""));
            $spreadsheet->getActiveSheet()->setCellValue('S' . $start, ((array_key_exists("user_email", $row)) ? $row->user_email : ""));
            $spreadsheet->getActiveSheet()->setCellValue('T' . $start, ((array_key_exists("user_phone", $row)) ? $row->user_phone : ""));
            $spreadsheet->getActiveSheet()->setCellValue('U' . $start, ((array_key_exists("user_identification", $row)) ? $row->user_identification : ""));

            // ตอบกลับ
            foreach ($row->reply as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('V' . $lineReply, $v->reply_details);
                $spreadsheet->getActiveSheet()->setCellValue('W' . $lineReply, $v->reply_by_name);
                $lineReply++;
            }

            $start = max(array($lineReply, $lineImg, $lineadmission, $lineworkdate));
        }

        // style
        foreach (range('A', 'W') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        // $spreadsheet->getActiveSheet()->getStyle('U1')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
        $from = "A1"; // or any value
        $to = "W1"; // or any value
        $spreadsheet->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->setTitle('แนะนำ ติชม');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=$file_name");
        $writer->save("php://output");
    }

    public function complaint()
    {
        return view('report.index-type', [
            'title' => "ข้อมูลการร้องเรียน/ร้องทุกข์ ทั้งหมด",
            'header' => "ข้อมูลการร้องเรียน/ร้องทุกข์ ทั้งหมด",
            'sub_type' => MyClass::mculter_service("get", "8080", "data/api/v1/get_subtype/2")->data_object,
        ]);
    }

    public function complaint_report(Request $request)
    {
        $file_name = "Report_All_Complaint_" . date("Y-m-d");
        $start_date = "";
        $end_date = "";
        $originalDate = "";
        if ($request->datetime) {
            $originalDate = $request->datetime;
            $date = explode(" - ", $request->datetime);
            $start_date = date("Y-m-d", strtotime($date[0]));
            $end_date = date("Y-m-d", strtotime($date[1]));
        }

        $args = [];
        if ($start_date != "" && $end_date != "") {
            $args['start_date'] = $start_date;
            $args['end_date'] = $end_date;
        }

        if ($request->id != "") {
            // sub_type_id
            $args['sub_type_id'] = $request->id;
        }

        $complaint = $this->get_all(2, $args);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', 'ประเภทหลัก')
            ->setCellValue('B1', 'ประเภทย่อย')
            ->setCellValue('C1', 'หัวข้อ')
            ->setCellValue('D1', 'รายละเอียด')
            ->setCellValue('E1', 'หน่วยงาน')
            ->setCellValue('F1', 'ประเภทสื่อ')
            ->setCellValue('G1', 'สถานที่')
            ->setCellValue('H1', 'ละติจูด,ลองจิจูด')
            ->setCellValue('I1', 'ประเภทของร้าน')
            ->setCellValue('J1', 'ชื่อร้าน')
            ->setCellValue('K1', 'ประเภทศาสนา')
            ->setCellValue('L1', 'วันที่')
            ->setCellValue('M1', 'เวลา')
            ->setCellValue('N1', 'อื่นๆ')
            ->setCellValue('O1', 'จังหวัด')
            ->setCellValue('P1', 'อำเภอ')
            ->setCellValue('Q1', 'ตำบล')
            ->setCellValue('R1', 'รูปภาพ')
            ->setCellValue('S1', 'ชื่อ-นามสกุลผู้แจ้ง')
            ->setCellValue('T1', 'อีเมล')
            ->setCellValue('U1', 'หมายเลขโทรศัพท์')
            ->setCellValue('V1', 'หมายเลขบัตรประจำตัวประชาชน')
            ->setCellValue('W1', 'รายละเอียดการตอบกลับ')
            ->setCellValue('X1', 'ตอบกลับโดย');

        $start = 2;
        // $id = 1;
        foreach ($complaint as $key => $row) {

            $lineReply = $start;
            $lineImg = $start;
            $topic_latitude = "";
            $topic_longitude = "";
            if (array_key_exists("topic_latitude", $row)) {
                $topic_latitude = $row->topic_latitude;
            }
            if (array_key_exists("topic_longitude", $row)) {
                $topic_longitude = $row->topic_longitude;
            }

            $spreadsheet->getActiveSheet()->setCellValue('A' . $start, ((array_key_exists("topic_main_type_name", $row)) ? $row->topic_main_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('B' . $start, ((array_key_exists("topic_sub_type_name", $row)) ? $row->topic_sub_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('C' . $start, ((array_key_exists("topic_title", $row)) ? $row->topic_title : ""));
            $spreadsheet->getActiveSheet()->setCellValue('D' . $start, ((array_key_exists("topic_details", $row)) ? $row->topic_details : ""));
            $spreadsheet->getActiveSheet()->setCellValue('E' . $start, ((array_key_exists("organize_name", $row)) ? $row->organize_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('F' . $start, ((array_key_exists("media_type_name", $row)) ? $row->media_type_name : ""));

            $spreadsheet->getActiveSheet()->setCellValue('G' . $start, ((array_key_exists("topic_location", $row)) ? $row->topic_location : ""));
            $spreadsheet->getActiveSheet()->setCellValue('H' . $start, $topic_latitude . "," . $topic_longitude);

            $spreadsheet->getActiveSheet()->setCellValue('I' . $start, ((array_key_exists("commerce_type_name", $row)) ? $row->commerce_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('J' . $start, ((array_key_exists("business_name", $row)) ? $row->business_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('K' . $start, ((array_key_exists("religion_name", $row)) ? $row->religion_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('L' . $start, ((array_key_exists("start_time", $row)) ? $row->start_time : ""));
            $spreadsheet->getActiveSheet()->setCellValue('M' . $start, ((array_key_exists("end_time", $row)) ? $row->end_time : ""));
            $spreadsheet->getActiveSheet()->setCellValue('N' . $start, ((array_key_exists("topic_remark", $row)) ? $row->topic_remark : ""));
            $spreadsheet->getActiveSheet()->setCellValue('O' . $start, ((array_key_exists("province_name", $row)) ? $row->province_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('P' . $start, ((array_key_exists("district_name", $row)) ? $row->district_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('Q' . $start, ((array_key_exists("sub_district_name", $row)) ? $row->sub_district_name : ""));
            // รูป
            foreach ($row->files as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('R' . $lineImg, $v->file_path);
                $lineImg++;
            }

            $spreadsheet->getActiveSheet()->setCellValue('S' . $start, ((array_key_exists("user_fullname", $row)) ? $row->user_fullname : ""));
            $spreadsheet->getActiveSheet()->setCellValue('T' . $start, ((array_key_exists("user_email", $row)) ? $row->user_email : ""));
            $spreadsheet->getActiveSheet()->setCellValue('U' . $start, ((array_key_exists("user_phone", $row)) ? $row->user_phone : ""));
            $spreadsheet->getActiveSheet()->setCellValue('V' . $start, ((array_key_exists("user_identification", $row)) ? $row->user_identification : ""));
            // ตอบกลับ
            foreach ($row->reply as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('W' . $lineReply, $v->reply_details);
                $spreadsheet->getActiveSheet()->setCellValue('X' . $lineReply, $v->reply_by_name);
                $lineReply++;
            }

            $start = max(array($lineReply, $lineImg));
        }

        // style
        foreach (range('A', 'X') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $from = "A1"; // or any value
        $to = "X1"; // or any value
        $spreadsheet->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('ร้องเรียน ร้องทุกข์');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=$file_name");
        $writer->save("php://output");
    }

    public function other()
    {
        return view('report.index-type', [
            'title' => "ข้อมูลเรื่องอื่นๆทั้งหมด",
            'header' => "ข้อมูลเรื่องอื่นๆทั้งหมด",
            'sub_type' => MyClass::mculter_service("get", "8080", "data/api/v1/get_subtype/3")->data_object,
        ]);
    }

    public function other_report(Request $request)
    {
        $file_name = "Report_All_other_" . date("Y-m-d");
        $start_date = "";
        $end_date = "";
        $originalDate = "";
        if ($request->datetime) {
            $originalDate = $request->datetime;
            $date = explode(" - ", $request->datetime);
            $start_date = date("Y-m-d", strtotime($date[0]));
            $end_date = date("Y-m-d", strtotime($date[1]));
        }

        $args = [];
        if ($start_date != "" && $end_date != "") {
            $args['start_date'] = $start_date;
            $args['end_date'] = $end_date;
        }

        if ($request->id != "") {
            // sub_type_id
            $args['sub_type_id'] = $request->id;
        }

        $other = $this->get_all(3, $args);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', 'ประเภทหลัก')
            ->setCellValue('B1', 'ประเภทย่อย')
            ->setCellValue('C1', 'หัวข้อ')
            ->setCellValue('D1', 'รายละเอียด')
            ->setCellValue('E1', 'อื่นๆ')
            ->setCellValue('F1', 'รูปภาพ')
            ->setCellValue('G1', 'สถานที่')
            ->setCellValue('H1', 'ละติจูด,ลองจิจูด')
            ->setCellValue('I1', 'ชื่อ-นามสกุลผู้แจ้ง')
            ->setCellValue('J1', 'อีเมล')
            ->setCellValue('K1', 'หมายเลขโทรศัพท์')
            ->setCellValue('L1', 'หมายเลขบัตรประจำตัวประชาชน')
            ->setCellValue('M1', 'รายละเอียดการตอบกลับ')
            ->setCellValue('N1', 'ตอบกลับโดย');

        $start = 2;
        foreach ($other as $key => $row) {
            $lineReply = $start;
            $lineImg = $start;
            $topic_latitude = "";
            $topic_longitude = "";
            if (array_key_exists("topic_latitude", $row)) {
                $topic_latitude = $row->topic_latitude;
            }
            if (array_key_exists("topic_longitude", $row)) {
                $topic_longitude = $row->topic_longitude;
            }

            $spreadsheet->getActiveSheet()->setCellValue('A' . $start, ((array_key_exists("topic_main_type_name", $row)) ? $row->topic_main_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('B' . $start, ((array_key_exists("topic_sub_type_name", $row)) ? $row->topic_sub_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('C' . $start, ((array_key_exists("topic_title", $row)) ? $row->topic_title : ""));
            $spreadsheet->getActiveSheet()->setCellValue('D' . $start, ((array_key_exists("topic_details", $row)) ? $row->topic_details : ""));
            $spreadsheet->getActiveSheet()->setCellValue('E' . $start, ((array_key_exists("topic_remark", $row)) ? $row->topic_remark : ""));
            // รูป
            foreach ($row->files as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('F' . $lineImg, $v->file_path);
                $lineImg++;
            }
            $spreadsheet->getActiveSheet()->setCellValue('G' . $start, ((array_key_exists("topic_location", $row)) ? $row->topic_location : ""));
            $spreadsheet->getActiveSheet()->setCellValue('H' . $start, $topic_latitude . "," . $topic_longitude);

            $spreadsheet->getActiveSheet()->setCellValue('I' . $start, ((array_key_exists("user_fullname", $row)) ? $row->user_fullname : ""));
            $spreadsheet->getActiveSheet()->setCellValue('J' . $start, ((array_key_exists("user_email", $row)) ? $row->user_email : ""));
            $spreadsheet->getActiveSheet()->setCellValue('K' . $start, ((array_key_exists("user_phone", $row)) ? $row->user_phone : ""));
            $spreadsheet->getActiveSheet()->setCellValue('L' . $start, ((array_key_exists("user_identification", $row)) ? $row->user_identification : ""));
            // ตอบกลับ
            foreach ($row->reply as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('M' . $lineReply, $v->reply_details);
                $spreadsheet->getActiveSheet()->setCellValue('N' . $lineReply, $v->reply_by_name);
                $lineReply++;
            }

            $start = max(array($lineReply, $lineImg));
        }

        // style
        foreach (range('A', 'N') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $from = "A1"; // or any value
        $to = "N1"; // or any value
        $spreadsheet->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('อื่นๆ');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=$file_name");
        $writer->save("php://output");
    }

    public function get_all(int $id, array $args)
    {
        $token = \Cookie::get('mcul_token');
        $args['main_type_id'] = $id;
        $arg = Myclass::mculter_service("POST", "8080", "topic/api/v1/list", $args, $token);
        return $arg->data_object;
    }

    private function report(int $type, array $array)
    {
        $file_name = "";
        if ($type == 1) {
            $file_name = "Report_All_Message_" . date("Y-m-d");
        } elseif ($type == 2) {
            $file_name = "Report_All_Reply_" . date("Y-m-d");
        } elseif ($type == 3) {
            $file_name = "Report_All_Not_Reply_" . date("Y-m-d");
        } else {
            $file_name = "Report_Unread_Message_" . date("Y-m-d");
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // header
        $spreadsheet->getActiveSheet()
        // ->setCellValue('A1', 'No.')
            ->setCellValue('A1', 'ประเภทหลัก')
            ->setCellValue('B1', 'ประเภทย่อย')
            ->setCellValue('C1', 'หัวข้อ')
            ->setCellValue('D1', 'รายละเอียด')
            ->setCellValue('E1', 'แหล่งข้อมูล')
            ->setCellValue('F1', 'หน่วยงาน')
            ->setCellValue('G1', 'ค่าเข้าชม')
            ->setCellValue('H1', 'วันทำการ')
            ->setCellValue('I1', 'วันที่เริ่ม')
            ->setCellValue('J1', 'วันที่สิ้นสุด')
            ->setCellValue('K1', 'เวลาเริ่ม')
            ->setCellValue('L1', 'เวลาสิ้นสุด')
            ->setCellValue('M1', 'อื่นๆ')
            ->setCellValue('N1', 'จังหวัด')
            ->setCellValue('O1', 'อำเภอ')
            ->setCellValue('P1', 'ตำบล')
            ->setCellValue('Q1', 'รูปภาพ')
            ->setCellValue('R1', 'ชื่อ-นามสกุลผู้แจ้ง')
            ->setCellValue('S1', 'อีเมล')
            ->setCellValue('T1', 'หมายเลขโทรศัพท์')
            ->setCellValue('U1', 'หมายเลขบัตรประจำตัวประชาชน')
            ->setCellValue('V1', 'รายละเอียดการตอบกลับ')
            ->setCellValue('W1', 'ตอบกลับโดย');

        // cell value
        $start = 2;
        // $id = 1;
        foreach ($array['recommend'] as $key => $row) {
            // $line = $key + 1;
            // $spreadsheet->getActiveSheet()->setCellValue('A' .$start, $id);

            $lineReply = $start;
            $lineImg = $start;
            $lineadmission = $start;
            $lineworkdate = $start;

            $spreadsheet->getActiveSheet()->setCellValue('A' . $start, ((array_key_exists("topic_main_type_name", $row)) ? $row->topic_main_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('B' . $start, ((array_key_exists("topic_sub_type_name", $row)) ? $row->topic_sub_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('C' . $start, ((array_key_exists("topic_title", $row)) ? $row->topic_title : ""));
            $spreadsheet->getActiveSheet()->setCellValue('D' . $start, ((array_key_exists("topic_details", $row)) ? $row->topic_details : ""));
            $spreadsheet->getActiveSheet()->setCellValue('E' . $start, ((array_key_exists("reference", $row)) ? $row->reference : ""));
            $spreadsheet->getActiveSheet()->setCellValue('F' . $start, ((array_key_exists("organize_name", $row)) ? $row->organize_name : ""));

            // ค่าเข้า
            if (array_key_exists('admission_fees', $row)) {
                foreach ($row->admission_fees as $k => $v) {
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $lineadmission, "กฏเกณฑ์ : " . $v->admission_fee_type_name . " ราคา : " . $v->admission_charge);
                    $lineadmission++;
                }
            } else {
                $spreadsheet->getActiveSheet()->setCellValue('G' . $start, "");
            }

            // วันทำการ
            if (array_key_exists('working_times', $row)) {
                foreach ($row->working_times as $k => $v) {
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $lineworkdate, "วันทำการ " . $v->working_start_date . " - " . $v->working_start_date . " เวลา " . $v->working_start_time . " " . $v->working_end_time);
                    $lineworkdate++;
                }
            } else {
                $spreadsheet->getActiveSheet()->setCellValue('H' . $start, "");
            }

            $spreadsheet->getActiveSheet()->setCellValue('I' . $start, ((array_key_exists("start_date", $row)) ? $row->start_date : ""));
            $spreadsheet->getActiveSheet()->setCellValue('J' . $start, ((array_key_exists("end_date", $row)) ? $row->end_date : ""));
            $spreadsheet->getActiveSheet()->setCellValue('K' . $start, ((array_key_exists("start_time", $row)) ? $row->start_time : ""));
            $spreadsheet->getActiveSheet()->setCellValue('L' . $start, ((array_key_exists("end_time", $row)) ? $row->end_time : ""));
            $spreadsheet->getActiveSheet()->setCellValue('M' . $start, ((array_key_exists("topic_remark", $row)) ? $row->topic_remark : ""));
            $spreadsheet->getActiveSheet()->setCellValue('N' . $start, ((array_key_exists("province_name", $row)) ? $row->province_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('O' . $start, ((array_key_exists("district_name", $row)) ? $row->district_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('P' . $start, ((array_key_exists("sub_district_name", $row)) ? $row->sub_district_name : ""));
            // รูป
            foreach ($row->files as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('Q' . $lineImg, $v->file_path);
                $lineImg++;
            }

            $spreadsheet->getActiveSheet()->setCellValue('R' . $start, ((array_key_exists("user_fullname", $row)) ? $row->user_fullname : ""));
            $spreadsheet->getActiveSheet()->setCellValue('S' . $start, ((array_key_exists("user_email", $row)) ? $row->user_email : ""));
            $spreadsheet->getActiveSheet()->setCellValue('T' . $start, ((array_key_exists("user_phone", $row)) ? $row->user_phone : ""));
            $spreadsheet->getActiveSheet()->setCellValue('U' . $start, ((array_key_exists("user_identification", $row)) ? $row->user_identification : ""));

            // ตอบกลับ
            foreach ($row->reply as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('V' . $lineReply, $v->reply_details);
                $spreadsheet->getActiveSheet()->setCellValue('W' . $lineReply, $v->reply_by_name);
                $lineReply++;
            }

            $start = max(array($lineReply, $lineImg, $lineadmission, $lineworkdate));
        }

        // style
        foreach (range('A', 'W') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $from = "A1"; // or any value
        $to = "W1"; // or any value
        $spreadsheet->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->setTitle('แนะนำ ติชม');

        ///////////////////////////////////////////////////////////

        $spreadsheet->createSheet();

        // Add some data
        $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A1', 'ประเภทหลัก')
            ->setCellValue('B1', 'ประเภทย่อย')
            ->setCellValue('C1', 'หัวข้อ')
            ->setCellValue('D1', 'รายละเอียด')
            ->setCellValue('E1', 'หน่วยงาน')
            ->setCellValue('F1', 'ประเภทสื่อ')
            ->setCellValue('G1', 'สถานที่')
            ->setCellValue('H1', 'ละติจูด,ลองจิจูด')
            ->setCellValue('I1', 'ประเภทของร้าน')
            ->setCellValue('J1', 'ชื่อร้าน')
            ->setCellValue('K1', 'ประเภทศาสนา')
            ->setCellValue('L1', 'วันที่')
            ->setCellValue('M1', 'เวลา')
            ->setCellValue('N1', 'อื่นๆ')
            ->setCellValue('O1', 'จังหวัด')
            ->setCellValue('P1', 'อำเภอ')
            ->setCellValue('Q1', 'ตำบล')
            ->setCellValue('R1', 'รูปภาพ')
            ->setCellValue('S1', 'ชื่อ-นามสกุลผู้แจ้ง')
            ->setCellValue('T1', 'อีเมล')
            ->setCellValue('U1', 'หมายเลขโทรศัพท์')
            ->setCellValue('V1', 'หมายเลขบัตรประจำตัวประชาชน')
            ->setCellValue('W1', 'รายละเอียดการตอบกลับ')
            ->setCellValue('X1', 'ตอบกลับโดย');

        $start = 2;
        // $id = 1;
        foreach ($array['complaint'] as $key => $row) {
            // $line = $key + 1;
            // $spreadsheet->getActiveSheet()->setCellValue('A' .$start, $id);
            $lineReply = $start;
            $lineImg = $start;
            $topic_latitude = "";
            $topic_longitude = "";
            if (array_key_exists("topic_latitude", $row)) {
                $topic_latitude = $row->topic_latitude;
            }
            if (array_key_exists("topic_longitude", $row)) {
                $topic_longitude = $row->topic_longitude;
            }

            $spreadsheet->getActiveSheet()->setCellValue('A' . $start, ((array_key_exists("topic_main_type_name", $row)) ? $row->topic_main_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('B' . $start, ((array_key_exists("topic_sub_type_name", $row)) ? $row->topic_sub_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('C' . $start, ((array_key_exists("topic_title", $row)) ? $row->topic_title : ""));
            $spreadsheet->getActiveSheet()->setCellValue('D' . $start, ((array_key_exists("topic_details", $row)) ? $row->topic_details : ""));
            $spreadsheet->getActiveSheet()->setCellValue('E' . $start, ((array_key_exists("organize_name", $row)) ? $row->organize_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('F' . $start, ((array_key_exists("media_type_name", $row)) ? $row->media_type_name : ""));

            $spreadsheet->getActiveSheet()->setCellValue('G' . $start, ((array_key_exists("topic_location", $row)) ? $row->topic_location : ""));
            $spreadsheet->getActiveSheet()->setCellValue('H' . $start, $topic_latitude . "," . $topic_longitude);

            $spreadsheet->getActiveSheet()->setCellValue('I' . $start, ((array_key_exists("commerce_type_name", $row)) ? $row->commerce_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('J' . $start, ((array_key_exists("business_name", $row)) ? $row->business_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('K' . $start, ((array_key_exists("religion_name", $row)) ? $row->religion_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('L' . $start, ((array_key_exists("start_time", $row)) ? $row->start_time : ""));
            $spreadsheet->getActiveSheet()->setCellValue('M' . $start, ((array_key_exists("end_time", $row)) ? $row->end_time : ""));
            $spreadsheet->getActiveSheet()->setCellValue('N' . $start, ((array_key_exists("topic_remark", $row)) ? $row->topic_remark : ""));
            $spreadsheet->getActiveSheet()->setCellValue('O' . $start, ((array_key_exists("province_name", $row)) ? $row->province_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('P' . $start, ((array_key_exists("district_name", $row)) ? $row->district_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('Q' . $start, ((array_key_exists("sub_district_name", $row)) ? $row->sub_district_name : ""));
            // รูป
            foreach ($row->files as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('R' . $lineImg, $v->file_path);
                $lineImg++;
            }

            $spreadsheet->getActiveSheet()->setCellValue('S' . $start, ((array_key_exists("user_fullname", $row)) ? $row->user_fullname : ""));
            $spreadsheet->getActiveSheet()->setCellValue('T' . $start, ((array_key_exists("user_email", $row)) ? $row->user_email : ""));
            $spreadsheet->getActiveSheet()->setCellValue('U' . $start, ((array_key_exists("user_phone", $row)) ? $row->user_phone : ""));
            $spreadsheet->getActiveSheet()->setCellValue('V' . $start, ((array_key_exists("user_identification", $row)) ? $row->user_identification : ""));
            // ตอบกลับ
            foreach ($row->reply as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('W' . $lineReply, $v->reply_details);
                $spreadsheet->getActiveSheet()->setCellValue('X' . $lineReply, $v->reply_by_name);
                $lineReply++;
            }

            $start = max(array($lineReply, $lineImg));
        }

        // style
        foreach (range('A', 'X') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $from = "A1"; // or any value
        $to = "X1"; // or any value
        $spreadsheet->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('ร้องเรียน ร้องทุกข์');

        /////////////////////////////////////////////////////////////

        $spreadsheet->createSheet();

        // Add some data
        $spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('A1', 'ประเภทหลัก')
            ->setCellValue('B1', 'ประเภทย่อย')
            ->setCellValue('C1', 'หัวข้อ')
            ->setCellValue('D1', 'รายละเอียด')
            ->setCellValue('E1', 'อื่นๆ')
            ->setCellValue('F1', 'รูปภาพ')
            ->setCellValue('G1', 'สถานที่')
            ->setCellValue('H1', 'ละติจูด,ลองจิจูด')
            ->setCellValue('I1', 'ชื่อ-นามสกุลผู้แจ้ง')
            ->setCellValue('J1', 'อีเมล')
            ->setCellValue('K1', 'หมายเลขโทรศัพท์')
            ->setCellValue('L1', 'หมายเลขบัตรประจำตัวประชาชน')
            ->setCellValue('M1', 'รายละเอียดการตอบกลับ')
            ->setCellValue('N1', 'ตอบกลับโดย');

        $start = 2;
        // $id = 1;
        foreach ($array['other'] as $key => $row) {
            // $line = $key + 1;
            // $spreadsheet->getActiveSheet()->setCellValue('A' .$start, $id);
            $lineReply = $start;
            $lineImg = $start;
            $topic_latitude = "";
            $topic_longitude = "";
            if (array_key_exists("topic_latitude", $row)) {
                $topic_latitude = $row->topic_latitude;
            }
            if (array_key_exists("topic_longitude", $row)) {
                $topic_longitude = $row->topic_longitude;
            }

            $spreadsheet->getActiveSheet()->setCellValue('A' . $start, ((array_key_exists("topic_main_type_name", $row)) ? $row->topic_main_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('B' . $start, ((array_key_exists("topic_sub_type_name", $row)) ? $row->topic_sub_type_name : ""));
            $spreadsheet->getActiveSheet()->setCellValue('C' . $start, ((array_key_exists("topic_title", $row)) ? $row->topic_title : ""));
            $spreadsheet->getActiveSheet()->setCellValue('D' . $start, ((array_key_exists("topic_details", $row)) ? $row->topic_details : ""));
            $spreadsheet->getActiveSheet()->setCellValue('E' . $start, ((array_key_exists("topic_remark", $row)) ? $row->topic_remark : ""));
            // รูป
            foreach ($row->files as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('F' . $lineImg, $v->file_path);
                $lineImg++;
            }
            $spreadsheet->getActiveSheet()->setCellValue('G' . $start, ((array_key_exists("topic_location", $row)) ? $row->topic_location : ""));
            $spreadsheet->getActiveSheet()->setCellValue('H' . $start, $topic_latitude . "," . $topic_longitude);

            $spreadsheet->getActiveSheet()->setCellValue('I' . $start, ((array_key_exists("user_fullname", $row)) ? $row->user_fullname : ""));
            $spreadsheet->getActiveSheet()->setCellValue('J' . $start, ((array_key_exists("user_email", $row)) ? $row->user_email : ""));
            $spreadsheet->getActiveSheet()->setCellValue('K' . $start, ((array_key_exists("user_phone", $row)) ? $row->user_phone : ""));
            $spreadsheet->getActiveSheet()->setCellValue('L' . $start, ((array_key_exists("user_identification", $row)) ? $row->user_identification : ""));
            // ตอบกลับ
            foreach ($row->reply as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('M' . $lineReply, $v->reply_details);
                $spreadsheet->getActiveSheet()->setCellValue('N' . $lineReply, $v->reply_by_name);
                $lineReply++;
            }

            $start = max(array($lineReply, $lineImg));
        }

        // style
        foreach (range('A', 'N') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $from = "A1"; // or any value
        $to = "N1"; // or any value
        $spreadsheet->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('อื่นๆ');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=$file_name");
        $writer->save("php://output");
    }
}
