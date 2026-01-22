{{-- Table --}}
<div class="overflow-x-auto">
    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-4 py-4">#</th>
                    <th class="px-6 py-3">Nama Ketua</th>
                    <th class="px-6 py-3">Tugas</th>
                    <th class="px-6 py-3">Detail</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Batas</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr class="border-b dark:border-gray-700">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>

                    <td class="px-6 py-3">
                        {{ $task->leaderTask->name }}
                    </td>

                    <td class="px-6 py-3">
                        {{ Str::limit($task->title, 20) }}
                    </td>

                    <td class="px-6 py-3">
                        {{ Str::limit($task->description, 50) }}
                    </td>

                    <td class="px-6 py-3">
                        {{ $task->start_date->format('d M Y') }}
                    </td>

                    <td class="px-6 py-3">
                        {{ $task->end_date->format('d M Y') }}
                    </td>

                    <td class="px-6 py-3 text-right">
                        <button type="button" data-modal-target="fullscreen-modal" data-modal-toggle="fullscreen-modal"
                            data-title="{{ $task->title }}" data-leader="{{ $task->leaderTask->name }}"
                            data-date="{{ $task->start_date->format('d M Y') }}" data-status="{{ $task->status }}"
                            data-description="{{ $task->description }}"
                            class="text-sm text-blue-600 hover:underline view-task-btn">
                            View
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- End Table --}}

    <!-- View modal -->
    <div id="fullscreen-modal" tabindex="-1" aria-hidden="true"
        class="hidden fixed top-0 left-0 z-999999 flex h-screen w-full flex-col items-center justify-between overflow-x-hidden bg-white p-6 lg:p-10 dark:bg-gray-900">
        <div class="relative w-full h-full p-0">
            <!-- Modal content -->
            <div class="relative flex h-full w-full flex-col bg-white dark:bg-gray-800">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4">
                    <h1 class="text-title-sm mb-7 font-semibold text-gray-800 dark:text-white/90">
                        Detail Aktivitas
                    </h1>
                    <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg p-2"
                        data-modal-hide="fullscreen-modal">
                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z"
                                fill="" />
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="flex-1 overflow-y-auto p-6">
                    <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">Judul Tugas: </p>
                    <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">Status Tugas: </p>
                    <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">Tanggal Dibuat: </p>
                    <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">Detail Tugas: </p>
                </div>

                <div
                    class="sticky bottom-0 flex w-full justify-end gap-3 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                    <button type="button"
                        class="shadow-theme-xs flex justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                        data-modal-hide="fullscreen-modal">
                        Close
                    </button>

                    <button type="button"
                        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex justify-center rounded-lg px-4 py-3 text-sm font-medium text-white">
                        Kumpulkan/Kerjakan
                    </button>
                </div>

            </div>
        </div>
    </div>


    @push('script')
    <script>
    document.querySelectorAll('.view-task-btn').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('modal-title').textContent = button.dataset.title;
            document.getElementById('modal-leader').textContent = button.dataset.leader;
            document.getElementById('modal-date').textContent = button.dataset.date;
            document.getElementById('modal-status').textContent = button.dataset.status;
            document.getElementById('modal-description').textContent = button.dataset.description;
        });
    });
    </script>
    @endpush