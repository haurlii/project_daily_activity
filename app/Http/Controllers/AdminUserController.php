<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index-user', ['title' => 'Data Karyawan']);
    }

    public function excel()
    {
        $filename = now()->format('d-m-Y_H.i.s');
        return Excel::download(new UsersExport, 'DataUser_' . $filename . '.xlsx');
    }
}
