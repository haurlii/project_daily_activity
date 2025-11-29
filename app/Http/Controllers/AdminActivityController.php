<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminActivityController extends Controller
{
    public function index()
    {
        return view('admin.index-activity', ['title' => 'Data Aktivitas']);
    }

    public function show(string $id)
    {
        //
    }
}
