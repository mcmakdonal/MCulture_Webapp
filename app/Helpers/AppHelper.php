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
        if (\Cookie::get('mct_user_id') === null){
            return false;
        } else {
            return true;
        }
    }

    public static function instance()
    {
        return new AppHelper();
    }
}
