{{-- Table --}}
<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-4">#</th>
                <th scope="col" class="px-6 py-3">Nama Ketua</th>
                <th scope="col" class="px-6 py-3">Tugas</th>
                <th scope="col" class="px-6 py-3">Detail Tugas</th>
                <th scope="col" class="px-6 py-3 whitespace-nowrap">Tanggal Pengerjaan</th>
                <th scope="col" class="px-6 py-3 whitespace-nowrap">Batas Pengerjaan</th>
                <th scope="col" class="px-6 py-3 whitespace-nowrap">Tanggal Pengumpulan</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-4 py-3">
                    <span class="sr-only">Actions</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr class="border-b dark:border-gray-700">
                <th scope="row"
                    class="px-4 py-3 font-medium text-gray-900 max-w-lg truncate whitespace-nowrap dark:text-white">
                    {{ $loop->iteration }}
                </th>
                <td class="px-6 py-3">
                    <div class="flex items-center gap-3 mr-3 whitespace-nowrap max-w-xl">
                        {{-- <img src="{{ $task->avatar ? asset('storage/' . $task->avatar) :
                                    asset('assets/images/user/user-default.png') }}" alt="{{ $task->name }}"
                        class="h-8 w-8 mr-3 rounded-full"> --}}
                        <div class="w-10 h-10 overflow-hidden rounded-full">
                            <img src="{{ asset('assets/images/user/user-default.png') }}"
                                alt="{{ $task->leaderTask->name }}">
                        </div>
                        <div>
                            <span class="block">
                                {{ $task->leaderTask->name }}
                            </span>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center mr-3 whitespace-nowrap max-w-xl">
                        {{ Str::of($task->title)->limit(20) ?? 'Tidak tersedia' }}
                    </div>
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center mr-3 whitespace-nowrap max-w-2xl">
                        {{ Str::of($task->description)->limit(100) ?? 'Tidak tersedia' }}
                    </div>
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center mr-3 whitespace-nowrap max-w-xl">
                        {{ $task->start_date->translatedFormat('d F Y, H:i') ?? 'Tidak tersedia' }}
                    </div>
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center mr-3 whitespace-nowrap max-w-xl">
                        {{ $task->end_date->translatedFormat('d F Y, H:i') ?? 'Tidak tersedia' }}
                    </div>
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center mr-3 whitespace-nowrap max-w-xl">
                        {{ $task->due_date ? $task->due_date->translatedFormat('d F Y, H:i') : 'Belum diselesaikan' }}
                    </div>
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center mr-3 whitespace-nowrap max-w-xl">
                        @if ( $task->status === App\Enums\StatusTask::NOT_STARTED )
                        <!-- Error Badge-->
                        <span
                            class="inline-flex items-center justify-center gap-1 rounded-full bg-error-50 px-2.5 py-0.5 text-sm font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">
                            {{ $task->status ?? 'Tidak tersedia' }}
                        </span>
                        @elseif ( $task->status === App\Enums\StatusTask::LATE )
                        <!-- Error Badge-->
                        <span
                            class="inline-flex items-center justify-center gap-1 rounded-full bg-error-50 px-2.5 py-0.5 text-sm font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">
                            {{ $task->status ?? 'Tidak tersedia' }}
                        </span>
                        @elseif ( $task->status === App\Enums\StatusTask::PENDING )
                        <!-- Warning Badge-->
                        <span
                            class="inline-flex items-center justify-center gap-1 rounded-full bg-warning-50 px-2.5 py-0.5 text-sm font-medium text-warning-600 dark:bg-warning-500/15 dark:text-orange-400">
                            {{ $task->status ?? 'Tidak tersedia' }}
                        </span>
                        @elseif ( $task->status === App\Enums\StatusTask::ON_PROGRESS )
                        <!-- Info Badge-->
                        <span
                            class="inline-flex items-center justify-center gap-1 rounded-full bg-blue-light-50 px-2.5 py-0.5 text-sm font-medium text-blue-light-500 dark:bg-blue-light-500/15 dark:text-blue-light-500">
                            {{ $task->status ?? 'Tidak tersedia' }}
                        </span>
                        @else
                        <!-- Success Badge-->
                        <span
                            class="inline-flex items-center justify-center gap-1 rounded-full bg-success-50 px-2.5 py-0.5 text-sm font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                            {{ $task->status ?? 'Tidak tersedia' }}
                        </span>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-3 flex items-center justify-end">
                    <button id="task-{{ $task->id }}-dropdown-button"
                        data-dropdown-toggle="task-{{ $task->id }}-dropdown"
                        class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                        type="button">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                        </svg>
                    </button>
                    <div id="task-{{ $task->id }}-dropdown"
                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-1 text-sm" aria-labelledby="task-{{ $task->id }}-dropdown-button">
                            <!-- Button View -->
                            {{-- <li>
                                <button type="button" data-modal-target="showTaskModal-{{ $task->id }}"
                            data-modal-toggle="showTaskModal-{{ $task->id }}" class="flex w-full items-center py-2 px-4
                            hover:bg-gray-100 dark:hover:bg-gray-600
                            dark:hover:text-white text-gray-700 dark:text-gray-200">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg"
                                transform="rotate(0 0 0)">
                                <path
                                    d="M2.95862 13.451C2.68046 12.8479 2.68046 12.1523 2.95862 11.5492C4.53779 8.1253 7.99237 5.75 11.9999 5.75C16.0075 5.75 19.4621 8.12531 21.0413 11.5492C21.3194 12.1523 21.3194 12.8479 21.0413 13.451C19.4621 16.8749 16.0075 19.2502 11.9999 19.2502C7.99237 19.2502 4.53779 16.8749 2.95862 13.451Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M15.625 12.5C15.625 14.502 14.002 16.125 12 16.125C9.99797 16.125 8.375 14.502 8.375 12.5C8.375 10.498 9.99797 8.875 12 8.875C14.002 8.875 15.625 10.498 15.625 12.5Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            View
                            </button>
                            </li> --}}

                            <!-- Start Button -->
                            @if ( $task->status === \App\Enums\StatusTask::NOT_STARTED )
                            <li>
                                <form action="{{ route('member.tasks.startActivity', $task->id) }}" method="POST">
                                    @csrf
                                    <button
                                        class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 640 640">
                                            <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M197.8 100.3C208.7 107.9 211.3 122.9 203.7 133.7L147.7 213.7C143.6 219.5 137.2 223.2 130.1 223.8C123 224.4 116 222 111 217L71 177C61.7 167.6 61.7 152.4 71 143C80.3 133.6 95.6 133.7 105 143L124.8 162.8L164.4 106.2C172 95.3 187 92.7 197.8 100.3zM197.8 260.3C208.7 267.9 211.3 282.9 203.7 293.7L147.7 373.7C143.6 379.5 137.2 383.2 130.1 383.8C123 384.4 116 382 111 377L71 337C61.6 327.6 61.6 312.4 71 303.1C80.4 293.8 95.6 293.7 104.9 303.1L124.7 322.9L164.3 266.3C171.9 255.4 186.9 252.8 197.7 260.4zM288 160C288 142.3 302.3 128 320 128L544 128C561.7 128 576 142.3 576 160C576 177.7 561.7 192 544 192L320 192C302.3 192 288 177.7 288 160zM288 320C288 302.3 302.3 288 320 288L544 288C561.7 288 576 302.3 576 320C576 337.7 561.7 352 544 352L320 352C302.3 352 288 337.7 288 320zM224 480C224 462.3 238.3 448 256 448L544 448C561.7 448 576 462.3 576 480C576 497.7 561.7 512 544 512L256 512C238.3 512 224 497.7 224 480zM128 440C150.1 440 168 457.9 168 480C168 502.1 150.1 520 128 520C105.9 520 88 502.1 88 480C88 457.9 105.9 440 128 440z" />
                                        </svg>
                                        Kerjakan
                                    </button>
                                </form>
                            </li>
                            @endif

                            <!-- Continue Button -->
                            @if ( $task->status === \App\Enums\StatusTask::PENDING )
                            <li>
                                <a href="{{ route('member.tasks.continueActivity', $task->id) }}"
                                    class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 25" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                        <path
                                            d="M2.95862 13.451C2.68046 12.8479 2.68046 12.1523 2.95862 11.5492C4.53779 8.1253 7.99237 5.75 11.9999 5.75C16.0075 5.75 19.4621 8.12531 21.0413 11.5492C21.3194 12.1523 21.3194 12.8479 21.0413 13.451C19.4621 16.8749 16.0075 19.2502 11.9999 19.2502C7.99237 19.2502 4.53779 16.8749 2.95862 13.451Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M15.625 12.5C15.625 14.502 14.002 16.125 12 16.125C9.99797 16.125 8.375 14.502 8.375 12.5C8.375 10.498 9.99797 8.875 12 8.875C14.002 8.875 15.625 10.498 15.625 12.5Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    Lanjutkan
                                </a>
                            </li>
                            @endif

                            <!-- End Button -->
                            @if ( $task->status === \App\Enums\StatusTask::ON_PROGRESS )
                            <li>
                                <a href="{{ route('member.tasks.endActivity', $task->id) }}"
                                    class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                        <path fill="currentColor"
                                            d="M64 48l112 0 0 88c0 39.8 32.2 72 72 72l88 0 0 240c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16L48 64c0-8.8 7.2-16 16-16zM224 67.9l92.1 92.1-68.1 0c-13.3 0-24-10.7-24-24l0-68.1zM64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-261.5c0-17-6.7-33.3-18.7-45.3L242.7 18.7C230.7 6.7 214.5 0 197.5 0L64 0zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0z" />
                                    </svg>
                                    Tunda
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('member.tasks.endActivity', $task->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 384 512" fill="none">
                                            <path fill="currentColor" stroke-width="2"
                                                d="M64 48l112 0 0 88c0 39.8 32.2 72 72 72l88 0 0 240c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16L48 64c0-8.8 7.2-16 16-16zM224 67.9l92.1 92.1-68.1 0c-13.3 0-24-10.7-24-24l0-68.1zM64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-261.5c0-17-6.7-33.3-18.7-45.3L242.7 18.7C230.7 6.7 214.5 0 197.5 0L64 0zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0z" />
                                        </svg>
                                        Kumpulkan
                                    </button>
                                </form>
                            </li>
                            @endif
                        </ul>
                    </div>
                </td>
            </tr>

            <!-- View modal -->
            {{--
            <div id="showTaskModal-{{ $task->id }}" tabindex="-1" aria-hidden="true"
            class="hidden fixed top-0 left-0 z-999999 flex h-screen w-full flex-col items-center justify-between
            overflow-x-hidden bg-white p-6 lg:p-10 dark:bg-gray-900">
            <div class="relative w-full h-full p-0">
                <!-- Modal content -->
                <div class="relative flex h-full w-full flex-col bg-white dark:bg-gray-800">

                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4">
                        <h1 class="text-title-sm mb-7 font-semibold text-gray-800 dark:text-white/90">
                            Detail Aktivitas
                        </h1>

                        <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg p-2"
                            data-modal-hide="showTaskModal-{{ $task->id }}">
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
                        <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">Judul Tugas: {{ $task->title
                                }}</p>
                        <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">Status Tugas: @if (
                            $task->status ===
                            App\Enums\StatusTask::NOT_STARTED )
                            <!-- Error Badge-->
                            <span
                                class="inline-flex items-center justify-center gap-1 rounded-full bg-error-50 px-2.5 py-0.5 text-sm font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">
                                {{ $task->status ?? 'Tidak tersedia' }}
                            </span>
                            @elseif ( $task->status === App\Enums\StatusTask::PENDING )
                            <!-- Warning Badge-->
                            <span
                                class="inline-flex items-center justify-center gap-1 rounded-full bg-warning-50 px-2.5 py-0.5 text-sm font-medium text-warning-600 dark:bg-warning-500/15 dark:text-orange-400">
                                {{ $task->status ?? 'Tidak tersedia' }}
                            </span>
                            @elseif ( $task->status === App\Enums\StatusTask::ON_PROGRESS )
                            <!-- Info Badge-->
                            <span
                                class="inline-flex items-center justify-center gap-1 rounded-full bg-blue-light-50 px-2.5 py-0.5 text-sm font-medium text-blue-light-500 dark:bg-blue-light-500/15 dark:text-blue-light-500">
                                {{ $task->status ?? 'Tidak tersedia' }}
                            </span>
                            @else
                            <!-- Success Badge-->
                            <span
                                class="inline-flex items-center justify-center gap-1 rounded-full bg-success-50 px-2.5 py-0.5 text-sm font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                                {{ $task->status ?? 'Tidak tersedia' }}
                            </span>
                            @endif
                        </p>
                        <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">Tanggal Dibuat: </p>
                        <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">Detail Tugas: </p>
                    </div>
                    <div
                        class="sticky bottom-0 flex w-full justify-end gap-3 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                        <button type="button"
                            class="shadow-theme-xs flex justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                            data-modal-hide="showTaskModal-{{ $task->id }}">
                            Close
                        </button>

                        <button type="button"
                            class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex justify-center rounded-lg px-4 py-3 text-sm font-medium text-white">
                            Kerjakan
                        </button>
                    </div>
                </div>
            </div>
</div>
--}}
@endforeach
</tbody>
</table>
</div>
{{-- End Table --}}