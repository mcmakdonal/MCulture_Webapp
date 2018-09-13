<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Mylibs\Myclass;

class ReplyController extends Controller
{
    public function inform(Request $request)
    {
        $token = \Cookie::get('mcul_token');
        $validator = Validator::make($request->all(), [
            'IFDATA_DETAILREPLY' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'IFDATA_DETAIL_REPLY' => $request->IFDATA_DETAILREPLY,
            'REPLY_ID' => $request->REPLY_ID,
        );

        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/inform/update_reply", $args, $token);
        if ($arg->status) {
            $nof = Myclass::send_nofti(['device_token' => $request->device_token, 'message' => $request->IFDATA_DETAILREPLY]);
            if($nof){
                return redirect()->back()->with('status', 'Update Reply Success');
            }else{
                return redirect()->back()->with('status', 'Update Reply Success But Notification not send');
            }
        } else {
            return redirect()->back()->withErrors($arg->description);
        }
    }

    public function comment(Request $request)
    {
        $token = \Cookie::get('mcul_token');
        $validator = Validator::make($request->all(), [
            'CMDATA_DETAILREPLY' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'CMDATA_DETAIL_REPLY' => $request->CMDATA_DETAILREPLY,
            'REPLY_ID' => $request->REPLY_ID,
        );

        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/comment/update_reply", $args, $token);
        if ($arg->status) {
            $nof = Myclass::send_nofti(['device_token' => $request->device_token, 'message' => $request->CMDATA_DETAILREPLY]);
            if($nof){
                return redirect()->back()->with('status', 'Update Reply Success');
            }else{
                return redirect()->back()->with('status', 'Update Reply Success But Notification not send');
            }
        } else {
            return redirect()->back()->withErrors($arg->description);
        }
    }

    public function complaint(Request $request)
    {
        $token = \Cookie::get('mcul_token');
        $validator = Validator::make($request->all(), [
            'CPDATA_DETAILREPLY' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'CPDATA_DETAIL_REPLY' => $request->CPDATA_DETAILREPLY,
            'REPLY_ID' => $request->REPLY_ID,
        );

        $arg = Myclass::mculter_service("POST", "8080", "admin/api/v1/complaint/update_reply", $args, $token);
        if ($arg->status) {
            $nof = Myclass::send_nofti(['device_token' => $request->device_token, 'message' => $request->CPDATA_DETAILREPLY]);
            if($nof){
                return redirect()->back()->with('status', 'Update Reply Success');
            }else{
                return redirect()->back()->with('status', 'Update Reply Success But Notification not send');
            }
        } else {
            return redirect()->back()->withErrors($arg->description);
        }
    }


}
