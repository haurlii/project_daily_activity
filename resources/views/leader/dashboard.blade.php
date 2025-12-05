<x-layouts.app :title="$title">
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12 space-y-6 xl:col-span-12">
                <!-- Metric Group One -->
                <x-partials.grid-info 
                :sameDivUsers="$sameDivUsers"
                :sameDivMembers="$sameDivMembers"
                :assignedMembers="$assignedMembers"
                :unassignedMembers="$unassignedMembers"
                />
                <!-- Metric Group One -->
            </div>

            {{-- <div class="col-span-12 xl:col-span-6">
                <!-- ====== Table One Start -->
                <x-role-admins.dashboard.table-one :loanBooks="$loanBooks" />
                <!-- ====== Table One End -->
            </div>

            <div class="col-span-12 xl:col-span-6">
                <!-- ====== Table One Start -->
                <x-role-admins.dashboard.table-two :returnBooks="$returnBooks" />
                <!-- ====== Table One End -->
            </div> --}}
        </div>
    </div>
    @push('scripts')
    @endpush
</x-layouts.app>