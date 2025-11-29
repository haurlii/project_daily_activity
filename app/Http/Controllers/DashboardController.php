<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexAdmin()
    {
        return view('admin.dashboard', ['title' => 'Dashboard']);
    }

    public function indexLeader()
    {
        return view('leader.dashboard', ['title' => 'Dashboard']);
    }

    public function indexMember()
    {
        return view('member.dashboard', ['title' => 'Dashboard']);
    }
}
