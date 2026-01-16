<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Activity;
use App\Enums\StatusTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function indexAdmin()
    {
        $totalUsers   = User::count();
        $totalLeaders = User::where('role', 'Leader')->count();
        $totalMembers = User::where('role', 'Member')->count();

        $assignedMembers    = User::where('role', 'Member')->whereHas('memberTasks', function ($status) {
            $status->whereNot('status', StatusTask::SUCCESS->value);
        })->count();
        $unassignedMembers  = User::where('role', 'Member')->whereDoesntHave('memberTasks')->orWhereHas('memberTasks', function ($status) {
            $status->where('status', StatusTask::SUCCESS->value);
        })->count();

        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'totalUsers' => $totalUsers,
            'totalLeaders' => $totalLeaders,
            'totalMembers' => $totalMembers,
            'assignedMembers' => $assignedMembers,
            'unassignedMembers' => $unassignedMembers,
        ]);
    }

    public function indexLeader()
    {
        $user = Auth::user();
        $sameDivUsers   = User::where('division', $user->division)->count();
        $sameDivMembers = User::where(['division' => $user->division, 'role' => 'Member'])->count();

        $assignedMembers    = User::where(['role' => 'Member', 'division' => $user->division])->whereHas('memberTasks', function ($status) {
            $status->whereNot('status', StatusTask::SUCCESS->value);
        })->count();
        $unassignedMembers  = User::where(['role' => 'Member', 'division' => $user->division])->whereDoesntHave('memberTasks')->orwhereHas('memberTasks', function ($status) {
            $status->where('status', StatusTask::SUCCESS->value);
        })->count();

        $title = 'Dashboard';
        return view('leader.dashboard', compact(
            'title',
            'sameDivUsers',
            'sameDivMembers',
            'assignedMembers',
            'unassignedMembers'
        ));
    }

    public function indexMember()
    {
        $user = Auth::user();
        $task = Task::where('member_id', $user->id)->whereNot('status', StatusTask::SUCCESS->value)->exists();
        $assignedStatus = $task != null ? 'Assigned' : 'Unassigned';

        $submitted = Activity::where('user_id', $user->id)->count();

        $title = 'Dashboard';

        return view('member.dashboard', compact(
            'title',
            'assignedStatus',
            'submitted',
        ));
    }
}
