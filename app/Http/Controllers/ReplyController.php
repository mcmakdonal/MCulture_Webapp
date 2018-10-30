<?php

namespace App\Http\Controllers;

use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('Mid_auth');
    }

    public function recommend(Request $request)
    {
        $args = ['main_type_id' => '1'];
        if ($request->id != "") {
            $args['sub_type_id'] = $request->id;
        }
        if ($request->reply != "") {
            $args['reply_status'] = $request->reply;
        }
        // dd($args);
        $main_data = MyClass::mculter_service("POST", "8080", "topic/api/v1/list", $args, \Cookie::get('mcul_token'));
        // dd($main_data);
        return view('reply.index', [
            'title' => 'ตอบกลับข้อมูลการ แนะนำ/ติชม',
            'header' => 'ตอบกลับข้อมูลการ แนะนำ/ติชม',
            'main_data' => $main_data->data_object,
            'sub_type' => MyClass::mculter_service("get", "8080", "data/api/v1/get_subtype/1")->data_object,
            'id' => $request->id,
            'reply' => $request->reply,
        ]);
    }

    public function complaint(Request $request)
    {
        $args = ['main_type_id' => '2'];
        if ($request->id != "") {
            $args['sub_type_id'] = $request->id;
        }
        if ($request->reply != "") {
            $args['reply_status'] = $request->reply;
        }
        // dd($args);
        $main_data = MyClass::mculter_service("POST", "8080", "topic/api/v1/list", $args, \Cookie::get('mcul_token'));
        // dd($main_data);;
        return view('reply.index', [
            'title' => 'ตอบกลับข้อมูลการ ร้องเรียน/ร้องทุกข์',
            'header' => 'ตอบกลับข้อมูลการ ร้องเรียน/ร้องทุกข์',
            'main_data' => $main_data->data_object,
            'sub_type' => MyClass::mculter_service("get", "8080", "data/api/v1/get_subtype/2")->data_object,
            'id' => $request->id,
            'reply' => $request->reply,
        ]);
    }

    public function other(Request $request)
    {
        $args = ['main_type_id' => '3'];
        if ($request->id != "") {
            $args['sub_type_id'] = $request->id;
        }
        if ($request->reply != "") {
            $args['reply_status'] = $request->reply;
        }
        // dd($args);
        $main_data = MyClass::mculter_service("POST", "8080", "topic/api/v1/list", $args, \Cookie::get('mcul_token'));
        // dd($main_data);;
        return view('reply.index', [
            'title' => 'ตอบกลับข้อมูลเรื่องอื่นๆ',
            'header' => 'ตอบกลับข้อมูลเรื่องอื่นๆ',
            'main_data' => $main_data->data_object,
            'sub_type' => MyClass::mculter_service("get", "8080", "data/api/v1/get_subtype/3")->data_object,
            'id' => $request->id,
            'reply' => $request->reply,
        ]);
    }

    public function view_reply(Request $request, $id)
    {
        $request->session()->forget('type');
        $request->session()->forget('field');
        $request->session()->forget('title');

        $token = \Cookie::get('mcul_token');
        $read = Myclass::mculter_service("GET", "8080", "topic/api/v1/read/" . $id, ['' => ''], $token);
        if (!$read->status) {
            return redirect()->back()->withErrors($read->description);
        }
        $arg = [];
        $arg = Myclass::mculter_service("GET", "8080", "topic/api/v1/details/" . $id, ['' => ''], $token);
        if ($arg->status == false) {
            return redirect()->back()->withErrors("none");
        }
        $obj = [];
        if ($arg->status) {
            $obj = $arg->data_object;
            $map_field = Myclass::map_field($obj->topic_main_type_id, $obj->topic_sub_type_id);
            session(['field_edit' => $map_field['field']]);
            session(['title_edit' => $map_field['title']]);
        }

        // dd(session('field_edit'));
        // dd($obj);
        return view('reply.reply', [
            'title' => 'ตอบกลับข้อมูล' . session('title_edit'),
            'header' => 'ตอบกลับข้อมูล' . session('title_edit'),
            'content' => $obj,
        ]);
    }

    public function reply(Request $request, $id)
    {
        // dd($request);
        $token = \Cookie::get('mcul_token');
        $validator = Validator::make($request->all(), [
            'reply_details' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'reply_details' => $request->reply_details,
            'topic_id' => $id,
        );

        $arg = Myclass::mculter_service("POST", "8080", "topic/api/v1/reply", $args, $token);
        if ($arg->status) {
            if (strtolower($request->get_news_update) == "y") {
                $nof = Myclass::send_nofti(['device_token' => $request->device_token, 'message' => $request->reply_details]);
                if ($nof) {
                    return redirect()->back()->with('status', 'ตอบกลับและส่งการแจ้งเตือนสำเร็จ');
                } else {
                    return redirect()->back()->with('status', 'ตอบกลับสำเร็จ แต่ไม่ส่งการแจ้งเตือน');
                }
            } else {
                return redirect()->back()->with('status', 'ตอบกลับสำเร็จ');
            }

        } else {
            return redirect()->back()->withErrors($arg->description);
        }

    }

    public function replyed(Request $request)
    {
        $token = \Cookie::get('mcul_token');
        $validator = Validator::make($request->all(), [
            'reply_details' => 'required',
            'reply_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'reply_details' => $request->reply_details,
            'reply_id' => $request->reply_id,
        );

        $arg = Myclass::mculter_service("POST", "8080", "topic/api/v1/update_reply", $args, $token);
        if ($arg->status) {
            return redirect()->back()->with('status', 'อัพเดตตอบกลับสำเร็จ');
        } else {
            return redirect()->back()->withErrors($arg->description);
        }

    }

    public function remove_topic($id)
    {
        $token = \Cookie::get('mcul_token');
        $arg = Myclass::mculter_service("GET", "8080", "topic/api/v1/delete/$id", ['' => ''], $token);
        return json_encode($arg);
    }

}
