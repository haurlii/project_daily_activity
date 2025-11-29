<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'SuperAdmin') {
            $dataUser = User::where('role', '!=', 'SuperAdmin')->orderBy('name', 'asc');
            return view('admin.index-user', ['title' => 'Data Karyawan', 'users' => $dataUser->paginate(7)->withQueryString()]);
        } else {
            $dataUser = User::where('division', Auth::user()->division)->orderBy('name', 'asc');
            return view('leader.index-user', ['title' => 'Data Anggota', 'users' => $dataUser->paginate(7)->withQueryString()]);
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q');

        $divisi = User::where('divisi', 'like', '%' . $keyword . '%')
            ->distinct()
            ->orderBy('divisi')
            ->limit(10)
            ->pluck('divisi');

        return response()->json($divisi);
    }

    public function create()
    {
        if (Auth::user()->role == 'SuperAdmin') {
            $division =  User::select('division')->distinct()->whereNotNull('division')->pluck('division');
            return view('admin.create-user', ['title' => 'Tambah Karyawan', 'divisions' => $division]);
        } else {
            $division =  User::select('division')->distinct()->whereNotNull('division')->pluck('division');
            return view('leader.create-user', ['title' => 'Tambah Anggota', 'divisions' => $division]);
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role == 'SuperAdmin') {
            $new_user = $request->validate([
                'name' => 'required|string',
                'username' => 'required|string|unique:users,username',
                'email' => 'required|email:dns|unique:users,email',
                'address' => 'nullable|string',
                'contact' => 'nullable|string|max:13',
                'role' => 'required',
                'division' => 'required',
                'password' => 'required|confirmed|alpha_num:ascii|min:8',

            ], [
                'name.required' => 'Nama tidak boleh kosong',
                'username.required' => 'Username tidak boleh kosong',
                'username.unique' => 'Username sudah ada',
                'email.required' => 'Email tidak boleh kosong',
                'email.unique' => 'Email sudah ada',
                'contact.max' => 'Nomer telepon maksimal 13 karakter',
                'role.required' => 'Harus memilih posisi',
                'division.required' => 'Harus memilih divisi',
                'password.required' => 'Kata sandi tidak boleh kosong',
                'password.confirmed' => 'Kata sandi konfirmasi tidak sama',
                'password.min' => 'Kata sandi minimal 8 karakter',
            ]);

            User::create($new_user);
            return Redirect::route('admin.users.index')->with('message', 'Data Berhasil Ditambahkan');
        } else if ($user->role == 'Leader') {
            $new_user = $request->validate([
                'name' => 'required|string',
                'username' => 'required|string|unique:users,username',
                'email' => 'required|email:dns|unique:users,email',
                'address' => 'nullable|string',
                'contact' => 'nullable|string|max:13',
                'password' => 'required|alpha_num:ascii|min:8',

            ], [
                'name.required' => 'Nama tidak boleh kosong',
                'username.required' => 'Username tidak boleh kosong',
                'username.unique' => 'Username sudah ada',
                'email.required' => 'Email tidak boleh kosong',
                'email.unique' => 'Email sudah ada',
                'contact.max' => 'Nomer telepon maksimal 13 karakter',
                'password.required' => 'Kata sandi tidak boleh kosong',
                'password.min' => 'Kata sandi minimal 8 karakter',
            ]);

            $new_user['division'] = $user->division;

            User::create($new_user);

            return Redirect::route('leader.users.index')->with('message', 'Data Berhasil Ditambahkan');
        }
    }

    public function edit(User $user)
    {
        if (Auth::user()->role == 'SuperAdmin') {
            $division =  User::select('division')->distinct()->whereNotNull('division')->pluck('division');
            return view('admin.edit-user', ['title' => 'Edit Karyawan', 'user' => $user, 'divisions' => $division]);
        } else {
            $division =  User::select('division')->distinct()->whereNotNull('division')->pluck('division');
            return view('leader.edit-user', ['title' => 'Edit Anggota', 'user' => $user, 'divisions' => $division]);
        }
    }

    public function update(Request $request, User $user)
    {
        if (Auth::user()->role == 'SuperAdmin') {
            $edit_user = $request->validate([
                'name' => 'required|string',
                'address' => 'nullable|string',
                'contact' => 'nullable|string|max:13',
                'role' => 'required',
                'division' => 'required',

            ], [
                'name.required' => 'Nama tidak boleh kosong',
                'contact.max' => 'Nomer telepon maksimal 13 karakter',
                'role.required' => 'Harus memilih salah satu posisi',
                'division.required' => 'Harus memilih salah satu divisi',
            ]);

            $user->update($edit_user);
            return Redirect::route('admin.users.index')->with('message', 'Data Berhasil Ditambahkan');
        } else {
            $edit_user = $request->validate([
                'name' => 'required|string',
                'address' => 'nullable|string',
                'contact' => 'nullable|string|max:13',
            ], [
                'name.required' => 'Nama tidak boleh kosong',
                'contact.max' => 'Nomer telepon maksimal 13 karakter',
            ]);

            $edit_user['division'] = $user->division;

            $user->update($edit_user);
            return Redirect::route('leader.users.index')->with('message', 'Data Berhasil Ditambahkan');
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        if (Auth::user()->role == 'SuperAdmin') {
            return Redirect::route('leader.tasks.index')->with(['message' => 'Data Berhasil Di Hapus']);
        } else {
            return Redirect::route('leader.tasks.index')->with(['message' => 'Data Berhasil Di Hapus']);
        }
    }

    // public function excel()
    // {
    //     $user = Auth::user();
    //     if ($user->role == 'SuperAdmin') {
    //         $filename = now()->format('d-m-Y_H.i.s');
    //         return Excel::download(new UsersExport, 'DataUser_' . $filename . '.xlsx');
    //     } elseif ($user->role == 'Admin') {
    //         $filename = now()->format('d-m-Y_H.i.s');
    //         return Excel::download(new UsersExport, 'DataUser_' . $user->divisi . '_' . $filename . '.xlsx');
    //     } else {
    //         return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk mengunduh data user.');
    //     }
    // }
    // public function pdf()
    // {
    //     $user = Auth::user();
    //     if ($user->role == 'SuperAdmin') {
    //         $filename = now()->format('d-m-Y_H.i.s');
    //         $data = array(
    //             'user' => User::orderBy('jabatan', 'asc')->get(),
    //             'tanggal' => now()->format('d-m-Y'),
    //             'jam' => now()->format('H.i.s'),
    //         );
    //         $pdf = Pdf::loadView('admin/user/pdf', $data);
    //         return $pdf->setPaper('a4', 'landscape')->download('DataUser_' . $filename . '.pdf');
    //     } elseif ($user->role == 'Admin') {
    //         $filename = now()->format('d-m-Y_H.i.s');
    //         $data = array(
    //             'user' => User::orderBy('jabatan', 'asc')->where('divisi', $user->divisi)->get(),
    //             'tanggal' => now()->format('d-m-Y'),
    //             'jam' => now()->format('H.i.s'),
    //         );
    //         $pdf = Pdf::loadView('admin/user/pdf', $data);
    //         return $pdf->setPaper('a4', 'landscape')->download('DataUser_' . $user->divisi . '_' . $filename . '.pdf');
    //     } else {
    //         return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk mengunduh data user.');
    //     }
    // }
}
