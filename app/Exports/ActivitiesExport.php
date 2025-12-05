<?php

namespace App\Exports;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivitiesExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        if (Auth::user()->role == 'SuperAdmin') {
            return Activity::query()->with(['memberActivity']);
        } elseif (Auth::user()->role == 'Leader') {
            return Activity::query()->whereHas('memberActivity', function ($query) {
                $query->where('division', Auth::user()->division);
            })->with('memberActivity');
        } else {
            // Member
            return Activity::query()->where('user_id', Auth::user()->id);
        }
    }

    public function headings(): array
    {
        if (Auth::user()->role == 'SuperAdmin') {
            return ['Tanggal Aktivitas', 'Nama Karyawan', 'Divisi', 'Tugas'];
        } elseif (Auth::user()->role == 'Leader') {
            return ['Tanggal Aktivitas', 'Nama Karyawan', 'Tugas'];
        } else {
            return ['Tanggal Aktivitas', 'Tugas'];
        }
    }

    public function map($activity): array
    {
        if (Auth::user()->role == 'SuperAdmin') {
            return [$activity->start_date, $activity->memberActivity->name, $activity->memberActivity->division, $activity->description];
        } elseif (Auth::user()->role == 'Leader') {
            return [$activity->start_date, $activity->memberActivity->name, $activity->description];
        } else {
            return [$activity->start_date, $activity->description];
        }
    }
}
