<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
        <form action="{{ route('leader.users.update', $user->id) }}" method='POST'>
            @csrf
            @method('PATCH')
            <div class="-mx-2.5 flex flex-wrap gap-y-5">
                <div class="w-full px-2.5">
                    <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nama Anggota
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') ?? $user->name }}" autofocus
                        autocomplete="off" placeholder="Masukan nama anggota baru"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                    @error('name')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full px-2.5">
                    <label for="division" class=" mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Divisi
                    </label>
                    <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                        <select name="division" id="division" value="{{ old('division') }}"
                            class="@error('division') bg-red-50 dark:bg-red-900/20 border-red-500 text-red-600 placeholder-red-50 focus:ring-red-500/10 focus:border-red-300 dark:text-red-500 dark:placeholder-red-500 dark:border-red-800 dark:focus:ring-red-50/10 dark:focus:border-red-800 @enderror dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="isOptionSelected &amp;&amp; 'text-gray-800 dark:text-white/90'"
                            @change="isOptionSelected = true">
                            <option value="" selected="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                --Silahkan Pilih Divisi--
                            </option>
                            <option value="{{ $user->division }}"
                                class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected( (old('division') ??
                                $user->division) == $user->division)>
                                {{ $user->division }}
                            </option>
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
                    @error('division')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full px-2.5">
                    <label for="contact" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nomer Telepon
                    </label>
                    <input type="text" name="contact" id="contact" value="{{ old('contact') ?? $user->contact }}"
                        autocomplete="off" placeholder="Masukan nama anggota baru"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                    @error('contact')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full px-2.5">
                    <label for="address" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Alamat
                    </label>
                    <textarea placeholder="{{ old('address') ?? $user->address }}" type="text" rows="8" name="address"
                        id="address" autocomplete="off" value="{{ old('address') ?? $user->address }}"
                        class="@error('address') bg-red-50 dark:bg-red-900/20 border-red-500 text-red-600 placeholder-red-50 focus:ring-red-500/10 focus:border-red-300 dark:text-red-500 dark:placeholder-red-500 dark:border-red-800 dark:focus:ring-red-50/10 dark:focus:border-red-800 @enderror  dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">{{ old('address') }}</textarea>
                    @error('address')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                <div class="w-full px-2.5">
                    <div class="mt-1 flex items-center justify-end gap-3">
                        <button type="submit"
                            class="bg-brand-500 hover:bg-brand-600 flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white">
                            Ubah Data
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>