<?php

namespace App\Http\Controllers;

// use App\Exports\CollectionExport;

// เดิมๆใช้แค่ 2 ตัวนี้
// use App\Exports\MainExport;
// use Maatwebsite\Excel\Facades\Excel;

use App\Mylibs\Myclass;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MakeReportController extends Controller
{
    // private $excel;

    // public function __construct(Excel $excel)
    // {
    //     $this->excel = $excel;
    // }

    public function report(int $type = 1)
    {
        if ($type == 1) {
            $file_name = "รายงาน_เรื่องทั้งหมดที่ได้รับข้อมูลจากประชาชน_ทุกหัวข้อ_" . date("Y-m-d");
            $comment = $this->comemnt();
            $complaint = $this->complaint();
            $inform = $this->inform();
        } elseif ($type == 2) {
            $file_name = "รายงาน_รายการทั้งหมดที่ตอบกลับแล้ว_" . date("Y-m-d");
            $comment = $this->comemnt("A");
            $complaint = $this->complaint("A");
            $inform = $this->inform("A");
        } elseif ($type == 3) {
            $file_name = "รายงาน_รายการที่ยังไม่ได้ตอบกลับ_" . date("Y-m-d");
            $comment = $this->comemnt("N");
            $complaint = $this->complaint("N");
            $inform = $this->inform("N");
        } else {
            $file_name = "รายงาน_รายการที่ยังไม่ได้อ่าน_" . date("Y-m-d");
            $comment = $this->comemnt("", "N");
            $complaint = $this->complaint("", "N");
            $inform = $this->inform("", "N");
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // header
        $spreadsheet->getActiveSheet()
        // ->setCellValue('A1', 'No.')
            ->setCellValue('A1', 'ชื่อประเภทการติชม')
            ->setCellValue('B1', 'ชื่อหัวข้อการติชม')
            ->setCellValue('C1', 'รายละเอียดการติชม')
            ->setCellValue('D1', 'ชื่อบุคลากร')
            ->setCellValue('E1', 'ชื่อ-นามสกุลผู้แจ้ง')
            ->setCellValue('F1', 'อีเมล')
            ->setCellValue('G1', 'หมายเลขโทรศัพท์')
            ->setCellValue('H1', 'รายละเอียดการตอบกลับ')
            ->setCellValue('I1', 'ตอบกลับโดย');

        // cell value
        $start = 2;
        // $id = 1;
        foreach ($comment as $key => $row) {
            // $line = $key + 1;
            // $spreadsheet->getActiveSheet()->setCellValue('A' .$start, $id);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $start, $row->cmtype_name);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $start, $row->cmdata_name);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $start, $row->cmdata_details);
            $spreadsheet->getActiveSheet()->setCellValue('D' . $start, $row->cmdata_personname);
            $spreadsheet->getActiveSheet()->setCellValue('E' . $start, $row->user_fullname);
            $spreadsheet->getActiveSheet()->setCellValue('F' . $start, $row->user_email);
            $spreadsheet->getActiveSheet()->setCellValue('G' . $start, $row->user_phonenumber);

            foreach ($row->reply as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('H' . $start, $v->cmdetail_reply);
                $spreadsheet->getActiveSheet()->setCellValue('I' . $start, $v->cmreply_by_name);
                $start++;
            }

            // $id++;
        }

        // style
        foreach (range('A', 'I') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $spreadsheet->getActiveSheet()->setTitle('ติชม');

        ///////////////////////////////////////////////////////////

        $spreadsheet->createSheet();

        // Add some data
        $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A1', 'ชื่อหัวข้อประเภทการร้องเรียน')
            ->setCellValue('B1', 'ชื่อประเภทสื่อการร้องเรียน')
            ->setCellValue('C1', 'ชื่อหัวข้อการร้องเรียน')
            ->setCellValue('D1', 'รายละเอียดการร้องเรียน')
            ->setCellValue('E1', 'ชื่อร้านค้า')
            ->setCellValue('F1', 'จังหวัด')
            ->setCellValue('G1', 'อำเภอ')
            ->setCellValue('H1', 'ตำบล')
            ->setCellValue('I1', 'รายละเอียดสถานที่')
            ->setCellValue('J1', 'ละติจูด')
            ->setCellValue('K1', 'ลองจิจูด')
            ->setCellValue('L1', 'ชื่อ-นามสกุลผู้แจ้ง')
            ->setCellValue('M1', 'อีเมล')
            ->setCellValue('N1', 'หมายเลขโทรศัพท์')
            ->setCellValue('O1', 'รายละเอียดการตอบกลับ')
            ->setCellValue('P1', 'ตอบกลับโดย')
            ->setCellValue('Q1', 'รูปภาพ');

        $start = 2;
        // $id = 1;
        foreach ($complaint as $key => $row) {
            // $line = $key + 1;
            // $spreadsheet->getActiveSheet()->setCellValue('A' .$start, $id);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $start, $row->cptype_name);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $start, $row->cpmediatype_name);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $start, $row->cpdata_name);
            $spreadsheet->getActiveSheet()->setCellValue('D' . $start, $row->cpdata_details);
            $spreadsheet->getActiveSheet()->setCellValue('E' . $start, $row->cpdata_storename);
            $spreadsheet->getActiveSheet()->setCellValue('F' . $start, $row->province_name);
            $spreadsheet->getActiveSheet()->setCellValue('G' . $start, $row->district_name);
            $spreadsheet->getActiveSheet()->setCellValue('H' . $start, $row->subdistrict_name);
            $spreadsheet->getActiveSheet()->setCellValue('I' . $start, $row->cpdata_location);
            $spreadsheet->getActiveSheet()->setCellValue('J' . $start, $row->cpdata_latitude);
            $spreadsheet->getActiveSheet()->setCellValue('K' . $start, $row->cpdata_longitude);
            $spreadsheet->getActiveSheet()->setCellValue('L' . $start, $row->user_fullname);
            $spreadsheet->getActiveSheet()->setCellValue('M' . $start, $row->user_email);
            $spreadsheet->getActiveSheet()->setCellValue('N' . $start, $row->user_phonenumber);

            $lineReply = $start;
            $lineImg = $start;

            foreach ($row->reply as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('O' . $lineReply, $v->cpdetail_reply);
                $spreadsheet->getActiveSheet()->setCellValue('P' . $lineReply, $v->cpreply_by_name);
                $lineReply++;
            }
            foreach ($row->images as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('Q' . $lineImg, $v->image_path);
                $lineImg++;
            }

            $start = ($lineImg > $lineImg) ? $lineImg : $lineReply;
            // $id++;
        }

        // style
        foreach (range('A', 'Q') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('ร้องเรียน');

        /////////////////////////////////////////////////////////////

        $spreadsheet->createSheet();

        // Add some data
        $spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('A1', 'ชื่อประเภทการให้ข้อมูล')
            ->setCellValue('B1', 'ชื่อหัวข้อการให้ข้อมูล')
            ->setCellValue('C1', 'รายละเอียดการให้ข้อมูล')
            ->setCellValue('D1', 'วันที่')
            ->setCellValue('E1', 'เวลา')
            ->setCellValue('F1', 'ค่าเข้าชม')
            ->setCellValue('G1', 'เวลาเปิด')
            ->setCellValue('H1', 'เวลาปิด')
            ->setCellValue('I1', 'จังหวัด')
            ->setCellValue('J1', 'อำเภอ')
            ->setCellValue('K1', 'ตำบล')
            ->setCellValue('L1', 'รายละเอียดสถานที่')
            ->setCellValue('M1', 'ละติจูด')
            ->setCellValue('N1', 'ลองจิจูด')
            ->setCellValue('O1', 'ชื่อ-นามสกุลผู้แจ้ง')
            ->setCellValue('P1', 'อีเมล')
            ->setCellValue('Q1', 'หมายเลขโทรศัพท์')
            ->setCellValue('R1', 'รายละเอียดการตอบกลับ')
            ->setCellValue('S1', 'ตอบกลับโดย')
            ->setCellValue('T1', 'รูปภาพ');

        $start = 2;
        // $id = 1;
        foreach ($inform as $key => $row) {
            // $line = $key + 1;
            // $spreadsheet->getActiveSheet()->setCellValue('A' .$start, $id);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $start, $row->iftype_name);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $start, $row->ifdata_name);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $start, $row->ifdata_details);
            $spreadsheet->getActiveSheet()->setCellValue('D' . $start, $row->ifdata_date);
            $spreadsheet->getActiveSheet()->setCellValue('E' . $start, $row->ifdata_times);

            $spreadsheet->getActiveSheet()->setCellValue('F' . $start, $row->ifdata_price);
            $spreadsheet->getActiveSheet()->setCellValue('G' . $start, $row->ifdata_opentime);
            $spreadsheet->getActiveSheet()->setCellValue('H' . $start, $row->ifdata_closetime);

            $spreadsheet->getActiveSheet()->setCellValue('I' . $start, $row->province_name);
            $spreadsheet->getActiveSheet()->setCellValue('J' . $start, $row->district_name);
            $spreadsheet->getActiveSheet()->setCellValue('K' . $start, $row->subdistrict_name);
            $spreadsheet->getActiveSheet()->setCellValue('L' . $start, $row->ifdata_location);
            $spreadsheet->getActiveSheet()->setCellValue('M' . $start, $row->ifdata_latitude);
            $spreadsheet->getActiveSheet()->setCellValue('N' . $start, $row->ifdata_longitude);
            $spreadsheet->getActiveSheet()->setCellValue('O' . $start, $row->user_fullname);
            $spreadsheet->getActiveSheet()->setCellValue('P' . $start, $row->user_email);
            $spreadsheet->getActiveSheet()->setCellValue('Q' . $start, $row->user_phonenumber);

            $lineReply = $start;
            $lineImg = $start;

            foreach ($row->reply as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('R' . $lineReply, $v->ifdetail_reply);
                $spreadsheet->getActiveSheet()->setCellValue('S' . $lineReply, $v->ifreply_by_name);
                $lineReply++;
            }
            foreach ($row->images as $k => $v) {
                $spreadsheet->getActiveSheet()->setCellValue('T' . $lineImg, $v->image_path);
                $lineImg++;
            }

            $start = ($lineImg > $lineImg) ? $lineImg : $lineReply;
            // $id++;
        }

        // style
        foreach (range('A', 'T') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('ให้ข้อมูล');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=$file_name");
        $writer->save("php://output");

    }

    // public function all_reply()
    // {
    //     $file_name = " รายงาน รายการทั้งหมดที่ตอบกลับแล้ว | " . date("Y-m-d");
    //     return (new MainExport("A"))->download($file_name . '.xlsx');
    // }

    // public function all_unreply()
    // {
    //     $file_name = " รายงาน รายการที่ยังไม่ได้ตอบกลับ | " . date("Y-m-d");
    //     return (new MainExport("N"))->download($file_name . '.xlsx');
    // }

    // public function all_unread()
    // {
    //     $file_name = " รายงาน รายการที่ยังไม่ได้อ่าน | " . date("Y-m-d");
    //     return (new MainExport("","N"))->download($file_name . '.xlsx');
    // }

    private function comemnt(string $reply_status = "", string $read_status = "")
    {
        $token = \Cookie::get('mcul_token');
        $condition = ['' => ''];
        if ($reply_status != "") {
            $condition = ['reply_status' => $reply_status];
        }
        if ($read_status != "") {
            $condition = ['read_status' => $read_status];
        }
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/comment/list", $condition, $token);
        return $arg->data_object;
    }

    private function complaint(string $reply_status = "", string $read_status = "")
    {
        $token = \Cookie::get('mcul_token');
        $condition = ['' => ''];
        if ($reply_status != "") {
            $condition = ['reply_status' => $reply_status];
        }
        if ($read_status != "") {
            $condition = ['read_status' => $read_status];
        }
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/complaint/list", $condition, $token);
        return $arg->data_object;
    }

    private function inform(string $reply_status = "", string $read_status = "")
    {
        $token = \Cookie::get('mcul_token');
        $condition = ['' => ''];
        if ($reply_status != "") {
            $condition = ['reply_status' => $reply_status];
        }
        if ($read_status != "") {
            $condition = ['read_status' => $read_status];
        }
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/inform/list", $condition, $token);
        return $arg->data_object;
    }

}
