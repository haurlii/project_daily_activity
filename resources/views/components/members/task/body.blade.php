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
                        {{ $task->start_date->translatedFormat('d F Y') ?? 'Tidak tersedia' }}
                    </div>
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center mr-3 whitespace-nowrap max-w-xl">
                        {{ $task->end_date->translatedFormat('d F Y') ?? 'Tidak tersedia' }}
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
                            <li>
                                <a href="{{ route('member.tasks.show', $task->id) }}"
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

                                    View
                                </a>
                            </li>
                            @if ( $task->status === \App\Enums\StatusTask::NOT_STARTED )
                            <li>
                                <form action="{{ route('member.tasks.startActivity', $task->id) }}" method="POSt">
                                    @csrf
                                    <button
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

                                        Kerjakan
                                    </button>
                                </form>
                            </li>
                            @endif

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

                            @if ( $task->status === \App\Enums\StatusTask::ON_PROGRESS )
                            <li>
                                <a href="{{ route('member.tasks.endActivity', $task->id) }}"
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

                                    Kumpulkan
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- End Table --}}