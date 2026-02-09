<x-layouts.app :title="$title">
    @push('styles')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
    @endpush

    <div class="mx-auto max-w-(--breakpoint-3xl) p-4 md:p-6">
        <!-- Breadcrumb Start -->
        <x-partials.breadcrumb>{{ $title }}</x-partials.breadcrumb>
        <!-- Breadcrumb End -->

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
            <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-3">
                <x-leaders.user.form-profile :user="$user" />
                {{--
                <x-members.user.form-password /> --}}
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js">
    </script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js">
    </script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        FilePond.registerPlugin(FilePondPluginImageTransform);
        FilePond.registerPlugin(FilePondPluginImageResize);

        const inputElement = document.querySelector('#avatar');
        const pond = FilePond.create(inputElement, {
            acceptedFileTypes: ['image/*'],
            maxFileSize: '5MB',
            imageResizeTargetWidth: 600,
            imageResizeTargetHeight: 600,
            imageResizeMode: 'cover',
            imageResizeUpscale: false,
            server: {
                process: {
                    url: '{{ route('leader.uploadAvatar') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onload: (response) => {
                        // simpan file ID (path tmp)
                        document.getElementById('avatar_tmp').value = response;
                        return response;
                    }
                },
                revert: {
                    url: '{{ route('leader.deleteAvatar') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
            }
        });

        document.getElementById('contact').addEventListener('input', function (e) {
            let val = e.target.value.replace(/\D/g, ''); // hanya angka
            if (val.startsWith('62')) {
                e.target.value = '+' + val;
            } else if (val.startsWith('0')) {
                e.target.value = '+62' + val.substring(1);
            } else {
                e.target.value = '+62' + val;
            };
        });
    </script>
    @endpush
</x-layouts.app>