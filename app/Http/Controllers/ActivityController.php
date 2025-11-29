<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $dataActivity = Activity::latest()->with(['memberActivity']);
            return view(
                'admin.index-activity',
                [
                    'title' => 'Data Aktivitas',
                    'activities' => $dataActivity->paginate(7)->withQueryString(),
                ]
            );
        } elseif ($user->role == 'Leader') {
            $dataActivity = Activity::latest()->with(['memberActivity']);
            return view(
                'leader.index-activity',
                [
                    'title' => 'Data Aktivitas',
                    'activities' => $dataActivity->paginate(7)->withQueryString(),
                ]
            );
        } else {
            $dataActivity = Activity::latest();
            return view(
                'member.index-activity',
                [
                    'title' => 'Data Aktivitas',
                    'activities' => $dataActivity->paginate(7)->withQueryString(),
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

    // public function excel(Activity $activity)
    // {
    //     return Excel::download(new ActivityExport($activity), 'activity.xlsx');
    // }

    // public function pdf(Activity $activity)
    // {
    //     return PDF::download(new ActivityExport($activity), 'activity.pdf');
    // }
}
