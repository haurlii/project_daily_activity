<!-- Menu Item Dashboard -->
<li>
    <a href="{{ route('member.indexMember') }}" @click="selected = (selected === 'Dashboard' ? '':'Dashboard')"
        class="menu-item group hover:menu-item-active"
        :class="(page === 'Dashboard') ? 'menu-item-active' : 'menu-item-inactive'">
        <svg :class="(page === 'Dashboard') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'" width="24"
            height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z"
                fill="" />
        </svg>

        <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
            Dashboard
        </span>
    </a>
</li>
<!-- Menu Item Dashboard -->

<!-- Menu Item Tugas -->
<li>
    <a href="{{ route('member.tasks.index') }}" @click="selected = (selected === 'Tugas' ? '':'Tugas')"
        class="menu-item group hover:menu-item-active"
        :class="(page === 'Data Tugas' || page === 'Detail Tugas') ? 'menu-item-active' : 'menu-item-inactive'">
        <svg :class="(page === 'Data Tugas' || page === 'Detail Tugas') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
            width="24" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg"
            transform="rotate(0 0 0)">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M4.52344 4.25C4.52344 3.00736 5.5308 2 6.77344 2H17.2734C18.5161 2 19.5234 3.00736 19.5234 4.25V19.75C19.5234 20.9926 18.5161 22 17.2734 22H9.02344V22.75C9.02344 23.1642 8.68765 23.5 8.27344 23.5C7.85922 23.5 7.52344 23.1642 7.52344 22.75V22H6.77344C5.5308 22 4.52344 20.9926 4.52344 19.75V4.25ZM6.02344 15.833V19.75C6.02344 20.1642 6.35922 20.5 6.77344 20.5H13.5234V15.833H6.02344ZM13.5234 14.333H6.02344V9.66699H13.5234V14.333ZM15.0234 15.833V20.5H17.2734C17.6877 20.5 18.0234 20.1642 18.0234 19.75V15.833H15.0234ZM18.0234 14.333H15.0234V9.66699H18.0234V14.333ZM18.0234 4.25V8.16699H15.0234V3.5H17.2734C17.6877 3.5 18.0234 3.83579 18.0234 4.25ZM13.5234 3.5V8.16699H6.02344V4.25C6.02344 3.83579 6.35922 3.5 6.77344 3.5H13.5234Z"
                fill="" />
        </svg>

        <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
            Tugas
        </span>
    </a>
</li>
<!-- Menu Item Tugas -->

<!-- Menu Item Aktivitas -->
<li>
    <a href="{{ route('member.activities.index') }}" @click="selected = (selected === 'Aktivitas' ? '':'Aktivitas')"
        class="menu-item group"
        :class="(page === 'Data Aktivitas' || page === 'Tambah Aktivitas' || page === 'Edit Aktivitas' || page === 'Detail Aktivitas') ? 'menu-item-active' : 'menu-item-inactive'">
        <svg :class="(page === 'Data Aktivitas' || page === 'Tambah Aktivitas' || page === 'Edit Aktivitas' || page === 'Detail Aktivitas') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
            width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
            transform="rotate(0 0 0)">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M6.75 2C5.50736 2 4.5 3.00736 4.5 4.25V6.25H3.25C2.83579 6.25 2.5 6.58579 2.5 7C2.5 7.41421 2.83579 7.75 3.25 7.75H4.5V11.25H3.25C2.83579 11.25 2.5 11.5858 2.5 12C2.5 12.4142 2.83579 12.75 3.25 12.75H4.5V16.25H3.25C2.83579 16.25 2.5 16.5858 2.5 17C2.5 17.4142 2.83579 17.75 3.25 17.75H4.5V19.75C4.5 20.9926 5.50736 22 6.75 22H17.25C18.4926 22 19.5 20.9926 19.5 19.75V4.25C19.5 3.00736 18.4926 2 17.25 2H6.75ZM6 17.75V19.75C6 20.1642 6.33579 20.5 6.75 20.5H17.25C17.6642 20.5 18 20.1642 18 19.75V4.25C18 3.83579 17.6642 3.5 17.25 3.5H6.75C6.33579 3.5 6 3.83579 6 4.25V6.25H7.25C7.66421 6.25 8 6.58579 8 7C8 7.41421 7.66421 7.75 7.25 7.75H6V11.25H7.25C7.66421 11.25 8 11.5858 8 12C8 12.4142 7.66421 12.75 7.25 12.75H6V16.25H7.25C7.66421 16.25 8 16.5858 8 17C8 17.4142 7.66421 17.75 7.25 17.75H6Z"
                fill="" />
        </svg>

        <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
            Aktivitas
        </span>
    </a>
</li>
<!-- Menu Item Aktivitas -->