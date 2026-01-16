<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Activity;
use App\Enums\StatusTask;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ActivitiesExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Member\StoreActivityRequest;
use App\Http\Requests\Member\UpdateActivityRequest;

class ActivityController extends Controller
{
    public function indexSuperAdmin()
    {
        $activity = Activity::latest()->with(['memberActivity'])->paginate(7)->withQueryString();
        return view('admin.index-activity', ['title' => 'Data Aktivitas', 'activities' => $activity,]);
    }

    // public function createSuperAdmin() {}
    // // public function storeSuperAdmin() {}

    public function showSuperAdmin(Activity $activity)
    {
        return view('admin.view-activity', ['title' => 'Detail Aktivitas', 'activity' => $activity]);
    }

    // // public function editSuperAdmin(Activity $activity) {}
    // // public function updateSuperAdmin() {}
    // // public function destroySuperAdmin() {}

    public function excelSuperAdmin()
    {
        $filename = 'Data Aktivitas Karyawan Divisi '
            . implode(', ', User::pluck('division')->filter()->unique()->sort()->values()->toArray()) . ' ' . Carbon::now()->format('Y-m-d His');
        return Excel::download(new ActivitiesExport, "$filename.xlsx");
    }

    public function pdfSuperAdmin()
    {
        // Set title
        $title = 'Data Aktivitas Karyawan Divisi ' . implode(', ', User::pluck('division')->filter()->unique()->sort()->values()->toArray()) . ' ';
        // Ambil data aktivitas
        $activities = Activity::with(['memberActivity'])->orderBy('created_at', 'asc')->get();

        // Set paper PDF & load view
        $pdf = Pdf::loadView('admin.pdf-activity', ['activities' => $activities, 'title' => $title]);
        $pdf->setPaper('A4', 'landscape');
        // Set filename
        $filename = 'Data Aktivitas Karyawan Divisi '
            . implode(', ', User::pluck('division')->filter()->unique()->sort()->values()->toArray()) . ' ' . Carbon::now()->format('Y-m-d His');

        return $pdf->download($filename . '.pdf');
    }

    public function indexLeader()
    {
        $activity = Activity::whereHas('memberActivity', function ($query) {
            $query->where('division', Auth::user()->division);
        })->with('memberActivity')->latest()->paginate(7)->withQueryString();
        return view('leader.index-activity', ['title' => 'Data Aktivitas', 'activities' => $activity,]);
    }

    // // public function createLeader() {}
    // // public function storeLeader() {}

    public function showLeader(Activity $activity)
    {
        return view('leader.view-activity', ['title' => 'Detail Aktivitas', 'activity' => $activity]);
    }

    // // public function editLeader(Activity $activity) {}
    // // public function updateLeader() {}
    // // public function destroyLeader() {}

    public function excelLeader()
    {
        $filename = 'Data Aktivitas Anggota Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
        return Excel::download(new ActivitiesExport, "$filename.xlsx");
    }

    public function pdfLeader()
    {
        // Set title
        $title = 'Data Aktivitas Anggota Divisi ' . implode(', ', User::pluck('division')->filter()->unique()->sort()->values()->toArray()) . ' ';

        $activities = Activity::whereHas('memberActivity', function ($query) {
            $query->where('division', Auth::user()->division);
        })->with('memberActivity')->orderBy('created_at', 'asc')->get();

        $filename = 'Data Aktivitas Anggota Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
        $pdf = Pdf::loadView('leader.pdf-activity', ['activities' => $activities, 'title' => $title]);

        return $pdf->setPaper('A4', 'landscape')->download($filename . '.pdf');
    }

    public function indexMember()
    {
        $activity = Activity::where('user_id', Auth::user()->id)->with('memberActivity')->latest()->paginate(7)->withQueryString();
        return view('member.index-activity', ['title' => 'Data Aktivitas', 'activities' => $activity,]);
    }

    public function createMember()
    {
        return view('member.create-activity', ['title' => 'Tambah Aktivitas']);
    }

    public function storeMember(StoreActivityRequest $request)
    {
        $new_activity = $request->validated();

        $new_activity['user_id'] = Auth::user()->id;
        $new_activity['start_date'] = Carbon::parse($new_activity['start_date'])->format('Y-m-d');

        Activity::create($new_activity);

        return Redirect::route('member.activities.index')->with('message', 'Data Berhasil Ditambahkan');
    }

    public function showMember(Activity $activity)
    {
        return view('member.view-activity', ['title' => 'Detail Aktivitas', 'activity' => $activity]);
    }

    public function editMember(Activity $activity)
    {
        return view('member.edit-activity', ['title' => 'Edit Aktivitas', 'activity' => $activity]);
    }

    public function updateMember(UpdateActivityRequest $request, Activity $activity)
    {
        $new_activity = $request->validated();

        $new_activity['user_id'] = Auth::user()->id;
        $new_activity['start_date'] = Carbon::parse($new_activity['start_date'])->format('Y-m-d');

        $activity->update($new_activity);

        return Redirect::route('member.activities.index')->with(['message' => 'Data Berhasil Di Update']);
    }

    public function destroyMember(Activity $activity)
    {
        $activity->delete();
        return Redirect::route('member.activities.index')->with(['message' => 'Data Berhasil Di Hapus']);
    }

    public function excelMember()
    {
        $filename = 'Data Aktivitas ' . Auth::user()->name . ' Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
        return Excel::download(new ActivitiesExport, "$filename.xlsx");
    }

    public function pdfMember()
    {
        // Set title
        $title = 'Data Aktivitas ' . Auth::user()->name . ' Divisi ' . Auth::user()->division . ' ';
        // Ambil data aktivitas
        $activities = Activity::where('user_id', Auth::user()->id)->with('memberActivity')->orderBy('created_at', 'asc')->get();
        // Set paper PDF & set name file
        $filename = 'Data Aktivitas ' . Auth::user()->name . ' Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
        $pdf = Pdf::loadView('member.pdf-activity', ['activities' => $activities, 'title' => $title]);

        return $pdf->setPaper('A4', 'landscape')->download($filename . '.pdf');
    }

    public function startActivity(Activity $activity)
    {
        $activity->update(['status' => StatusTask::ON_PROGRESS->value]);

        if ($activity->task_id) {
            $activity->task->update(['status' => StatusTask::ON_PROGRESS->value]);
        }

        return Redirect::route('member.activities.index')->with('message', 'Data Berhasil Diubah');
    }

    public function continueActivity(Activity $activity)
    {
        $activity->update([
            'start_date' => Carbon::now()->format('Y-m-d'),
            'status' => StatusTask::ON_PROGRESS->value,
        ]);

        if ($activity->task_id) {
            $activity->task->update(['status' => StatusTask::ON_PROGRESS->value]);
        }

        return Redirect::route('member.activities.index')->with('message', 'Data Berhasil Diubah');
    }

    public function endActivity(Activity $activity)
    {
        $activity->update(['status' => StatusTask::SUCCESS->value]);

        if ($activity->task_id) {
            $activity->task->update(['status' => StatusTask::SUCCESS->value]);
        }

        return Redirect::route('member.activities.index')->with('message', 'Data Berhasil Diubah');
    }
}
