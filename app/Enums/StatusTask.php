<?php

namespace App\Enums;

enum StatusTask: string
{
    case PENDING = 'Tertunda';
    case ON_PROGRESS = 'Sedang Dikerjakan';
    case CHECKED = 'Sedang Diperiksa';
    case COMPLETED = 'Selesai';
}
