<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Console\Command;

class CheckTaskDeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-task-deadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        Task::whereNull('due_date')
            ->where('end_date', '<=', Carbon::now())
            ->update([
                'status' => \App\Enums\StatusTask::LATE->value,
                'due_date' => Carbon::now(),
            ]);
    }
}