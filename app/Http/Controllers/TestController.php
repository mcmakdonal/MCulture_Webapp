<?php

namespace App\Http\Controllers;

// use Rap2hpoutre\FastExcel\FastExcel;
// use Maatwebsite\Excel\Facades\Excel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TestController extends Controller
{
    public function export()
    {
        $data = [
            [
                'name' => 'Povilas',
                'surname' => 'Korop',
                'email' => 'povilas@laraveldaily.com',
                'twitter' => '@povilaskorop',
                'array' => [
                    'a','b','c'
                ]
            ],
            [
                'name' => 'Taylor',
                'surname' => 'Otwell',
                'email' => 'taylor@laravel.com',
                'twitter' => '@taylorotwell',
                'array' => [
                    'a','b','c'
                ]
            ],
        ];

        // $json = file_get_contents('employee.json');
        // $employees = json_decode($json, true);
         
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'My Data');
         
        // header
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'รหัสพนักงาน')
            ->setCellValue('B1', 'ชื่อ')
            ->setCellValue('C1', 'นามสกุล')
            ->setCellValue('D1', 'อีเมล์')
            ->setCellValue('E1', 'เพศ');
            // ->setCellValue('F1', 'เงินเดือน')
            // ->setCellValue('G1', 'เบอร์โทรศัพท์');
         
        // cell value
        $start = 2;
        foreach($data as $key => $row){
            // $line = $key + 1;
            $spreadsheet->getActiveSheet()->setCellValue('A' .$start, $row['name']);
            $spreadsheet->getActiveSheet()->setCellValue('B' .$start, $row['surname']);
            $spreadsheet->getActiveSheet()->setCellValue('C' .$start, $row['email']);
            $spreadsheet->getActiveSheet()->setCellValue('D' .$start, $row['twitter']);
            // $start++;

            foreach($row['array'] as $k => $v){
                $spreadsheet->getActiveSheet()->setCellValue('E' .$start, $v);
                $start++;
            }
        }
         
        // style        
        foreach(range('A','E') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $spreadsheet->getActiveSheet()->setTitle('URL Added');
        $spreadsheet->createSheet();
        // Add some data
        $spreadsheet->setActiveSheetIndex(1)
                ->setCellValue('A1', 'world!');

        // style        
        foreach(range('A','E') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('URL Removed');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

         
        $writer = new Xlsx($spreadsheet);
         
        // save file to server and create link
        $writer->save('itoffside.xlsx');
        echo '<a href="itoffside.xlsx">Download Excel</a>';
         
        // save with browser
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment; filename="itoffside.xlsx"');
        // $writer->save('php://output');
    }
}
