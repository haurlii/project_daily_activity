<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Exports\TasksExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $task = Auth::user();
        if ($task->role == 'SuperAdmin') {
            $task = Task::latest()->with(['leaderTask', 'memberTask'])->paginate(7)->withQueryString();

            return view('admin.index-task', ['title' => 'Data Tugas', 'tasks' => $task]);
        } elseif ($task->role == 'Leader') {
            $task = Task::whereHas('memberTask', function ($query) use ($task) {
                $query->where('division', $task->division);
            })->with('memberTask')->latest()->paginate(7)->withQueryString();

            return view('leader.index-task', ['title' => 'Data Tugas', 'tasks' => $task]);
        } else {
            $task = Task::where('member_id', $task->id)->with('memberTask')->latest()->paginate(7)->withQueryString();

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
        $task = Auth::user();
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

        $new_task['leader_id'] = $task->id;
        $new_task['start_date'] = Carbon::parse($new_task['start_date'])->format('Y-m-d');
        $new_task['end_date'] = Carbon::parse($new_task['end_date'])->format('Y-m-d');

        Task::create($new_task);

        return Redirect::route('leader.tasks.index')->with('message', 'Data Berhasil Ditambahkan');
    }

    public function show(Task $task)
    {
        $task = Auth::user();
        if ($task->role == 'SuperAdmin') {
            return view('admin.view-task', [
                'title' => 'Detail Tugas',
                'task' => $task
            ]);
        } elseif ($task->role == 'Leader') {
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
        $task = Auth::user();
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

        $new_task['leader_id'] = $task->id;
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
            $filename = 'Data Tugas Anggota Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
            return Excel::download(new TasksExport, "$filename.xlsx");
        } else {
            $filename = 'Data Tugas ' . Auth::user()->name .
                ' Divisi ' . Auth::user()->division .
                ' ' . Carbon::now()->format('Y-m-d His');
            return Excel::download(new TasksExport, "$filename.xlsx");
        }
    }

    public function pdf()
    {
        if (Auth::user()->role == 'SuperAdmin') {
            // Set title
            $title = 'Data Tugas Karyawan Divisi ' . implode(', ', User::pluck('division')->filter()->unique()->sort()->values()->toArray()) . ' ';
            // Ambil data tugas
            $tasks = Task::with(['leaderTask', 'memberTask'])->orderBy('created_at', 'asc')->get();

            // Set paper PDF & load view
            $pdf = Pdf::loadView('admin.pdf-task', ['tasks' => $tasks, 'title' => $title]);
            $pdf->setPaper('A4', 'landscape');
            // Set filename
            $filename = 'Data Tugas Karyawan Divisi '
                . implode(', ', User::pluck('division')->filter()->unique()->sort()->values()->toArray()) . ' ' . Carbon::now()->format('Y-m-d His');

            return $pdf->download($filename . '.pdf');
        } elseif (Auth::user()->role == 'Leader') {
            // Set title
            $title = 'Data Tugas Anggota Divisi ' . implode(', ', User::pluck('division')->filter()->unique()->sort()->values()->toArray()) . ' ';
            // Ambil data tugas
            $tasks = Task::whereHas('memberTask', function ($query) {
                $query->where('division', Auth::user()->division);
            })->with('memberTask')->orderBy('created_at', 'asc')->get();
            // Set paper PDF & set name file
            $filename = 'Data Tugas Anggota Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
            $pdf = Pdf::loadView('leader.pdf-task', ['tasks' => $tasks, 'title' => $title]);

            return $pdf->setPaper('A4', 'landscape')->download($filename . '.pdf');
        } else {
            // Set title
            $title = 'Data Tugas ' . Auth::user()->name . ' Divisi ' . Auth::user()->division . ' ';
            // Ambil data tugas
            $tasks = Task::where('member_id', Auth::user()->id)->with('memberTask')->orderBy('created_at', 'asc')->get();
            // Set paper PDF & set name file
            $filename = 'Data Tugas ' . Auth::user()->name . ' Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
            $pdf = Pdf::loadView('member.pdf-task', ['tasks' => $tasks, 'title' => $title]);

            return $pdf->setPaper('A4', 'landscape')->download($filename . '.pdf');
        }
    }
}
