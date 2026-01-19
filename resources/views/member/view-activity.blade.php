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

        <div
            class="min-h-screen rounded-2xl border border-gray-200 bg-white px-5 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12">
            <div class="mx-auto w-full max-w-[630px] text-center">
                <h3 class="mb-4 text-theme-xl font-semibold text-gray-800 dark:text-white/90 sm:text-2xl">
                    Card Title Here
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 sm:text-base">
                    Start putting content on grids or panels, you can also use
                    different combinations of grids.Please check out the
                    dashboard and other pages
                </p>
            </div>
        </div>
    </div>
    @push('scripts')
    @endpush
</x-layouts.app>