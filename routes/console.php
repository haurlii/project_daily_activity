<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('app:check-task-deadline', function () {
    $this->call(\App\Console\Commands\CheckTaskDeadline::class);
})->purpose('Check and update task deadlines');

Schedule::command('app:check-task-deadline')->everyMinute();