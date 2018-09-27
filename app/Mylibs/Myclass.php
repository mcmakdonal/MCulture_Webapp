<?php

namespace App\Mylibs;

use Illuminate\Support\ServiceProvider;

class Myclass extends ServiceProvider
{
    public static function mculter_service($method = "GET", $port = "8080", $route = "", $arg = [], $token = "")
    {
        $curl = curl_init();
        $obj = json_encode(array_change_key_case($arg, CASE_LOWER), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "$port",
            CURLOPT_URL => "http://mculture-social.demotoday.net:$port/" . $route,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "$method",
            CURLOPT_POSTFIELDS => "$obj",
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token",
                "Content-Type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return array('message' => $err, 'status' => false);
        } else {
            $arg = json_decode($response);
            return $arg;
            // if ($arg->status) {
            //     return $arg;
            // } elseif ($arg->status == '403') {
            //     return array('message' => 'Access Denied', 'status' => false);
            // } else {
            //     return array('message' => "Can't $method Data", 'status' => false);
            // }
        }
    }

    public static function buildMultiPartRequest($method = "POST", $port = "8080", $route = "", $fields, $files, $token)
    {
        $obj = json_encode(array_change_key_case($fields, CASE_LOWER), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $boundary = uniqid();
        $delimiter = '-------------' . $boundary;
        $data = '';
        $name = 'data';
        // foreach ($fields as $name => $content) {
        $data .= "--" . $delimiter . "\r\n"
            . 'Content-Disposition: form-data; name="' . $name . "\"\r\n\r\n"
            . $obj . "\r\n";
        // }
        foreach ($files as $name => $content) {
            // dd($content['file']);
            $data .= "--" . $delimiter . "\r\n"
            . 'Content-Disposition: form-data; name="file"; filename="' . $content . '"' . "\r\n\r\n"
            . file_get_contents($content) . "\r\n";
        }
        $data .= "--" . $delimiter . "--\r\n";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "$port",
            CURLOPT_URL => "http://mculture-social.demotoday.net:$port/" . $route,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: multipart/form-data; boundary=' . $delimiter,
                'Content-Length: ' . strlen($data),
                "Authorization: $token",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        foreach ($files as $unlink) {
            unlink($unlink);
        }

        if ($err) {
            return array('message' => $err, 'status' => false);
        } else {
            $arg = json_decode($response);
            return $arg;

            // return $arg;
            // if ($arg->status) {
            //     foreach ($files as $unlink) {
            //         unlink($unlink);
            //     }
            //     return $arg;
            // } elseif ($arg->status == '403') {
            //     return array('message' => 'Access Denied', 'status' => false);
            // } else {
            //     return array('message' => "Can't $method Data", 'status' => false);
            // }
        }
    }

    public static function send_nofti(array $args)
    {
        /*
        $token => ให้ใส่เป็น devices_token ที่มีมาใน services
         */
        $token = array($args['device_token']);
        // $token = array(
        //     "eKZcM_0eX2M:APA91bHvdp8_9gILLTY4gFH-FVfcnnB0x9q1Ldyx8Ry6EENtortXC9-J6HjlWhueI5djE5yYupKI8QAunkU2kHsC8zNmML7SV6oWJLn810xuBSuqqqKfFtxHLhl2bL9fg1r2fWpOe8Ni"
        // );
        $payload_notification = array(
            'title' => 'MCULTURE - ตอบกลับจากเจ้าหน้าที่', // เปลี่ยนตัวข้อเป็นอะไรก็ได้เช่น 'ข้อความตอบกลับจากเจ้าหน้า'
            'body' => $args['message'], // แก้ตรงนี้ใส่ข้อความที่ admin ตอบกลับ
            'sound' => 'default',
            'icon' => 1,
            'click_action' => 'OPEN_ACTIVITY_1',
        );
        $payload_data = array(
            'answer' => 'success',
        );

        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $token,
            'priority' => 'normal',
            'notification' => $payload_notification,
            'data' => $payload_data,
        );
        $headers = array(
            'Authorization: key=AAAAtelHw-s:APA91bEN8-6HxTGoxwqacD8cbFiItYLut_0mdGAdkuXQ6nj8HUrl9sjeCccoGzuHeJ95ViZW9lLUQ-YDZYfRvLeCZUWvULf9TJbrlxF2k_pcmJgXMw_9nIXxyjXIaAVS7VHm7d15bvdG',
            'Content-Type: application/json',
        );
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporary
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);
        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        $data = json_decode($result);
        if ($data->success) {
            return true;
        } else {
            return false;
        }

    }

    public static function map_field($main_id, $sub_id)
    {
        $main_id = (int) $main_id;
        $sub_id = (int) $sub_id;
        $args = [];
        $args['title'] = "";
        switch ($main_id) {
            case 1:
                switch ($sub_id) {
                    case 1:
                        $args['field'] = ['topic_title', 'start_date', 'end_date', 'start_time', 'end_time', 'province_id', 'district_id', 'sub_district_id', 'topic_details', 'file', 'topic_remark'];
                        $args['title'] = "แนะนำ/ติชม - กิจกรรม";
                        return $args;
                        break;
                    case 2:
                        $args['field'] = ['topic_title', 'date_work', 'province_id', 'district_id', 'sub_district_id', 'price', 'topic_details', 'file', 'topic_remark'];
                        $args['title'] = "แนะนำ/ติชม - สถานที่";
                        return $args;
                        break;
                    case 3:
                        $args['field'] = ['topic_title', 'start_date', 'start_time', 'province_id', 'district_id', 'sub_district_id', 'topic_details', 'file', 'reference', 'topic_remark'];
                        $args['title'] = "แนะนำ/ติชม - องค์ความรู้";
                        return $args;
                        break;
                    case 4:
                        $args['field'] = ['topic_title', 'start_date', 'start_time', 'province_id', 'district_id', 'sub_district_id', 'topic_details', 'file', 'topic_remark'];
                        $args['title'] = "แนะนำ/ติชม - บริการ";
                        return $args;
                        break;
                    case 5:
                        $args['field'] = ['topic_title', 'start_date', 'start_time', 'organize_id', 'province_id', 'district_id', 'sub_district_id', 'topic_details', 'file', 'topic_remark'];
                        $args['title'] = "แนะนำ/ติชม - บุคคลากร/เจ้าหน้าที่";
                        return $args;
                        break;
                    case 6:
                        $args['field'] = ['topic_title', 'start_date', 'start_time', 'province_id', 'district_id', 'sub_district_id', 'topic_details', 'file'];
                        $args['title'] = "แนะนำ/ติชม - อื่นๆ";
                        return $args;
                        break;
                    default:
                        $args['field'] = [];
                        return $args;
                        break;
                }
                break;

            case 2:
                switch ($sub_id) {
                    case 7:
                        $args['field'] = ['topic_title', 'media_type_id', 'location', 'topic_details', 'file', 'topic_remark'];
                        $args['title'] = "ร้องเรียน/ร้องทุกข์ - สื่อไม่เหมาะสม";
                        return $args;
                        break;
                    case 8:
                        $args['field'] = ['topic_title', 'location', 'topic_details', 'file', 'topic_remark'];
                        $args['title'] = "ร้องเรียน/ร้องทุกข์ - พฤติกรรมเบี่ยงเบน";
                        return $args;
                        break;
                    case 9:
                        $args['field'] = ['topic_title', 'start_date', 'start_time', 'organize_id', 'province_id', 'district_id', 'sub_district_id', 'topic_details', 'file', 'topic_remark'];
                        $args['title'] = "ร้องเรียน/ร้องทุกข์ - บุคคลากร/เจ้าหน้าที่";
                        return $args;
                        break;
                    case 10:
                        $args['field'] = ['topic_title', 'commerce_type_id', 'business_name', 'topic_details', 'file', 'topic_remark'];
                        $args['title'] = "ร้องเรียน/ร้องทุกข์ - ร้านเกม/ร้านคาราโอเกะ/ร้านขาย DVD เถื่อน";
                        return $args;
                        break;
                    case 11:
                        $args['field'] = ['topic_title', 'religion_id', 'topic_details', 'file', 'topic_remark'];
                        $args['title'] = "ร้องเรียน/ร้องทุกข์ - ศาสนา";
                        return $args;
                        break;
                    case 12:
                        $args['field'] = ['topic_title', 'topic_details', 'file', 'topic_remark'];
                        $args['title'] = "ร้องเรียน/ร้องทุกข์ - ศิลปะ/วัฒนธรรม";
                        return $args;
                        break;
                    case 13:
                        $args['field'] = ['topic_title', 'topic_details', 'file', 'topic_remark'];
                        $args['title'] = "ร้องเรียน/ร้องทุกข์ - อื่นๆ";
                        return $args;
                        break;
                    default:
                        $args['field'] = [];
                        return $args;
                        break;
                }
                break;

            case 3:
                switch ($sub_id) {
                    case 14:
                        $args['field'] = ['topic_title', 'topic_details', 'file', 'location', 'topic_remark'];
                        $args['title'] = "อื่นๆ - อื่นๆ";
                        return $args;
                        break;
                    default:
                        $args['field'] = [];
                        return $args;
                        break;
                }
                break;

            default:
                $args['field'] = [];
                return $args;
                break;
        }
    }

}
