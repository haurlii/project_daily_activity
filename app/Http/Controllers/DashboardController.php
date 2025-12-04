<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function indexAdmin()
    {
        $totalUsers   = User::count();
        $totalLeaders = User::where('role', 'leader')->count();
        $totalMembers = User::where('role', 'member')->count();

        $assignedMembers    = User::where('role', 'member')->whereHas('memberTasks')->count();
        $unassignedMembers  = User::where('role', 'member')->whereDoesntHave('memberTasks')->count();

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
        $sameDivMembers = User::where('division', $user->division)->where('role', 'member')->count();

        $assignedMembers    = User::where('role', 'member')->where('division', $user->division)->whereHas('memberTasks')->count();
        $unassignedMembers  = User::where('role', 'member')->where('division', $user->division)->whereDoesntHave('memberTasks')->count();

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
        $auth = Auth::user();
        $user = Task::where('member_id', $auth->id)->first();
        $assignedStatus = $user != null ? 'Assigned' : 'Unassigned';

        $submitted = Activity::where('user_id', $auth->id)->count();

        $title = 'Dashboard';

        return view('member.dashboard', compact(
            'title',
            'assignedStatus',
            'submitted',
        ));
    }
}
