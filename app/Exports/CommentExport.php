<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromQuery;
use App\Mylibs\Myclass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CommentExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
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
        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/comment/list", $condition, $token);
        $new = [];

        foreach ($arg->data_object as $key => $value) {
            $new[$key]['ID'] = $key + 1;
            $new[$key]['CMTYPE_NAME'] = $value->cmtype_name;

            $new[$key]['CMDATA_NAME'] = $value->cmdata_name;
            $new[$key]['CMDATA_DETAILS'] = $value->cmdata_details;
            $new[$key]['CMDATA_PERSONNAME'] = $value->cmdata_personname;

            $new[$key]['USER_FULLNAME'] = $value->user_fullname;
            $new[$key]['USER_EMAIL'] = $value->user_email;
            $new[$key]['USER_PHONENUMBER'] = $value->user_phonenumber;

            $new[$key]['CMDATA_DETAILREPLY'] = $value->cmdata_detailreply;
            $new[$key]['CMDATA_REPLYBY'] = $value->cmdata_replyby_name;
        }

        $cc = collect($new);
        // dd($cc);
        // $cc = ($arg->data_object);
        return $cc;
    }

    /**
     * @return string
     */
    public function headings(): array
    {
        return [
            'No. ',
            // 'รหัสการติชม',
            // 'รหัสประเภทการติชม',
            'ชื่อประเภทการติชม',

            'ชื่อหัวข้อการติชม',
            'รายละเอียดการติชม',
            'ชื่อบุคลากร',

            'ชื่อ-นามสกุลผู้แจ้ง',
            'อีเมล',
            'หมายเลขโทรศัพท์',

            'รายละเอียดการตอบกลับ',
            'ตอบกลับโดย',
        ];
    }

    public function title(): string
    {
        return 'ติชม';
    }

}
