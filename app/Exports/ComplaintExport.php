<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromQuery;
use App\Mylibs\Myclass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ComplaintExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
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
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/complaint/list", $condition, $token);
        $new = [];
        foreach ($arg->data_object as $key => $value) {
            $new[$key]['ID'] = $key + 1;
            // $new[$key]['CPDATA_ID'] = $value->cpdata_id;
            // $new[$key]['CPTYPE_ID'] = $value->cptype_id;
            $new[$key]['CPTYPE_NAME'] = $value->cptype_name;
            $new[$key]['CPMEDIATYPE_NAME'] = $value->cpmediatype_name;

            $new[$key]['CPDATA_NAME'] = $value->cpdata_name;
            $new[$key]['CPDATA_DETAILS'] = $value->cpdata_details;
            $new[$key]['CPDATA_STORENAME'] = $value->cpdata_storename;
            $new[$key]['PROVINCE'] = $value->province_name;
            $new[$key]['DISTRICT'] = $value->district_name;
            $new[$key]['SUBDISTRICT'] = $value->subdistrict_name;

            $new[$key]['CPDATA_LOCATION'] = $value->cpdata_location;
            $new[$key]['CPDATA_LATITUDE'] = $value->cpdata_latitude;
            $new[$key]['CPDATA_LONGITUDE'] = $value->cpdata_longitude;

            $new[$key]['USER_FULLNAME'] = $value->user_fullname;
            $new[$key]['USER_EMAIL'] = $value->user_email;
            $new[$key]['USER_PHONENUMBER'] = $value->user_phonenumber;

            $new[$key]['CPDATA_DETAILREPLY'] = $value->cpdata_detailreply;
            $new[$key]['CPDATA_REPLYBY'] = $value->cpdata_replyby_name;

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
            // 'รหัสการร้องเรียน',
            // 'รหัสประเภทการร้องเรียน',
            'ชื่อหัวข้อประเภทการร้องเรียน',
            'ชื่อประเภทสื่อการร้องเรียน',

            'ชื่อหัวข้อการร้องเรียน',
            'รายละเอียดการร้องเรียน',
            'ชื่อร้านค้า',
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
        return 'ร้องเรียน';
    }

}
