<x-layouts.app :title="$title">
    @push('styles')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
    @endpush

    <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
        <!-- Breadcrumb Start -->
        <x-partials.breadcrumb>{{ $title }}</x-partials.breadcrumb>
        <!-- Breadcrumb End -->

        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg">
            <x-members.task.header />
            <x-members.task.body :tasks="$tasks" />
            <x-members.task.pagination :tasks="$tasks" />
        </div>
    </div>
    @push('scripts')
    @endpush
</x-layouts.app>