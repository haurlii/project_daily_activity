<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Exports\TasksExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'SuperAdmin') {
            $task = Task::latest()->with(['leaderTask', 'memberTask'])->paginate(7)->withQueryString();

            return view('admin.index-task', ['title' => 'Data Tugas', 'tasks' => $task]);
        } elseif ($user->role == 'Leader') {
            $task = Task::whereHas('memberTask', function ($query) use ($user) {
                $query->where('division', $user->division);
            })->with('memberTask')->latest()->paginate(7)->withQueryString();

            return view('leader.index-task', ['title' => 'Data Tugas', 'tasks' => $task]);
        } else {
            $task = Task::where('member_id', $user->id)->with('memberTask')->latest()->paginate(7)->withQueryString();

            return view('member.index-task', ['title' => 'Data Tugas', 'tasks' => $task]);
        }
    }

    public function create()
    {
        $member = User::where(['division' => Auth::user()->division, 'role' => 'Member'])->orderBy('name', 'asc')->get();
        return view('leader.create-task', ['title' => 'Tambah Tugas', 'members' => $member]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $new_task = $request->validate([
            'member_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date',

        ], [
            'member_id.required' => 'Harus pilih salah satu anggota',
            'title.required' => 'Judul tidak boleh kosong',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'description.max' => 'Deskripsi tidak boleh lebih dari 1000 karakter',
            'start_date.required' => 'Tanggal mulai tidak boleh kosong',
            'end_date.required' => 'Tanggal selesai tidak boleh kosong',
        ]);

        $new_task['leader_id'] = $user->id;
        $new_task['start_date'] = Carbon::parse($new_task['start_date'])->format('Y-m-d');
        $new_task['end_date'] = Carbon::parse($new_task['end_date'])->format('Y-m-d');

        Task::create($new_task);

        return Redirect::route('leader.tasks.index')->with('message', 'Data Berhasil Ditambahkan');
    }

    public function show(Task $task)
    {
        $user = Auth::user();
        if ($user->role == 'SuperAdmin') {
            return view('admin.view-task', [
                'title' => 'Detail Tugas',
                'task' => $task
            ]);
        } elseif ($user->role == 'Leader') {
            return view('leader.view-task', [
                'title' => 'Detail Tugas',
                'task' => $task
            ]);
        } else {
            return view('member.view-task', [
                'title' => 'Detail Tugas',
                'task' => $task
            ]);
        }
    }

    public function edit(Task $task)
    {
        // $member = User::select('name')->where('id', $task->memberTask->id)->first();
        // dd($member->name);
        $member = User::where(['division' => Auth::user()->division, 'role' => 'Member'])->orderBy('name', 'asc')->get();
        return view('leader.edit-task', [
            'title' => 'Edit Tugas',
            'task' => $task,
            'members' => $member
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $user = Auth::user();
        $new_task = $request->validate([
            'member_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date',

        ], [
            'member_id.required' => 'Harus pilih salah satu anggota',
            'title.required' => 'Judul tidak boleh kosong',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'description.max' => 'Deskripsi tidak boleh lebih dari 1000 karakter',
            'start_date.required' => 'Tanggal mulai tidak boleh kosong',
            'end_date.required' => 'Tanggal selesai tidak boleh kosong',
        ]);

        $new_task['leader_id'] = $user->id;
        $new_task['start_date'] = Carbon::parse($new_task['start_date'])->format('Y-m-d');
        $new_task['end_date'] = Carbon::parse($new_task['end_date'])->format('Y-m-d');

        $task->update($new_task);

        return Redirect::route('leader.tasks.index')->with('message', 'Data Berhasil Di Update');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return Redirect::route('leader.tasks.index')->with(['message' => 'Data Berhasil Di Hapus']);
    }

    public function excel()
    {
        if (Auth::user()->role == 'SuperAdmin') {
            $filename = 'Data Tugas Karyawan Divisi '
                . implode(', ', User::pluck('division')->filter()->unique()->sort()->values()->toArray())
                . ' '
                . Carbon::now()->format('Y-m-d His');
            return Excel::download(new TasksExport, "$filename.xlsx");
        } elseif (Auth::user()->role == 'Leader') {
            $filename = 'Data Tugas Anggota Divisi ' . Auth::user()->divisi . ' ' . Carbon::now()->format('Y-m-d His');
            return Excel::download(new TasksExport, "$filename.xlsx");
        } else {
            $filename = 'Data Tugas ' . Auth::user()->name .
                ' Divisi ' . Auth::user()->divisi .
                ' ' . Carbon::now()->format('Y-m-d His');
            return Excel::download(new TasksExport, "$filename.xlsx");
        }
    }

    // public function pdf()
    // {
    //     if (Auth::user()->role == 'SuperAdmin') {
    //         $filename = 'Data Karyawan ' . Carbon::now()->format('Y-m-d His');
    //         $data = array(
    //             'user' => User::orderBy('jabatan', 'asc')->get(),
    //             'tanggal' => now()->format('d-m-Y'),
    //             'jam' => now()->format('H.i.s'),
    //         );
    //         // $pdf = Pdf::loadView('admin/user/pdf', $data);
    //         // return $pdf->setPaper('a4', 'landscape')->download($filename . '.pdf');
    //     } else {
    //         $filename = 'Data Anggota Divisi ' . Auth::user()->divisi . ' ' . Carbon::now()->format('Y-m-d His');
    //         $data = array(
    //             'user' => User::orderBy('jabatan', 'asc')->where('divisi', Auth::user()->divisi)->get(),
    //             'tanggal' => now()->format('d-m-Y'),
    //             'jam' => now()->format('H.i.s'),
    //         );
    //         // $pdf = Pdf::loadView('admin/user/pdf', $data);
    //         // return $pdf->setPaper('a4', 'landscape')->download($filename . '.pdf');
    //     }
    // }
}
