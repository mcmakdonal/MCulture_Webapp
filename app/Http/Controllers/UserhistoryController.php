<?php

namespace App\Http\Controllers;
use App\Mylibs\Myclass;
use Illuminate\Http\Request;
use Validator;
use Crypt;

class UserhistoryController extends Controller
{
    public function index()
    {
        $arg = Myclass::mculter_service("GET", "8080", "user/api/v1/user_history",[''=>''],\Cookie::get("mct_user_id"));
        // dd($arg);
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        return view('history.index', [
            'title' => 'History', 'list' => $paginatedItems,
        ]);
    }

    public function comment_detail($param){
        $id = Crypt::decrypt($param);
        $arg = Myclass::mculter_service("GET", "8080", "user/api/v1/comment/".$id,[],\Cookie::get("mct_user_id"));
        // dd($arg);
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        return view('history.comment-view', [
            'title' => 'History ติชม', 'content' => $paginatedItems,
        ]);
    }

    public function inform_detail($param){
        $id = Crypt::decrypt($param);
        $arg = Myclass::mculter_service("GET", "8080", "user/api/v1/inform/".$id,[],\Cookie::get("mct_user_id"));
        // dd($arg);
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        return view('history.inform-view', [
            'title' => 'History ให้ข้อมูล', 'content' => $paginatedItems,
        ]);
    }

    public function complaint_detail($param){
        $id = Crypt::decrypt($param);
        $arg = Myclass::mculter_service("GET", "8080", "user/api/v1/complaint/".$id,[],\Cookie::get("mct_user_id"));
        // dd($arg);
        $paginatedItems = [];
        if ($arg->status) {
            $paginatedItems = $arg->data_object;
        }

        return view('history.complaint-view', [
            'title' => 'History ร้องเรียน', 'content' => $paginatedItems,
        ]);
    }    

}
