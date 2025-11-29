<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $dataTask = Task::latest()->with(['leaderTask', 'memberTask']);
            return view(
                'admin.index-task',
                [
                    'title' => 'Data Tugas',
                    'tasks' => $dataTask->paginate(7)->withQueryString(),
                ]
            );
        } elseif ($user->role == 'Leader') {
            $dataTask = Task::latest()->with(['memberTask']);
            return view(
                'leader.index-task',
                [
                    'title' => 'Data Tugas',
                    'tasks' => $dataTask->paginate(7)->withQueryString(),
                ]
            );
            return view('leader.index-task', ['title' => 'Data Tugas']);
        } else {
            $dataTask = Task::latest()->with(['leaderTask']);
            return view(
                'member.index-task',
                [
                    'title' => 'Data Tugas',
                    'tasks' => $dataTask->paginate(7)->withQueryString(),
                ]
            );
            return view('member.index-task', ['title' => 'Data Tugas']);
        }
    }

    public function create()
    {
        $user = Auth::user()->division;
        $member = User::where('division', $user)->orderBy('name', 'asc')->get();
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
        $user = Auth::user()->division;
        $member = User::where('division', $user)->orderBy('name', 'asc')->get();
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

    // public function excel(Task $task)
    // {
    //     return Excel::download(new ActitaskExport($task), 'actitask.xlsx');
    // }

    // public function pdf(Task $task)
    // {
    //     return PDF::download(new ActitaskExport($task), 'actitask.pdf');
    // }
}
