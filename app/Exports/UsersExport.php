<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        if (Auth::user()->role == 'SuperAdmin') {
            return User::query()->where('role', '!=', 'SuperAdmin')->orderBy('name', 'asc');
        }

        return User::query()->where(['division' => Auth::user()->division, 'role' => 'Member'])->orderBy('name', 'asc');
    }

    public function headings(): array
    {
        if (Auth::user()->role == 'SuperAdmin') {
            return ['Nama', 'Email', 'Alamat', 'Kontak', 'Posisi', 'Divisi'];
        }

        return ['Nama', 'Email', 'Alamat', 'Kontak'];
    }

    public function map($user): array
    {
        if (Auth::user()->role == 'SuperAdmin') {
            return [$user->name, $user->email, $user->address, $user->contact, $user->role, $user->division];
        }

        return [$user->name, $user->email, $user->address, $user->contact];
    }
}
