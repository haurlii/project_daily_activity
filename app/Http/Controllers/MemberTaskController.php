<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('member.index-task', ['title' => 'Data Tugas']);
    }

    public function show(string $id)
    {
        //
    }
}
