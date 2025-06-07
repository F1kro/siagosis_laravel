<aside class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block" x-data="{
    isPagesMenuOpen: false,
    currentRoute: window.location.pathname,
    checkActive(route) {
        // pake startsWith untuk mencocokkan rute dasar
        return this.currentRoute.startsWith(route);
    },
    updateCurrentRoute() {
        this.currentRoute = window.location.pathname;
        // Logic untuk membuka submenu Master Data secara otomatis jika salah satu submenu-nya aktif
        this.isPagesMenuOpen = this.checkActive('/admin/siswa') ||
            this.checkActive('/admin/guru') ||
            this.checkActive('/admin/ortu') ||
            this.checkActive('/admin/users') ||
            this.checkActive('/admin/kelas') ||
            this.checkActive('/admin/mapel') ||
            this.checkActive('/admin/jadwal') ||
            this.checkActive('/admin/guru-mapel');
    }
}"
    x-init="updateCurrentRoute()" @update-route.window="updateCurrentRoute()">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
            SIAGOSIS
        </a>

        {{-- biar ga buat ulang dashboard --}}
        @php
            $role = auth()->user()->role;
            $dashboardUrl = '';
            $dashboardPathForAlpine = '';

            switch ($role) {
                case 'admin':
                    $dashboardUrl = route('admin.dashboard');
                    $dashboardPathForAlpine = '/admin/dashboard';
                    break;
                case 'guru':
                    $dashboardUrl = route('guru.dashboard');
                    $dashboardPathForAlpine = '/guru/dashboard';
                    break;
                case 'siswa':
                    $dashboardUrl = route('siswa.dashboard');
                    $dashboardPathForAlpine = '/siswa/dashboard';
                    break;
                case 'orangtua':
                    $dashboardUrl = route('orangtua.dashboard');
                    $dashboardPathForAlpine = '/orangtua/dashboard';
                    break;
            }
        @endphp

        <ul class="mt-6">
            <li class="relative px-6 py-3">
                <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
                    x-show="checkActive('{{ $dashboardPathForAlpine }}')"></span>

                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-100"
                    href="{{ $dashboardUrl }}"
                    :class="{
                        'text-gray-800 dark:text-gray-100': checkActive('{{ $dashboardPathForAlpine }}'),
                        'text-gray-600 dark:text-gray-400': !checkActive('{{ $dashboardPathForAlpine }}')
                    }"
                    @click="isPagesMenuOpen = false">
                    <i class="w-5 h-5 fas fa-home"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>

        {{-- Admin Menu --}}
        @if (auth()->user()->role == 'admin')
            <ul>
                <li class="relative px-6 py-3" :class="{ 'bg-indigo-50 dark:bg-indigo-900': isPagesMenuOpen }">
                    <button
                        class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': isPagesMenuOpen, 'text-gray-600 dark:text-gray-400': !
                                isPagesMenuOpen }"
                        @click="isPagesMenuOpen = !isPagesMenuOpen" aria-haspopup="true">
                        <span class="inline-flex items-center">
                            <i class="w-5 h-5 fas fa-database"></i>
                            <span class="ml-4">Master Data</span>
                        </span>
                        <i class="w-4 h-4 pl-0 pr-1 mr-1 fas fa-chevron-down"
                            :class="{ 'transform rotate-180': isPagesMenuOpen }"></i>
                    </button>
                    <template x-if="isPagesMenuOpen">
                        <ul x-transition:enter="transition-all ease-in-out duration-300"
                            x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl"
                            x-transition:leave="transition-all ease-in-out duration-300"
                            x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0"
                            class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                            aria-label="submenu">
                            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                :class="{ 'bg-red-100 dark:bg-red-600 text-red-600 dark:text-gray-300 dark:rounded-md rounded-md': checkActive(
                                        '/admin/siswa') }">
                                <a class="w-full"
                                    :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                                        '/admin/siswa'), 'text-gray-600 dark:text-gray-400': !checkActive(
                                            '/admin/siswa') }"
                                    href="{{ route('admin.siswa.index') }}"><i
                                        class="mr-2 fas fa-user-graduate"></i>Data Siswa</a>
                            </li>
                            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                :class="{ 'bg-red-100 dark:bg-red-600 text-red-600 dark:text-gray-300 dark:rounded-md rounded-md': checkActive(
                                        '/admin/guru') }">
                                <a class="w-full"
                                    :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                                        '/admin/guru'), 'text-gray-600 dark:text-gray-400': !checkActive(
                                        '/admin/guru') }"
                                    href="{{ route('admin.guru.index') }}">
                                    <i class="mr-2 fas fa-chalkboard-teacher"></i>Data Guru
                                </a>
                            </li>
                            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                :class="{ 'bg-red-100 dark:bg-red-600 text-red-600 dark:text-gray-300 dark:rounded-md rounded-md': checkActive(
                                        '/admin/ortu') }">
                                <a class="w-full"
                                    :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                                        '/admin/ortu'), 'text-gray-600 dark:text-gray-400': !checkActive(
                                        '/admin/ortu') }"
                                    href="{{ route('admin.ortu.index') }}">
                                    <i class="mr-2 fas fa-user-friends"></i>Data Orang Tua
                                </a>
                            </li>
                            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                :class="{ 'bg-red-100 dark:bg-red-600 text-red-600 dark:text-gray-300 dark:rounded-md rounded-md': checkActive(
                                        '/admin/jadwal') }">
                                <a class="w-full"
                                    :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                                        '/admin/jadwal'), 'text-gray-600 dark:text-gray-400': !checkActive(
                                            '/admin/jadwal') }"
                                    href="{{ route('admin.jadwal.index') }}">
                                    <i class="mr-2 fas fa-user-friends"></i>Data Jadwal
                                </a>
                            </li>
                            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                :class="{ 'bg-red-100 dark:bg-red-600 text-red-600 dark:text-gray-300 dark:rounded-md rounded-md': checkActive(
                                        '/admin/users') }">
                                <a class="w-full"
                                    :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                                        '/admin/users'), 'text-gray-600 dark:text-gray-400': !checkActive(
                                            '/admin/users') }"
                                    href="{{ route('admin.users.index') }}"><i class="mr-2 fas fa-user-shield"></i>Data
                                    User</a>
                            </li>
                            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                :class="{ 'bg-red-100 dark:bg-red-600 text-red-600 dark:text-gray-300 dark:rounded-md rounded-md': checkActive(
                                        '/admin/kelas') }">
                                <a class="w-full"
                                    :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                                        '/admin/kelas'), 'text-gray-600 dark:text-gray-400': !checkActive(
                                            '/admin/kelas') }"
                                    href="{{ route('admin.kelas.index') }}"><i class="mr-2 fas fa-door-open"></i>Data
                                    Kelas</a>
                            </li>
                            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                :class="{ 'bg-red-100 dark:bg-red-600 text-red-600 dark:text-gray-300 dark:rounded-md rounded-md': checkActive(
                                        '/admin/mapel') }">
                                <a class="w-full"
                                    :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                                        '/admin/mapel'), 'text-gray-600 dark:text-gray-400': !checkActive(
                                            '/admin/mapel') }"
                                    href="{{ route('admin.mapel.index') }}"><i class="mr-2 fas fa-book"></i>Data
                                    Mapel</a>
                            </li>
                            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                :class="{ 'bg-red-100 dark:bg-red-600 text-red-600 dark:text-gray-300 dark:rounded-md rounded-md': checkActive(
                                        '/admin/guru-mapel') }">
                                <a class="w-full"
                                    :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                                        '/admin/guru-mapel'), 'text-gray-600 dark:text-gray-400': !checkActive(
                                            '/admin/guru-mapel') }"
                                    href="{{ route('admin.guru-mapel.index') }}"><i
                                        class="mr-2 fas fa-chalkboard-teacher"></i>Data Guru Mapel
                                </a>
                            </li>
                        </ul>
                    </template>
                </li>
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/admin/absensi')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/admin/absensi'), 'text-gray-600 dark:text-gray-400': !checkActive('/admin/absensi') }"
                        href="{{ route('admin.absensi.index') }}">
                        <i class="w-5 h-5 fas fa-clipboard-list"></i>
                        <span class="ml-4">Master Absensi</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 ">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/admin/nilai')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/admin/nilai'), 'text-gray-600 dark:text-gray-400': !checkActive('/admin/nilai') }"
                        href="{{ route('admin.nilai.index') }}">
                        <i class="w-5 h-5 fas fa-star"></i>
                        <span class="ml-4">Master Nilai</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/admin/laporan')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/admin/laporan'), 'text-gray-600 dark:text-gray-400': !checkActive('/admin/laporan') }"
                        href="{{ route('admin.siswa.index') }}">
                        <i class="w-5 h-5 fas fa-file-alt"></i>
                        <span class="ml-4">Master Laporan</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/admin/berita')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/admin/berita'), 'text-gray-600 dark:text-gray-400': !checkActive('/admin/berita') }"
                        href="{{ route('admin.berita.index') }}">
                        <i class="w-5 h-5 fas fa-newspaper"></i>
                        <span class="ml-4">Master Berita</span>
                    </a>
                </li>
            </ul>

            {{-- Guru Menu --}}
        @elseif(auth()->user()->role == 'guru')
            <ul>
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/guru/absensi')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/guru/absensi'), 'text-gray-600 dark:text-gray-400': !checkActive('/guru/absensi') }"
                        href="{{ route('guru.absensi.index') }}">
                        <i class="w-5 h-5 fas fa-clipboard-list"></i>
                        <span class="ml-4">Master Absensi</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 ">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/guru/nilai')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/guru/nilai'), 'text-gray-600 dark:text-gray-400': !checkActive('/guru/nilai') }"
                        href="{{ route('guru.nilai.dashboard') }}">
                        <i class="w-5 h-5 fas fa-star"></i>
                        <span class="ml-4">Master Nilai</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 ">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/guru/jadwal')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/guru/jadwal'), 'text-gray-600 dark:text-gray-400': !checkActive('/guru/jadwal') }"
                        href="{{ route('guru.jadwal.semua') }}">
                        <i class="w-5 h-5 fas fa-star"></i>
                        <span class="ml-4">Master jadwal</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/guru/berita')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/guru/berita'), 'text-gray-600 dark:text-gray-400': !checkActive('/guru/berita') }"
                        href="{{ route('guru.berita.index') }}">
                        <i class="w-5 h-5 fas fa-newspaper"></i>
                        <span class="ml-4">Berita</span>
                    </a>
                </li>
            </ul>

            {{-- Siswa Menu --}}
        @elseif(auth()->user()->role == 'siswa')
            <ul>
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/siswa/todolist')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/siswa/todolist'), 'text-gray-600 dark:text-gray-400': !checkActive('/siswa/todolist') }"
                        href="{{ route('siswa.todolist.index') }}">
                        <i class="w-5 h-5 fas fa-list-check"></i>
                        <span class="ml-4">Data Todolist</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/siswa/absensi')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/siswa/absensi'), 'text-gray-600 dark:text-gray-400': !checkActive('/siswa/absensi') }"
                        href="{{ route('siswa.absensi.index') }}">
                        <i class="w-5 h-5 fas fa-clipboard-list"></i>
                        <span class="ml-4">Data Absensi</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 ">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/siswa/nilai')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/siswa/nilai'), 'text-gray-600 dark:text-gray-400': !checkActive('/siswa/nilai') }"
                        href="{{ route('siswa.nilai.index') }}">
                        <i class="w-5 h-5 fas fa-star"></i>
                        <span class="ml-4">Data Nilai</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 ">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/siswa/jadwal')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/siswa/jadwal'), 'text-gray-600 dark:text-gray-400': !checkActive('/siswa/jadwal') }"
                        href="{{ route('siswa.jadwal.index') }}">
                        <i class="w-5 h-5 fas fa-calendar-days"></i>
                        <span class="ml-4">Data Jadwal</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/siswa/berita')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/siswa/berita'), 'text-gray-600 dark:text-gray-400': !checkActive('/siswa/berita') }"
                        href="{{ route('siswa.berita.index') }}">
                        <i class="w-5 h-5 fas fa-newspaper"></i>
                        <span class="ml-4">Berita & Info Sekolah</span>
                    </a>
                </li>
            </ul>

            {{-- Orang Tua Menu --}}
        @elseif(auth()->user()->role == 'orangtua')
            <ul>
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/orangtua/absensi')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/orangtua/absensi'), 'text-gray-600 dark:text-gray-400': !checkActive(
                            '/orangtua/absensi') }"
                        href="{{ route('orangtua.absensi.index') }}">
                        <i class="w-5 h-5 fas fa-clipboard-list"></i>
                        <span class="ml-4">Data Absensi</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 ">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/orangtua/nilai')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/orangtua/nilai'), 'text-gray-600 dark:text-gray-400': !checkActive('/orangtua/nilai') }"
                        href="{{ route('orangtua.nilai.index') }}">
                        <i class="w-5 h-5 fas fa-star"></i>
                        <span class="ml-4">Data Nilai</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-3 bg-red-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true" x-show="checkActive('/orangtua/berita')"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        :class="{ 'text-gray-800 dark:text-gray-100': checkActive(
                            '/orangtua/berita'), 'text-gray-600 dark:text-gray-400': !checkActive('/orangtua/berita') }"
                        href="#">
                        <i class="w-5 h-5 fas fa-newspaper"></i>
                        <span class="ml-4">Berita & Info Sekolah</span>
                    </a>
                </li>
            </ul>
        @endif

        {{-- landing page button --}}
        <div class="px-6 my-6">
            <a href="{{ url('/') }}"
                class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-400 focus:outline-none focus:shadow-outline-red">
                <span>Landing Page</span>
                <i class="ml-2 fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</aside>


<!-- Mobile Sidebar Overlay -->
<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" @click="isSideMenuOpen = false"
    class="fixed inset-0 z-10 bg-black bg-opacity-50 md:hidden"></div>

<!-- Mobile Sidebar -->
<aside class="fixed inset-y-0 left-0 z-20 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
    x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="transform -translate-x-full" x-transition:enter-end="transform translate-x-0"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="transform translate-x-0"
    x-transition:leave-end="transform -translate-x-full" @keydown.escape.window="isSideMenuOpen = false">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
            SIAGOSIS
        </a>

        <ul class="mt-6">
            <!-- Dashboard -->
            <li class="relative px-6 py-3">
                <span class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"></span>
                <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                    href="{{ route('admin.dashboard') }}">
                    <i class="w-5 h-5 fas fa-home"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>

        <ul>
            <!-- Master Data -->
            <li class="relative px-6 py-3">
                <button
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    @click="$refs.masterDataMenu.classList.toggle('hidden')">
                    <span class="inline-flex items-center">
                        <i class="w-5 h-5 fas fa-database"></i>
                        <span class="ml-4">Master Data</span>
                    </span>
                    <i class="w-4 h-4 fas fa-chevron-down"></i>
                </button>
                <ul x-ref="masterDataMenu"
                    class="hidden p-2 mt-2 space-y-2 text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900">
                    <li class="px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <a class="w-full" href="{{ route('admin.siswa.index') }}">
                            <i class="mr-2 fas fa-user-graduate"></i>Data Siswa
                        </a>
                    </li>
                    <li class="px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <a class="w-full" href="{{ route('admin.guru.index') }}">
                            <i class="mr-2 fas fa-chalkboard-teacher"></i>Data Guru
                        </a>
                    </li>
                    <li class="px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <a class="w-full" href="{{ route('admin.siswa.index') }}">
                            <i class="mr-2 fas fa-users"></i>Data Orang-Tua
                        </a>
                    </li>
                    <li class="px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <a class="w-full" href="{{ route('admin.siswa.index') }}">
                            <i class="mr-2 fas fa-user-shield"></i>Data User
                        </a>
                    </li>
                    <li class="px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <a class="w-full" href="{{ route('admin.kelas.index') }}">
                            <i class="mr-2 fas fa-door-open"></i>Data Kelas
                        </a>
                    </li>
                    <li class="px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <a class="w-full" href="{{ route('admin.mapel.index') }}">
                            <i class="mr-2 fas fa-book"></i>Data Mapel
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Other Menu Items -->
            <li class="relative px-6 py-3">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('admin.absensi.index') }}">
                    <i class="w-5 h-5 fas fa-clipboard-list"></i>
                    <span class="ml-4">Master Absensi</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('admin.nilai.index') }}">
                    <i class="w-5 h-5 fas fa-star"></i>
                    <span class="ml-4">Master Nilai</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('admin.siswa.index') }}">
                    <i class="w-5 h-5 fas fa-file-alt"></i>
                    <span class="ml-4">Master Laporan</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('admin.berita.index') }}">
                    <i class="w-5 h-5 fas fa-newspaper"></i>
                    <span class="ml-4">Master Berita</span>
                </a>
            </li>
        </ul>

        <!-- Logout Button -->
        <div class="px-6 my-6">
            <a href="{{ route('logout') }}"
                class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-400 focus:outline-none focus:shadow-outline-red">
                <span>Logout</span>
                <i class="ml-2 fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</aside>
