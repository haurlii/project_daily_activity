<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @if (auth()->user()->role==="SuperAdmin")
    <x-admins.dashboard></x-admins.dashboard>
    @elseif (auth()->user()->role==="Leader")
    <x-leaders.dashboard></x-leaders.dashboard>
    @elseif (auth()->user()->role==="Member")
    <x-members.dashboard></x-members.dashboard>
    @endif
</div>