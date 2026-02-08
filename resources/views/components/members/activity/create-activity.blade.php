<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
        <form action="{{ route('member.activities.store') }}" method='POST'>
            @csrf
            <div class="-mx-2.5 flex flex-wrap gap-y-5">
                <div class="w-full px-2.5">
                    <label for="title" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Aktivitas
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        placeholder="Masukan aktivitas anda"
                        class="@error('title') bg-red-50 dark:bg-red-900/20 border-red-500 text-red-600 placeholder-red-50 focus:ring-red-500/10 focus:border-red-300 dark:text-red-500 dark:placeholder-red-500 dark:border-red-800 dark:focus:ring-red-50/10 dark:focus:border-red-800 @enderror dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                    @error('title')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full px-2.5">
                    <label for="description" class=" mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Detail Aktivitas
                    </label>
                    <textarea placeholder="Masukan detail dari aktivitas anda" type="text" rows="8" name="description"
                        id="description" autocomplete="off"
                        class="@error('description') bg-red-50 dark:bg-red-900/20 border-red-500 text-red-600 placeholder-red-50 focus:ring-red-500/10 focus:border-red-300 dark:text-red-500 dark:placeholder-red-500 dark:border-red-800 dark:focus:ring-red-50/10 dark:focus:border-red-800 @enderror  dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full px-2.5">
                    <div class="mt-1 flex items-center justify-end gap-3">
                        <button type="submit"
                            class="bg-brand-500 hover:bg-brand-600 flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white">
                            Buat Aktivitas
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>