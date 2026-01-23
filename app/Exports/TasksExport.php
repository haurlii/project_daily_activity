<?php

namespace App\Exports;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TasksExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        if (Auth::user()->role == 'SuperAdmin') {
            return Task::query()->with(['leaderTask', 'memberTask']);
        } elseif (Auth::user()->role == 'Leader') {
            return Task::query()->whereHas('memberTask', function ($query) {
                $query->where('division', Auth::user()->division);
            })->with('memberTask');
        } else {
            return Task::query()->where('member_id', Auth::user()->id)->with('memberTask');
        }
    }

    public function headings(): array
    {
        if (Auth::user()->role == 'SuperAdmin') {
            return [
                'Nama Leader',
                'Nama Anggota',
                'Divisi',
                'Judul Tugas',
                'Detail Tugas',
                'Tanggal Pengerjaan',
                'Batas Pengerjaan',
                'Status',
            ];
        } elseif (Auth::user()->role == 'Leader') {
            return [
                'Nama Anggota',
                'Tugas',
                'Detail Tugas',
                'Tanggal Pengerjaan',
                'Batas Pengerjaan',
                'Status',
            ];
        } else {
            // Member
            return [
                'Nama Leader',
                'Judul Tugas',
                'Detail Tugas',
                'Tanggal Pengerjaan',
                'Batas Pengerjaan',
                'Status',
            ];
        }
    }

    public function map($task): array
    {
        if (Auth::user()->role == 'SuperAdmin') {
            return [
                $task->leaderTask->name,
                $task->memberTask->name,
                $task->memberTask->division,
                $task->title,
                $task->description,
                $task->start_date->translatedFormat('d F Y'),
                $task->end_date->translatedFormat('d F Y'),
                $task->status,
            ];
        } elseif (Auth::user()->role == 'Leader') {
            return [
                $task->memberTask->name,
                $task->title,
                $task->description,
                $task->start_date->translatedFormat('d F Y'),
                $task->end_date->translatedFormat('d F Y'),
                $task->status,
            ];
        } else {
            // Member
            return [
                $task->leaderTask->name,
                $task->title,
                $task->description,
                $task->start_date->translatedFormat('d F Y'),
                $task->end_date->translatedFormat('d F Y'),
                $task->status,
            ];
        }
    }
}
