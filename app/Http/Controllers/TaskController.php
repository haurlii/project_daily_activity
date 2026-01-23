<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Activity;
use App\Enums\StatusTask;
use App\Exports\TasksExport;
use App\Http\Requests\Leader\StoreTaskRequest;
use App\Http\Requests\Leader\UpdateTaskRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    public function indexSuperAdmin()
    {
        $task = Task::latest()->with(['leaderTask', 'memberTask'])->paginate(7)->withQueryString();
        return view('admin.index-task', ['title' => 'Data Tugas', 'tasks' => $task]);
    }

    // public function createSuperAdmin() {}
    // public function storeSuperAdmin() {}
    public function showSuperAdmin(Task $task)
    {
        return view('admin.view-task', ['title' => 'Detail Tugas', 'task' => $task]);
    }

    // public function editSuperAdmin() {}
    // public function updateSuperAdmin() {}
    // public function destroySuperAdmin() {}

    public function excelSuperAdmin()
    {
        $filename = 'Data Tugas Karyawan Divisi ' . implode(', ', User::pluck('division')->filter()->unique()->sort()->values()->toArray()) . ' ' . Carbon::now()->format('Y-m-d His');
        return Excel::download(new TasksExport, "$filename.xlsx");
    }

    public function pdfSuperAdmin()
    {
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
    }

    public function indexLeader()
    {
        $task = Task::whereHas('memberTask', function ($query) {
            $query->where('division', Auth::user()->division);
        })->with('memberTask')->latest()->paginate(7)->withQueryString();
        return view('leader.index-task', ['title' => 'Data Tugas', 'tasks' => $task]);
    }

    public function createLeader()
    {
        $member = User::where(['division' => Auth::user()->division, 'role' => 'Member'])->orderBy('name', 'asc')->get();
        return view('leader.create-task', ['title' => 'Tambah Tugas', 'members' => $member]);
    }

    public function storeLeader(StoreTaskRequest $request)
    {
        $new_task = $request->validated();
        $new_task['leader_id'] = Auth::user()->id;
        $new_task['start_date'] = Carbon::parse($new_task['start_date'])->format('Y-m-d');
        $new_task['end_date'] = Carbon::parse($new_task['end_date'])->format('Y-m-d');
        // $check = Activity::where(['user_id' => $new_task['member_id'], 'status' => StatusTask::ON_PROGRESS->value])->whereNull('task_id')->first();
        // dd($check);
        // dd($new_task['member_id']);
        Task::create($new_task);
        return Redirect::route('leader.tasks.index')->with('message', 'Data Berhasil Ditambahkan');
    }

    public function showLeader(Task $task)
    {
        return view('leader.view-task', ['title' => 'Detail Tugas', 'task' => $task]);
    }

    public function editLeader(Task $task)
    {
        $member = User::where(['division' => Auth::user()->division, 'role' => 'Member'])->orderBy('name', 'asc')->get();
        return view('leader.edit-task', ['title' => 'Edit Tugas', 'task' => $task, 'members' => $member]);
    }

    public function updateLeader(UpdateTaskRequest $request, Task $task)
    {
        $new_task = $request->validated();
        if ($new_task['description'] === null) {
            $new_task['description'] = $task->description;
        }
        $new_task['leader_id'] = Auth::user()->id;
        $new_task['start_date'] = Carbon::parse($new_task['start_date'])->format('Y-m-d');
        $new_task['end_date'] = Carbon::parse($new_task['end_date'])->format('Y-m-d');
        $task->update($new_task);
        return Redirect::route('leader.tasks.index')->with('message', 'Data Berhasil Di Update');
    }

    public function destroyLeader(Task $task)
    {
        $task->delete();
        return Redirect::route('leader.tasks.index')->with(['message' => 'Data Berhasil Di Hapus']);
    }

    public function excelLeader()
    {
        $filename = 'Data Tugas Anggota Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
        return Excel::download(new TasksExport, "$filename.xlsx");
    }

    public function pdfLeader()
    {
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
    }

    public function indexMember()
    {
        $task = Task::where('member_id', Auth::user()->id)->with('memberTask')->latest()->paginate(7)->withQueryString();
        return view('member.index-task', ['title' => 'Data Tugas', 'tasks' => $task]);
    }

    public function showMember(Task $task)
    {
        return view('member.view-task', ['title' => 'Detail Tugas', 'task' => $task]);
    }

    public function excelMember()
    {
        $filename = 'Data Tugas ' . Auth::user()->name . ' Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
        return Excel::download(new TasksExport, "$filename.xlsx");
    }

    public function pdfMember()
    {
        // Set title
        $title = 'Data Tugas ' . Auth::user()->name . ' Divisi ' . Auth::user()->division . ' ';
        // Ambil data tugas
        $tasks = Task::where('member_id', Auth::user()->id)->with('memberTask')->orderBy('created_at', 'asc')->get();
        // Set paper PDF & set name file
        $filename = 'Data Tugas ' . Auth::user()->name . ' Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
        $pdf = Pdf::loadView('member.pdf-task', ['tasks' => $tasks, 'title' => $title]);
        return $pdf->setPaper('A4', 'landscape')->download($filename . '.pdf');
    }

    public function startActivity(Task $task)
    {
        DB::transaction(function () use ($task) {
            // 1. member buat activity
            Activity::create([
                'user_id'    => Auth::user()->id,
                'title'    => $task->title,
                'description' => $task->description,
                'start_date' => Carbon::now()->format('Y-m-d'),
                'status' => StatusTask::ON_PROGRESS->value,
                'task_id'    => $task->id,
            ]);
            // 2. update status task
            $task->update(['status' => StatusTask::ON_PROGRESS->value]);
        });
        return Redirect::route('member.activities.index')->with('message', 'Data Berhasil Ditambahkan');
    }

    public function continueActivity(Task $task)
    {
        DB::transaction(function () use ($task) {
            // memcari aktivitas yg terhubung dengan tugas
            $activity = Activity::where('task_id', $task->id)->where('user_id', Auth::user()->id)->firstOrFail();
            // 1. member buat activity
            $activity->update(['start_date' => Carbon::now()->format('Y-m-d'), 'status' => StatusTask::ON_PROGRESS->value,]);
            // 2. update status task
            $task->update(['status' => StatusTask::ON_PROGRESS->value]);
        });
        return Redirect::route('member.activities.index')->with('message', 'Data Berhasil Diubah');
    }

    public function endActivity(Task $task)
    {
        DB::transaction(function () use ($task) {
            // mencari aktivitas yg terhubung dengan tugas
            $activity = Activity::where('task_id', $task->id)->where('user_id', Auth::user()->id)->firstOrFail();
            // 1. buat activity
            $activity->update(['status' => StatusTask::ON_PROGRESS->value]);
            // 2. update status task
            $task->update(['status' => StatusTask::SUCCESS->value]);
        });
        return Redirect::route('member.activities.index')->with('message', 'Data Berhasil Diubah');
    }
}