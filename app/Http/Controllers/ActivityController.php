<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ActivitiesExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'SuperAdmin') {
            $activity = Activity::latest()->with(['memberActivity']);
            return view(
                'admin.index-activity',
                [
                    'title' => 'Data Aktivitas',
                    'activities' => $activity->paginate(7)->withQueryString(),
                ]
            );
        } elseif ($user->role == 'Leader') {
            $activity = Activity::whereHas('memberActivity', function ($query) use ($user) {
                $query->where('division', $user->division);
            })->with('memberActivity')->latest()->paginate(7)->withQueryString();
            return view(
                'leader.index-activity',
                [
                    'title' => 'Data Aktivitas',
                    'activities' => $activity,
                ]
            );
        } else {
            $activity = Activity::where('user_id', $user->id)->with('memberActivity')->latest()->paginate(7)->withQueryString();
            return view(
                'member.index-activity',
                [
                    'title' => 'Data Aktivitas',
                    'activities' => $activity,
                ]
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'member.create-activity',
            [
                'title' => 'Tambah Aktivitas'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new_activity = $request->validate([
            'description' => 'required|string|max:255',
            'start_date' => 'required|date',
        ], [
            'description.required' => 'Detail aktivitas tidak boleh kosong',
            'description.max' => 'Detail aktivitas terlalu panjang',
            'start_date.required' => 'Tanggal pengerjaan tidak boleh kosong',
            'start_date.date' => 'Format tanggal tidak valid',
        ]);

        $new_activity['user_id'] = Auth::user()->id;
        $new_activity['start_date'] = Carbon::parse($new_activity['start_date'])->format('Y-m-d');

        Activity::create($new_activity);

        return Redirect::route('member.activities.index')->with('message', 'Data Berhasil Ditambahkan');
    }

    public function show(Activity $activity)
    {
        $user = Auth::user();
        if ($user->role == 'SuperAdmin') {
            return view('admin.view-activity', [
                'title' => 'Detail Aktivitas',
                'activity' => $activity
            ]);
        } elseif ($user->role == 'Leader') {
            return view('leader.view-activity', [
                'title' => 'Detail Aktivitas',
                'activity' => $activity
            ]);
        } else {
            return view('member.view-activity', [
                'title' => 'Detail Aktivitas',
                'activity' => $activity
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        return view('member.edit-activity', [
            'title' => 'Edit Aktivitas',
            'activity' => $activity
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $new_activity = $request->validate([
            'description' => 'required|string|max:1000',
            'start_date' => 'required|date',
        ], [
            'description.required' => 'Detail aktivitas tidak boleh kosong',
            'description.max' => 'Detail aktivitas terlalu panjang',
            'start_date.required' => 'Tanggal pengerjaan tidak boleh kosong',
            'start_date.date' => 'Format tanggal tidak valid',
        ]);

        $new_activity['user_id'] = Auth::user()->id;
        $new_activity['start_date'] = Carbon::parse($new_activity['start_date'])->format('Y-m-d');

        $activity->update($new_activity);

        return Redirect::route('member.activities.index')->with(['message' => 'Data Berhasil Di Update']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return Redirect::route('member.activities.index')->with(['message' => 'Data Berhasil Di Hapus']);
    }

    public function excel()
    {
        if (Auth::user()->role == 'SuperAdmin') {
            $filename = 'Data Aktivitas Karyawan Divisi '
                . implode(', ', User::pluck('division')->filter()->unique()->sort()->values()->toArray()) . ' ' . Carbon::now()->format('Y-m-d His');
            return Excel::download(new ActivitiesExport, "$filename.xlsx");
        } elseif (Auth::user()->role == 'Leader') {
            $filename = 'Data Aktivitas Anggota Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
            return Excel::download(new ActivitiesExport, "$filename.xlsx");
        } else {
            $filename = 'Data Aktivitas ' . Auth::user()->name .
                ' Divisi ' . Auth::user()->division .
                ' ' . Carbon::now()->format('Y-m-d His');
            return Excel::download(new ActivitiesExport, "$filename.xlsx");
        }
    }

    public function pdf()
    {
        if (Auth::user()->role == 'SuperAdmin') {
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
        } elseif (Auth::user()->role == 'Leader') {
            // Set title
            $title = 'Data Aktivitas Anggota Divisi ' . implode(', ', User::pluck('division')->filter()->unique()->sort()->values()->toArray()) . ' ';

            $activities = Activity::whereHas('memberActivity', function ($query) {
                $query->where('division', Auth::user()->division);
            })->with('memberActivity')->orderBy('created_at', 'asc')->get();

            $filename = 'Data Aktivitas Anggota Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
            $pdf = Pdf::loadView('leader.pdf-activity', ['activities' => $activities, 'title' => $title]);

            return $pdf->setPaper('A4', 'landscape')->download($filename . '.pdf');
        } else {
            // Set title
            $title = 'Data Aktivitas ' . Auth::user()->name . ' Divisi ' . Auth::user()->division . ' ';
            // Ambil data aktivitas
            $activities = Activity::where('user_id', Auth::user()->id)->with('memberActivity')->orderBy('created_at', 'asc')->get();
            // Set paper PDF & set name file
            $filename = 'Data Aktivitas ' . Auth::user()->name . ' Divisi ' . Auth::user()->division . ' ' . Carbon::now()->format('Y-m-d His');
            $pdf = Pdf::loadView('member.pdf-activity', ['activities' => $activities, 'title' => $title]);

            return $pdf->setPaper('A4', 'landscape')->download($filename . '.pdf');
        }
    }
}
