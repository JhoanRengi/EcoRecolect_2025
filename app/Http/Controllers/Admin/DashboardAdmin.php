<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardAdmin extends Controller
{
    public function index()
    {
        return view('admin.dashboard'); // 
    }
}