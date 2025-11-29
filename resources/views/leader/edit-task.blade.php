<x-layouts.app :title="$title">
    @push('styles')
    @endpush

    <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
        <!-- Breadcrumb Start -->
        <x-partials.breadcrumb>{{ $title }}</x-partials.breadcrumb>
        <!-- Breadcrumb End -->

        <div class="bg-white dark:bg-gray-800/40 relative shadow-md sm:rounded-lg">
            <x-leaders.task.edit-task :task="$task" :members="$members" />
        </div>
    </div>
    @push('scripts')
    @endpush
</x-layouts.app>