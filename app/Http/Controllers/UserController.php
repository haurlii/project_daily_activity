<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Superadmin\StoreUserRequest as SuperAdminStoreUserRequest;
use App\Http\Requests\Leader\StoreUserRequest as LeaderStoreUserRequest;
use App\Http\Requests\Superadmin\UpdateUserRequest as SuperAdminUpdateUserRequest;
use App\Http\Requests\Leader\UpdateUserRequest as LeaderUpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'SuperAdmin') {
        } else {
        }
    }

    public function indexSuperAdmin()
    {
        $user = User::where('role', '!=', 'SuperAdmin')->orderBy('name', 'asc')->paginate(7)->withQueryString();
        return view('admin.index-user', ['title' => 'Data Karyawan', 'users' => $user]);
    }

    public function createSuperAdmin()
    {
        $division =  User::select('division')->distinct()->whereNotNull('division')->pluck('division');
        return view('admin.create-user', ['title' => 'Tambah Karyawan', 'divisions' => $division]);
    }

    public function storeSuperAdmin(SuperAdminStoreUserRequest $request)
    {
        $new_user = $request->validated();
        User::create($new_user);
        return Redirect::route('admin.users.index')->with('message', 'Data Berhasil Ditambahkan');
    }

    // public function showSuperAdmin() {}

    public function editSuperAdmin(User $user)
    {
        $division =  User::select('division')->distinct()->whereNotNull('division')->pluck('division');
        return view('admin.edit-user', ['title' => 'Edit Karyawan', 'user' => $user, 'divisions' => $division]);
    }

    public function updateSuperAdmin(SuperAdminUpdateUserRequest $request, User $user)
    {
        $edit_user = $request->validated();
        $user->update($edit_user);
        return Redirect::route('admin.users.index')->with('message', 'Data Berhasil Ditambahkan');
    }

    public function destroySuperAdmin(User $user)
    {
        $user->delete();
        return Redirect::route('admin.users.index')->with(['message' => 'Data Berhasil Di Hapus']);
    }

    public function excelSuperAdmin()
    {
        $filename = 'Data Karyawan Divisi ' . implode(', ', User::pluck('division')->filter()->unique()->sort()->values()->toArray()) . ' ' . Carbon::now()->format('Y-m-d His');
        return Excel::download(new UsersExport, "$filename.ods");
    }

    public function pdfSuperAdmin()
    {
        $filename = 'Data Karyawan Divisi ' . implode(', ', User::pluck('division')->filter()->unique()->sort()->values()->toArray()) . ' ' . Carbon::now()->format('Y-m-d His');
        $users = User::where('role', '!=', 'SuperAdmin')->orderBy('division', 'asc')->get();
        $pdf = Pdf::loadView('admin.pdf-user', ['users' => $users]);
        return $pdf->setPaper('A4', 'landscape')->download($filename . '.pdf');
    }

    public function indexLeader()
    {
        $user = User::where(['division' => Auth::user()->division, 'role' => 'Member'])->orderBy('name', 'asc')->paginate(7)->withQueryString();
        return view('leader.index-user', ['title' => 'Data Anggota', 'users' => $user]);
    }

    public function createLeader()
    {
        $division =  User::select('division')->distinct()->whereNotNull('division')->pluck('division');
        return view('leader.create-user', ['title' => 'Tambah Anggota', 'divisions' => $division]);
    }

    public function storeLeader(LeaderStoreUserRequest $request)
    {
        $new_user = $request->validated();
        $new_user['division'] = Auth::user()->division;
        User::create($new_user);
        return Redirect::route('leader.users.index')->with('message', 'Data Berhasil Ditambahkan');
    }

    // public function showLeader() {}

    public function editLeader(User $user)
    {
        $division =  User::select('division')->distinct()->whereNotNull('division')->pluck('division');
        return view('leader.edit-user', ['title' => 'Edit Anggota', 'user' => $user, 'divisions' => $division]);
    }

    public function updateLeader(LeaderUpdateUserRequest $request, User $user)
    {
        $edit_user = $request->validated();
        if ($edit_user['address'] === null) {
            $edit_user['address'] = $user->address;
        }
        $edit_user['division'] = $user->division;
        $user->update($edit_user);
        return Redirect::route('leader.users.index')->with('message', 'Data Berhasil Ditambahkan');
    }

    public function destroyLeader(User $user)
    {
        $user->delete();
        return Redirect::route('leader.users.index')->with(['message' => 'Data Berhasil Di Hapus']);
    }

    public function excelLeader()
    {
        $filename = 'Data Anggota Divisi ' . Auth::user()->division . ' ' . Carbon::now()->translatedFormat('Y-m-d His');
        return Excel::download(new UsersExport, "$filename.xlsx");
    }

    public function pdfLeader()
    {
        $filename = 'Data Anggota Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
        $users = User::where(['division' => Auth::user()->division, 'role' => 'Member'])->orderBy('name', 'asc')->get();
        $pdf = Pdf::loadView('leader.pdf-user', ['users' => $users]);
        return $pdf->setPaper('A4', 'landscape')->download($filename . '.pdf');
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q');
        $divisi = User::where('divisi', 'like', '%' . $keyword . '%')->distinct()->orderBy('divisi')->limit(10)->pluck('divisi');
        return response()->json($divisi);
    }
}
