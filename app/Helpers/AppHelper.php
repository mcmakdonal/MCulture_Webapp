<?php
namespace App\Helpers;

class AppHelper
{
    public function gen_script($type, $path, $opt = "")
    {
        $public_path = public_path($path);
        $asset = asset($path);
        switch ($type) {
            case "js":
                echo '<script src="' . $asset . '?v=' . filemtime($public_path) . '" ' . $opt . ' ></script>';
                break;
            case "css":
                echo '<link rel="stylesheet" href="' . $asset . '?v=' . filemtime($public_path) . '" ' . $opt . ' >';
                break;
            default:
                echo "";
        }
    }

    public function check_login_fb()
    {
        if (\Cookie::get('mct_user_id') === null) {
            return false;
        } else {
            return true;
        }
    }

    public function Bt_date()
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array("",
            "มกราคม",
            "กุมภาพันธ์",
            "มีนาคม",
            "เมษายน",
            "พฤษภาคม",
            "มิถุนายน",
            "กรกฎาคม",
            "สิงหาคม",
            "กันยายน",
            "ตุลาคม",
            "พฤษจิกายน",
            "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
    }

    public function Month_Year($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strMonthCut = array("",
            "มกราคม",
            "กุมภาพันธ์",
            "มีนาคม",
            "เมษายน",
            "พฤษภาคม",
            "มิถุนายน",
            "กรกฎาคม",
            "สิงหาคม",
            "กันยายน",
            "ตุลาคม",
            "พฤษจิกายน",
            "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strMonthThai $strYear";
    }

    public static function instance()
    {
        return new AppHelper();
    }

}
