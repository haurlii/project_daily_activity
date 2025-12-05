<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @if (auth()->user()->role==="SuperAdmin")
    @props(['totalUsers', 'totalLeaders', 'totalMembers', 'assignedMembers', 'unassignedMembers'])
    <x-admins.dashboard
        :totalUsers="$totalUsers"
        :totalLeaders="$totalLeaders"
        :totalMembers="$totalMembers"
        :assignedMembers="$assignedMembers"
        :unassignedMembers="$unassignedMembers" />
    @elseif (auth()->user()->role==="Leader")
    @props(['sameDivUsers','sameDivMembers', 'assignedMembers' , 'unassignedMembers' ])
    <x-leaders.dashboard
        :sameDivUsers="$sameDivUsers"
        :sameDivMembers="$sameDivMembers"
        :assignedMembers="$assignedMembers"
        :unassignedMembers="$unassignedMembers" />
    @elseif (auth()->user()->role==="Member")
    @props(['assignedStatus', 'submitted'])
    <x-members.dashboard
        :assignedStatus="$assignedStatus"
        :submitted="$submitted" />
    @endif
</div>