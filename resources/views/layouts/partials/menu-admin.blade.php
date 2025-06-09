<ul>
    <li class="relative px-6 py-3" x-data="{ isPagesMenuOpen: {{ $isSubMenuOpen['master'] ? 'true' : 'false' }} }">

        <span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ $isSubMenuOpen['master'] ? 'bg-purple-600' : '' }}"
            aria-hidden="true"></span>

        <button
            class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ $isSubMenuOpen['master'] ? 'text-gray-800 dark:text-gray-100' : '' }}"
            @click="isPagesMenuOpen = !isPagesMenuOpen" aria-haspopup="true">
            <span class="inline-flex items-center">
                <i class="w-5 h-5 fas fa-database"></i>
                <span class="ml-4">Master Data</span>
            </span>
            <i class="w-4 h-4 fas fa-chevron-down" :class="{ 'rotate-180': isPagesMenuOpen }"></i>
        </button>
        <template x-if="isPagesMenuOpen">
            <ul x-transition:enter="transition-all ease-in-out duration-300"
                x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl"
                x-transition:leave="transition-all ease-in-out duration-300"
                x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0"
                class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                aria-label="submenu">
                <li
                    class="px-2 py-1 transition-colors duration-150 rounded-md hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('admin/siswa*') ? 'bg-purple-100 dark:bg-purple-800 text-gray-800 dark:text-gray-100' : '' }}">
                    <a class="w-full" href="{{ route('admin.siswa.index') }}"><i
                            class="mr-2 fas fa-user-graduate"></i>Data Siswa</a>
                </li>
                <li
                    class="px-2 py-1 transition-colors duration-150 rounded-md hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('admin/guru*') ? 'bg-purple-100 dark:bg-purple-800 text-gray-800 dark:text-gray-100' : '' }}">
                    <a class="w-full" href="{{ route('admin.guru.index') }}"><i
                            class="mr-2 fas fa-chalkboard-teacher"></i>Data Guru</a>
                </li>
                <li
                    class="px-2 py-1 transition-colors duration-150 rounded-md hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('admin/ortu*') ? 'bg-purple-100 dark:bg-purple-800 text-gray-800 dark:text-gray-100' : '' }}">
                    <a class="w-full" href="{{ route('admin.ortu.index') }}"><i
                            class="mr-2 fas fa-user-friends"></i>Data Orang Tua</a>
                </li>
                <li
                    class="px-2 py-1 transition-colors duration-150 rounded-md hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('admin/jadwal*') ? 'bg-purple-100 dark:bg-purple-800 text-gray-800 dark:text-gray-100' : '' }}">
                    <a class="w-full" href="{{ route('admin.jadwal.index') }}"><i
                            class="mr-2 fas fa-calendar-alt"></i>Data Jadwal</a>
                </li>
                <li
                    class="px-2 py-1 transition-colors duration-150 rounded-md hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('admin/users*') ? 'bg-purple-100 dark:bg-purple-800 text-gray-800 dark:text-gray-100' : '' }}">
                    <a class="w-full" href="{{ route('admin.users.index') }}"><i
                            class="mr-2 fas fa-user-shield"></i>Data User</a>
                </li>
                <li
                    class="px-2 py-1 transition-colors duration-150 rounded-md hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('admin/kelas*') ? 'bg-purple-100 dark:bg-purple-800 text-gray-800 dark:text-gray-100' : '' }}">
                    <a class="w-full" href="{{ route('admin.kelas.index') }}"><i class="mr-2 fas fa-door-open"></i>Data
                        Kelas</a>
                </li>
                <li
                    class="px-2 py-1 transition-colors duration-150 rounded-md hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('admin/mapel*') ? 'bg-purple-100 dark:bg-purple-800 text-gray-800 dark:text-gray-100' : '' }}">
                    <a class="w-full" href="{{ route('admin.mapel.index') }}"><i class="mr-2 fas fa-book"></i>Data
                        Mapel</a>
                </li>
                <li
                    class="px-2 py-1 transition-colors duration-150 rounded-md hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('admin/guru-mapel*') ? 'bg-purple-100 dark:bg-purple-800 text-gray-800 dark:text-gray-100' : '' }}">
                    <a class="w-full" href="{{ route('admin.guru-mapel.index') }}"><i class="mr-2 fas fa-link"></i>Data
                        Guru Mapel</a>
                </li>
            </ul>
        </template>
    </li>
    <li class="relative px-6 py-3"><span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('admin/absensi*') ? 'bg-purple-600' : '' }}"></span><a
            class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('admin/absensi*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="{{ route('admin.absensi.index') }}"><i class="w-5 h-5 fas fa-clipboard-list"></i><span
                class="ml-4">Master Absensi</span></a></li>
    <li class="relative px-6 py-3"><span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('admin/nilai*') ? 'bg-purple-600' : '' }}"></span><a
            class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('admin/nilai*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="{{ route('admin.nilai.index') }}"><i class="w-5 h-5 fas fa-star"></i><span class="ml-4">Master
                Nilai</span></a></li>
    <li class="relative px-6 py-3"><span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('admin/laporan*') ? 'bg-purple-600' : '' }}"></span><a
            class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('admin/laporan*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="{{ route('admin.laporan.index') }}"><i class="w-5 h-5 fas fa-file-alt"></i><span
                class="ml-4">Master Laporan</span></a></li>
    <li class="relative px-6 py-3"><span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('admin/ranking*') ? 'bg-purple-600' : '' }}"></span><a
            class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('admin/ranking*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="{{ route('admin.ranking.index') }}"><i class="w-5 h-5 fas fa-ranking-star"></i><span
                class="ml-4">Master Ranking</span></a></li>
    <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('admin/berita*') ? 'bg-purple-600' : '' }}">
        </span>
        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('admin/berita*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="{{ route('admin.berita.index') }}"><i class="w-5 h-5 fas fa-newspaper"></i>
            <span class="ml-4">Master Berita</span>
        </a>
    </li>
</ul>
