<?php

namespace App\Enums;

enum StatusTask: string
{
    case PENDING = 'Tertunda';
    case NOT_STARTED = 'Belum Dikerjakan';
    case ON_PROGRESS = 'Sedang Dikerjakan';
    case LATE = 'Terlambat';
    case CHECKED = 'Sedang Diperiksa';
    case SUCCESS = 'Selesai';
}