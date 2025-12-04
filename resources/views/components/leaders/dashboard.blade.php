@props(['sameDivUsers', 'sameDivMembers', 'assignedMembers', 'unassignedMembers'])

<article
    class="flex items-center gap-5 rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/3">
    <div
        class="inline-flex h-16 w-16 items-center justify-center rounded-xl bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <circle cx="12" cy="6" r="4" stroke="#1C274C" stroke-width="1.5"></circle>
                <path d="M18 9C19.6569 9 21 7.88071 21 6.5C21 5.11929 19.6569 4 18 4" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                <path d="M6 9C4.34315 9 3 7.88071 3 6.5C3 5.11929 4.34315 4 6 4" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                <path d="M17.1973 15C17.7078 15.5883 18 16.2714 18 17C18 19.2091 15.3137 21 12 21C8.68629 21 6 19.2091 6 17C6 14.7909 8.68629 13 12 13C12.3407 13 12.6748 13.0189 13 13.0553" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                <path d="M20 19C21.7542 18.6153 23 17.6411 23 16.5C23 15.3589 21.7542 14.3847 20 14" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                <path d="M4 19C2.24575 18.6153 1 17.6411 1 16.5C1 15.3589 2.24575 14.3847 4 14" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
            </g>
        </svg>

    </div>
    <div>
        <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            {{ $sameDivUsers }}
        </h4>
        <div class="flex items-center justify-start gap-3">
            <div>
                <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                    @auth {{ auth()->user()->division }} @endauth 
                    Division Members
                </p>
            </div>
        </div>
    </div>
</article>
<article
    class="flex items-center gap-5 rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/3">
    <div
        class="inline-flex h-16 w-16 items-center justify-center rounded-xl bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path d="M12.1992 12C14.9606 12 17.1992 9.76142 17.1992 7C17.1992 4.23858 14.9606 2 12.1992 2C9.43779 2 7.19922 4.23858 7.19922 7C7.19922 9.76142 9.43779 12 12.1992 12Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M21.5902 16.35L16.5002 21.44C15.9902 21.94 14.5002 22.1799 14.1502 21.8399C14.0173 21.4468 13.9851 21.0265 14.0567 20.6177C14.1284 20.2088 14.3015 19.8246 14.5602 19.5L19.6502 14.4C19.915 14.1767 20.254 14.0613 20.6001 14.0764C20.9461 14.0915 21.2738 14.2361 21.518 14.4817C21.7623 14.7272 21.9053 15.0557 21.9187 15.4018C21.932 15.7479 21.8148 16.0863 21.5902 16.35V16.35Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M3 22C3.57038 20.0332 4.74795 18.2971 6.36438 17.0399C7.98081 15.7827 9.95335 15.0687 12 15" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
        </svg>
    </div>
    <div>
        <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            {{ $sameDivMembers }}
        </h4>
        <div class="flex items-center justify-start gap-3">
            <div>
                <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                    @auth {{ auth()->user()->division }} @endauth 
                    Division Employees
                </p>
            </div>
        </div>
    </div>
</article>
<article
    class="flex items-center gap-5 rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/3">
    <div
        class="inline-flex h-16 w-16 items-center justify-center rounded-xl bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90">
        <svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-check" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
  <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
  <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
</svg>
    </div>
    <div>
        <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            {{ $assignedMembers }}
        </h4>
        <div class="flex items-center justify-start gap-3">
            <div>
                <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                    Assigned Members
                </p>
            </div>
        </div>
    </div>
</article>
<article
    class="flex items-center gap-5 rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/3">
    <div
        class="inline-flex h-16 w-16 items-center justify-center rounded-xl bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90">
        <svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-x" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708"/>
  <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
  <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
</svg>
    </div>
    <div>
        <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            {{ $unassignedMembers }}
        </h4>
        <div class="flex items-center justify-start gap-3">
            <div>
                <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                    Unassigned Members
                </p>
            </div>
        </div>
    </div>
</article>