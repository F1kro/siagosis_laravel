<ul>
    <li class="relative px-6 py-3"><span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('guru/absensi*') ? 'bg-purple-600' : '' }}"></span><a
            class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('guru/absensi*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="{{ route('guru.absensi.index') }}"><i class="w-5 h-5 fas fa-clipboard-list"></i><span
                class="ml-4">Absensi Siswa</span></a></li>
    <li class="relative px-6 py-3"><span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('guru/nilai*') ? 'bg-purple-600' : '' }}"></span><a
            class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('guru/nilai*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="{{ route('guru.nilai.dashboard') }}"><i class="w-5 h-5 fas fa-star"></i><span class="ml-4">Input
                Nilai</span></a></li>
    <li class="relative px-6 py-3"><span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('guru/jadwal*') ? 'bg-purple-600' : '' }}"></span><a
            class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('guru/jadwal*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="{{ route('guru.jadwal.semua') }}"><i class="w-5 h-5 fas fa-calendar-alt"></i><span
                class="ml-4">Jadwal Mengajar</span></a></li>
    <li class="relative px-6 py-3"><span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('guru/ranking*') ? 'bg-purple-600' : '' }}"></span><a
            class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('guru/ranking*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="{{ route('guru.ranking.index') }}"><i class="w-5 h-5 fas fa-ranking-star"></i><span
                class="ml-4">Data Ranking</span></a></li>
    <li class="relative px-6 py-3"><span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('guru/berita*') ? 'bg-purple-600' : '' }}"></span><a
            class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('guru/berita*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="{{ route('guru.berita.index') }}"><i class="w-5 h-5 fas fa-newspaper"></i><span
                class="ml-4">Berita</span></a></li>
    <li class="relative px-6 py-3"><span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('guru/hubungi-ortu*') ? 'bg-purple-600' : '' }}"></span><a
            class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('guru/hubungi-ortu*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="{{ route('guru.hubungi.ortu') }}"><i class="w-5 h-5 fas fa-people-arrows"></i><span
                class="ml-4">Hubungi ortu</span></a></li>
</ul>
