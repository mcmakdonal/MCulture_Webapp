<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('Mid_auth');
    }

    public function index()
    {
        return view('dashboard.dashboard', [
            'title' => 'Dashboard', 'header' => 'Dashboard','content' => 'content'
        ]);
    }

}
