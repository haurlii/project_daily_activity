<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
        <form action="{{ route('leader.tasks.store') }}" method='POST'>
            @csrf
            <div class="-mx-2.5 flex flex-wrap gap-y-5">
                <div class="w-full px-2.5">
                    <label for="member_id" class=" mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nama Anggota
                    </label>
                    <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                        <select name="member_id" id="member_id" value="{{ old('member_id') }}"
                            class="@error('member_id') bg-red-50 dark:bg-red-900/20 border-red-500 text-red-600 placeholder-red-50 focus:ring-red-500/10 focus:border-red-300 dark:text-red-500 dark:placeholder-red-500 dark:border-red-800 dark:focus:ring-red-50/10 dark:focus:border-red-800 @enderror dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="isOptionSelected &amp;&amp; 'text-gray-800 dark:text-white/90'"
                            @change="isOptionSelected = true">
                            <option value="" selected="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                --Silahkan Pilih Nama Anggota--
                            </option>
                            @foreach ( $members as $member)
                            <option value="{{ $member->id }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                                @selected( old('member_id')==$member->id)>
                                {{ $member->name }}
                            </option>
                            @endforeach
                        </select>
                        <span
                            class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                    </div>
                    @error('member_id')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full px-2.5">
                    <label for="title" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Tugas
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Masukan tugas"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                    @error('title')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full px-2.5">
                    <label for="description" class=" mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Detail Tugas
                    </label>
                    <textarea placeholder="Tuliskan detail dari tugas tersebut" type="text" rows="6" name="description"
                        id="description" autocomplete="off"
                        class="@error('description') bg-red-50 dark:bg-red-900/20 border-red-500 text-red-600 placeholder-red-50 focus:ring-red-500/10 focus:border-red-300 dark:text-red-500 dark:placeholder-red-500 dark:border-red-800 dark:focus:ring-red-50/10 dark:focus:border-red-800 @enderror  dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full px-2.5 xl:w-1/2">
                    <label for="start_date" class=" mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Tanggal Pengerjaan
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input id="start_date" datepicker datepicker-format="dd MM yyyy" type="text" name="start_date"
                            value="{{ old('start_date') ?? \Carbon\Carbon::now()->format('d F Y') }}"
                            class="@error('start_date') bg-red-50 dark:bg-red-900/20 border-red-500 text-red-600 placeholder-red-50 focus:ring-red-500/10 focus:border-red-300 dark:text-red-500 dark:placeholder-red-500 dark:border-red-800 dark:focus:ring-red-50/10 dark:focus:border-red-800 @enderror dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            placeholder="Pilih tanggal pengerjaan">
                    </div>
                </div>

                <div class="w-full px-2.5 xl:w-1/2">
                    <label for="end_date" class=" mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Batas Pengerjaan
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input id="end_date" datepicker datepicker-format="dd MM yyyy" type="text" name="end_date"
                            value="{{ old('end_date') ?? \Carbon\Carbon::now()->format('d F Y') }}"
                            class="@error('end_date') bg-red-50 dark:bg-red-900/20 border-red-500 text-red-600 placeholder-red-50 focus:ring-red-500/10 focus:border-red-300 dark:text-red-500 dark:placeholder-red-500 dark:border-red-800 dark:focus:ring-red-50/10 dark:focus:border-red-800 @enderror dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            placeholder="Pilih batas pengerjaan">
                    </div>
                </div>

                <div class="w-full px-2.5">
                    <div class="mt-1 flex items-center justify-end gap-3">
                        <button type="submit"
                            class="bg-brand-500 hover:bg-brand-600 flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white">
                            Buat Tugas
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>