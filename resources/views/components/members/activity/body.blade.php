{{-- Table --}}
<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-4">#</th>
                <th scope="col" class="px-6 py-3">Judul Aktivitas</th>
                <th scope="col" class="px-6 py-3">Detail Aktivitas</th>
                <th scope="col" class="px-6 py-3">Tanggal Pengerjaan</th>
                <th scope="col" class="px-6 py-3">Waktu</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-4 py-3">
                    <span class="sr-only">Actions</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
            <tr class="border-b dark:border-gray-700">
                <th scope="row"
                    class="px-4 py-3 font-medium text-gray-900 max-w-lg truncate whitespace-nowrap dark:text-white">
                    {{ $loop->iteration }}
                </th>
                <td class="px-6 py-3">
                    <div class="flex items-center mr-3 whitespace-nowrap max-w-xl">
                        {{ Str::of($activity->title)->limit(75) ?? 'Tidak tersedia' }}
                    </div>
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center mr-3 whitespace-nowrap max-w-2xl">
                        {{ Str::of($activity->description)->limit(150) ?? 'Tidak tersedia' }}
                    </div>
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center mr-3 whitespace-nowrap max-w-xl">
                        {{ $activity->start_date->translatedFormat('d F Y') ?? 'Tidak tersedia' }}
                    </div>
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center mr-3 whitespace-nowrap max-w-xl">
                        {{ \Carbon\Carbon::parse($activity->created_at)->translatedFormat('H:i') ?? 'Tidak tersedia' }}
                    </div>
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center mr-3 whitespace-nowrap max-w-xl">
                        @if ( $activity->status === App\Enums\StatusTask::NOT_STARTED )
                        <!-- Error Badge-->
                        <span
                            class="inline-flex items-center justify-center gap-1 rounded-full bg-error-50 px-2.5 py-0.5 text-sm font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">
                            {{ $activity->status ?? 'Tidak tersedia' }}
                        </span>
                        @elseif ( $activity->status === App\Enums\StatusTask::PENDING )
                        <!-- Warning Badge-->
                        <span
                            class="inline-flex items-center justify-center gap-1 rounded-full bg-warning-50 px-2.5 py-0.5 text-sm font-medium text-warning-600 dark:bg-warning-500/15 dark:text-orange-400">
                            {{ $activity->status ?? 'Tidak tersedia' }}
                        </span>
                        @elseif ( $activity->status === App\Enums\StatusTask::ON_PROGRESS )
                        <!-- Info Badge-->
                        <span
                            class="inline-flex items-center justify-center gap-1 rounded-full bg-blue-light-50 px-2.5 py-0.5 text-sm font-medium text-blue-light-500 dark:bg-blue-light-500/15 dark:text-blue-light-500">
                            {{ $activity->status ?? 'Tidak tersedia' }}
                        </span>
                        @else
                        <!-- Success Badge-->
                        <span
                            class="inline-flex items-center justify-center gap-1 rounded-full bg-success-50 px-2.5 py-0.5 text-sm font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                            {{ $activity->status ?? 'Tidak tersedia' }}
                        </span>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-3 flex items-center justify-end">
                    <button id="activity-{{ $activity->id }}-dropdown-button"
                        data-dropdown-toggle="activity-{{ $activity->id }}-dropdown"
                        class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                        type="button">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                        </svg>
                    </button>
                    <div id="activity-{{ $activity->id }}-dropdown"
                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-1 text-sm" aria-labelledby="activity-{{ $activity->id }}-dropdown-button">
                            <!-- Button View -->
                            {{-- <li>
                                <button data-modal-target="showActivityModal-{{ $activity->id }}"
                                    data-modal-toggle="showActivityModal-{{ $activity->id }}"
                                    class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">

                                    <!-- <li><button type="button" data-modal-target="showActivityModal-{{ $activity->id }}"
                                    data-modal-toggle="showActivityModal-{{ $activity->id }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600
                                    dark:hover:text-white text-gray-700 dark:text-gray-200"> -->

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
                                </button>
                            </li> --}}

                            <!-- Button Edit Delete -->
                            @if ( !$activity->task_id )
                            <li>
                                <a href="{{ route('member.activities.edit', $activity->id) }}"
                                    class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                        <path
                                            d="M18.598 3.3752L20.6245 5.40176M13.7344 4H5.5C4.67157 4 4 4.67157 4 5.5V18.5C4 19.3284 4.67157 20 5.5 20H18.5C19.3284 20 20 19.3284 20 18.5V10.2676M13.1524 10.8473L14.8993 10.6583C15.2394 10.6215 15.5567 10.4696 15.7986 10.2277L20.9568 5.06945C21.3474 4.67893 21.3474 4.04576 20.9568 3.65524L20.3445 3.04289C19.954 2.65237 19.3208 2.65237 18.9303 3.04289L13.7721 8.20113C13.5302 8.44302 13.3782 8.76032 13.3414 9.10042L13.1524 10.8473Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>

                                    Edit
                                </a>
                            </li>
                            <li>
                                <button type="button" data-modal-target="deleteactivityModal-{{ $activity->id }}"
                                    data-modal-toggle="deleteactivityModal-{{ $activity->id }}"
                                    class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                        <path
                                            d="M5.62402 8.75L6.28941 19.8398C6.33694 20.6319 6.99319 21.25 7.78672 21.25H16.2113C17.0049 21.25 17.6611 20.632 17.7086 19.8398L18.374 8.75M13.749 17.2783L13.9732 12.7217M10.249 17.2783L10.0249 12.7217M15.249 5.75V4.25C15.249 3.42157 14.5775 2.75 13.749 2.75H10.249C9.4206 2.75 8.74902 3.42157 8.74902 4.25V5.75M5.5 8.75H18.498C19.3265 8.75 19.998 8.07843 19.998 7.25C19.998 6.42157 19.3265 5.75 18.498 5.75H5.5C4.67157 5.75 4 6.42157 4 7.25C4 8.07843 4.67157 8.75 5.5 8.75Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>

                                    Delete
                                </button>
                            </li>
                            @endif

                            <!-- Start Activity -->
                            @if ( $activity->status === \App\Enums\StatusTask::NOT_STARTED )
                            <li>
                                <form action="{{ route('member.activities.startActivity', $activity->id) }}"
                                    method="POST">
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

                            <!-- Continue Activity -->
                            @if ( $activity->status === \App\Enums\StatusTask::PENDING )
                            <li>
                                <form action="{{ route('member.activities.continueActivity', $activity->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
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

                                        Lanjutkan
                                    </button>
                                </form>
                            </li>
                            @endif

                            <!-- End Activity -->
                            @if ( $activity->status === \App\Enums\StatusTask::ON_PROGRESS )
                            <li>
                                <form action="{{ route('member.activities.endActivity', $activity->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
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
            <div id="showActivityModal-{{ $activity->id }}" tabindex="-1" aria-hidden="true"
                class="hidden fixed top-0 left-0 z-99999 flex h-screen w-full flex-col items-center justify-between overflow-x-hidden bg-white p-6 lg:p-10 dark:bg-gray-900">
                <div class="relative w-full h-full p-0">
                    <!-- Modal content -->
                    <div class="relative flex h-full w-full flex-col bg-white dark:bg-gray-800">

                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4">
                            <h1 class="text-title-sm mb-7 font-semibold text-gray-800 dark:text-white/90">
                                Detail Aktivitas
                            </h1>
                            <button type="button"
                                class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg p-2"
                                data-modal-hide="showActivityModal-{{ $activity->id }}">
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
                                data-modal-hide="showActivityModal-{{ $activity->id }}">
                                Close
                            </button>

                            <button type="button"
                                class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex justify-center rounded-lg px-4 py-3 text-sm font-medium text-white">
                                Kumpulkan
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Detail Modal -->
            {{-- <div id="showActivityModal-{{ $activity->id }}"
                class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto modal z-99999" style="">
                <div class="modal-close-btn fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"></div>
                <div data-modal-target="showActivityModal-{{ $activity->id }}"
                    data-modal-toggle="showActivityModal-{{ $activity->id }}"
                    class="relative w-full max-w-[1600px] max-h-[1200px] rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">
                    <!-- close btn -->
                    <button data-modal-target="showActivityModal-{{ $activity->id }}"
                        data-modal-toggle="showActivityModal-{{ $activity->id }}"
                        class="absolute right-3 top-3 z-999 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:right-6 sm:top-6 sm:h-11 sm:w-11">
                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z"
                                fill=""></path>
                        </svg>
                    </button>

                    <div>
                        <h4 class="font-semibold text-gray-800 mb-7 text-title-sm dark:text-white/90">
                            {{ $activity->title }}
                        </h4>
                        <p class="text-sm leading-6 text-gray-500 dark:text-gray-400 overflow-y-auto">
                            lorem00
                        </p>
                        <p class="mt-5 text-sm leading-6 text-gray-500 dark:text-gray-400">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
                            euismod est quis mauris lacinia pharetra. Sed a ligula ac odio.
                        </p>

                        <div class="flex items-center justify-end w-full gap-3 mt-8">
                            <button data-modal-target="showActivityModal-{{ $activity->id }}"
                                data-modal-toggle="showActivityModal-{{ $activity->id }}" type="button"
                                class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 sm:w-auto">
                                Close
                            </button>
                            <button type="button"
                                class="flex justify-center w-full px-4 py-3 text-sm font-medium text-white rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 sm:w-auto">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- <div id="showActivityModal-{{ $activity->id }}"
                class="fixed top-0 hidden left-0 z-999999 flex h-screen w-full flex-col items-start justify-start overflow-x-hidden bg-white p-6 lg:p-10 dark:bg-gray-900"
                style="">
                <!-- close btn -->
                <button data-modal-target="showActivityModal-{{ $activity->id }}"
                    data-modal-toggle="showActivityModal-{{ $activity->id }}"
                    class="absolute top-3 right-3 z-999 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 sm:top-6 sm:right-6 sm:h-11 sm:w-11 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z"
                            fill=""></path>
                    </svg>
                </button>

                <div class="overflow-y-auto">
                    <h4 class="text-title-sm mb-7 font-semibold text-gray-800 dark:text-white/90">
                        {{ $activity->title }}
                    </h4>
                    <div class="mt-6 flex items-center justify-between gap-3 w-full">
                        <div class="flex items-center flex-row gap-3 text-left">
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $activity->user_id }}
                            </p>
                            <div class="hidden h-3.5 w-px bg-gray-300 xl:block dark:bg-gray-700"></div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $activity->user_id }}
                            </p>
                        </div>
                        <p class="text-xs leading-6 text-gray-500 dark:text-gray-400">
                            {{ $activity->start_date }}
                        </p>
                    </div>
                    <p class="mt-5 text-sm leading-6 text-gray-500 dark:text-gray-400">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, soluta voluptate ullam et nemo
                        unde obcaecati cupiditate porro culpa in consequatur nihil eaque ipsa eveniet. Eos placeat
                    </p>
                    <p class="mt-5 text-sm leading-6 text-gray-500 dark:text-gray-400">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, soluta voluptate ullam et nemo
                        unde obcaecati cupiditate porro culpa in consequatur nihil eaque ipsa eveniet. Eos placeat
                    </p>
                </div>

                <div class="mt-8 flex w-full items-center justify-end gap-3 pb-16">
                    <button data-modal-target="showActivityModal-{{ $activity->id }}"
                        data-modal-toggle="showActivityModal-{{ $activity->id }}" type="button"
                        class="shadow-theme-xs flex justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                        Close
                    </button>
                    <button type="button"
                        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex justify-center rounded-lg px-4 py-3 text-sm font-medium text-white">
                        Save Changes
                    </button>
                </div>
            </div> --}}



            <!-- Delete Modal -->
            <div id="deleteactivityModal-{{ $activity->id }}"
                class="fixed inset-0 hidden items-center justify-center p-5 overflow-y-auto modal z-999999">
                <div data-modal-target="deleteactivityModal-{{ $activity->id }}"
                    data-modal-toggle="deleteactivityModal-{{ $activity->id }}"
                    class="modal-close-btn fixed inset-0 h-full w-full bg-gray-300/50 backdrop-blur-[3rem]"></div>
                <div class="relative w-full max-w-[600px] rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">
                    <!-- close btn -->
                    <button data-modal-target="deleteactivityModal-{{ $activity->id }}"
                        data-modal-toggle="deleteactivityModal-{{ $activity->id }}"
                        class="absolute right-3 top-3 z-999 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:right-6 sm:top-6 sm:h-11 sm:w-11">
                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z"
                                fill=""></path>
                        </svg>
                    </button>

                    <div class="text-center">
                        <div class="relative flex items-center justify-center z-1 mb-7">
                            <svg class="fill-warning-50 dark:fill-warning-500/15" width="90" height="90"
                                viewBox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M34.364 6.85053C38.6205 -2.28351 51.3795 -2.28351 55.636 6.85053C58.0129 11.951 63.5594 14.6722 68.9556 13.3853C78.6192 11.0807 86.5743 21.2433 82.2185 30.3287C79.7862 35.402 81.1561 41.5165 85.5082 45.0122C93.3019 51.2725 90.4628 63.9451 80.7747 66.1403C75.3648 67.3661 71.5265 72.2695 71.5572 77.9156C71.6123 88.0265 60.1169 93.6664 52.3918 87.3184C48.0781 83.7737 41.9219 83.7737 37.6082 87.3184C29.8831 93.6664 18.3877 88.0266 18.4428 77.9156C18.4735 72.2695 14.6352 67.3661 9.22531 66.1403C-0.462787 63.9451 -3.30193 51.2725 4.49185 45.0122C8.84391 41.5165 10.2138 35.402 7.78151 30.3287C3.42572 21.2433 11.3808 11.0807 21.0444 13.3853C26.4406 14.6722 31.9871 11.951 34.364 6.85053Z"
                                    fill="" fill-opacity=""></path>
                            </svg>

                            <span class="absolute -translate-x-1/2 -translate-y-1/2 left-1/2 top-1/2">
                                <svg class="fill-warning-600 dark:fill-orange-400" width="38" height="38"
                                    viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M32.1445 19.0002C32.1445 26.2604 26.2589 32.146 18.9987 32.146C11.7385 32.146 5.85287 26.2604 5.85287 19.0002C5.85287 11.7399 11.7385 5.85433 18.9987 5.85433C26.2589 5.85433 32.1445 11.7399 32.1445 19.0002ZM18.9987 35.146C27.9158 35.146 35.1445 27.9173 35.1445 19.0002C35.1445 10.0831 27.9158 2.85433 18.9987 2.85433C10.0816 2.85433 2.85287 10.0831 2.85287 19.0002C2.85287 27.9173 10.0816 35.146 18.9987 35.146ZM21.0001 26.0855C21.0001 24.9809 20.1047 24.0855 19.0001 24.0855L18.9985 24.0855C17.894 24.0855 16.9985 24.9809 16.9985 26.0855C16.9985 27.19 17.894 28.0855 18.9985 28.0855L19.0001 28.0855C20.1047 28.0855 21.0001 27.19 21.0001 26.0855ZM18.9986 10.1829C19.827 10.1829 20.4986 10.8545 20.4986 11.6829L20.4986 20.6707C20.4986 21.4992 19.827 22.1707 18.9986 22.1707C18.1701 22.1707 17.4986 21.4992 17.4986 20.6707L17.4986 11.6829C17.4986 10.8545 18.1701 10.1829 18.9986 10.1829Z"
                                        fill=""></path>
                                </svg>
                            </span>
                        </div>

                        <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90 sm:text-title-sm">
                            Peringatan!
                        </h4>
                        <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">
                            Apakah Anda yakin ingin menghapus data aktivitas yang satu ini?
                        </p>

                        <div class="flex items-center justify-center w-full gap-3 mt-7">
                            <button data-modal-target="deleteactivityModal-{{ $activity->id }}"
                                data-modal-toggle="deleteactivityModal-{{ $activity->id }}" type="button"
                                class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 sm:w-auto">
                                Cancel
                            </button>
                            <form action="{{ route('member.activities.destroy', $activity->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="flex justify-center w-full px-4 py-3 text-sm font-medium text-white rounded-lg bg-warning-500 shadow-theme-xs hover:bg-warning-600 sm:w-auto">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Delete Modal -->
            @endforeach
        </tbody>
    </table>
</div>
{{-- End Table --}}