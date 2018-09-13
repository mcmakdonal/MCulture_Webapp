<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromQuery;
use App\Mylibs\Myclass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class InformExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{

    protected $reply_status;
    protected $read_status;

    public function __construct(string $reply_status = "", string $read_status = "")
    {
        $this->reply_status = $reply_status;
        $this->read_status = $read_status;
    }

    /**
     * @return Builder
     */
    public function collection()
    {
        $token = \Cookie::get('mcul_token');
        $condition = ['' => ''];
        if ($this->reply_status != "") {
            $condition = ['reply_status' => $this->reply_status];
        }
        if ($this->read_status != "") {
            $condition = ['read_status' => $this->read_status];
        }
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/inform/list", $condition, $token);
        $new = [];
        foreach ($arg->data_object as $key => $value) {
            $new[$key]['ID'] = $key + 1;
            // $new[$key]['IFDATA_ID'] = $value->ifdata_id;
            // $new[$key]['IFTYPE_ID'] = $value->iftype_id;
            $new[$key]['IFTYPE_NAME'] = $value->iftype_name;

            $new[$key]['IFDATA_NAME'] = $value->ifdata_name;
            $new[$key]['IFDATA_DETAILS'] = $value->ifdata_details;
            $new[$key]['IFDATA_DATE'] = $value->ifdata_date;
            $new[$key]['IFDATA_TIMES'] = $value->ifdata_times;
            $new[$key]['IFDATA_PRICE'] = $value->ifdata_price;

            $new[$key]['IFDATA_OPENTIME'] = $value->ifdata_opentime;
            $new[$key]['IFDATA_CLOSETIME'] = $value->ifdata_closetime;

            $new[$key]['PROVINCE'] = $value->province_name;
            $new[$key]['DISTRICT'] = $value->district_name;
            $new[$key]['SUBDISTRICT'] = $value->subdistrict_name;

            $new[$key]['IFDATA_LOCATION'] = $value->ifdata_location;
            $new[$key]['IFDATA_LATITUDE'] = $value->ifdata_latitude;
            $new[$key]['IFDATA_LONGITUDE'] = $value->ifdata_longitude;

            $new[$key]['USER_FULLNAME'] = $value->user_fullname;
            $new[$key]['USER_EMAIL'] = $value->user_email;
            $new[$key]['USER_PHONENUMBER'] = $value->user_phonenumber;

            $new[$key]['IFDATA_DETAILREPLY'] = $value->ifdata_detailreply;
            $new[$key]['IFDATA_REPLYBY'] = $value->ifdata_replyby_name;

            $image = [];
            foreach ($value->images as $k => $v) {
                $image[$k] = $v->image_path;
            }
            $new[$key]['IMAGE'] = json_encode($image, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        }
        $cc = collect($new);
        return $cc;
    }

    /**
     * @return string
     */
    public function headings(): array
    {
        return [
            'No. ',
            // 'รหัสการให้ข้อมูล',
            // 'รหัสประเภทการให้ข้อมูล',
            'ชื่อประเภทการให้ข้อมูล',

            'ชื่อหัวข้อการให้ข้อมูล',
            'รายละเอียดการให้ข้อมูล',
            'วันที่',
            'เวลา',
            'ค่าเข้าชม',

            'เวลาเปิด',
            'เวลาปิด',

            'จังหวัด',
            'อำเภอ',
            'ตำบล',

            'รายละเอียดสถานที่',
            'ละติจูด',
            'ลองจิจูด',

            'ชื่อ-นามสกุลผู้แจ้ง',
            'อีเมล',
            'หมายเลขโทรศัพท์',

            'รายละเอียดการตอบกลับ',
            'ตอบกลับโดย',

            'รูปภาพ',
        ];
    }

    public function title(): string
    {
        return 'ให้ข้อมูล';
    }

}
