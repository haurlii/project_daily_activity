<?php

namespace App\Http\Controllers;

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

        $assignedMembers    = User::where('role', 'member')->where('is_assigned', 1)->count();
        $unassignedMembers  = User::where('role', 'member')->where('is_assigned', 0)->count();

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
        $sameDivUsers   = User::where('divisi', $user->divisi)->count();
        $sameDivMembers = User::where('divisi', $user->divisi)->where('role', 'member')->count();

        $assignedMembers    = User::where('divisi', $user->divisi)->where('role', 'member')->where('is_assigned', 1)->count();
        $unassignedMembers  = User::where('divisi', $user->divisi)->where('role', 'member')->where('is_assigned', 0)->count();

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
        $assignedStatus = $user->is_assigned;

        $submitted = Activity::where('user_id', $user->id)->where('status', 'submitted')->count();
        $inProgress = Activity::where('user_id', $user->id)->where('status', 'in_progress')->count();
        $done = Activity::where('user_id', $user->id)->where('status', 'done')->count();

        $title = 'Dashboard';
        return view('dashboard.member', compact(
            'title',
            'assignedStatus',
            'submitted',
            'inProgress',
            'done'
        ));
    }
}
