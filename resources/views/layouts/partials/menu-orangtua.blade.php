<ul>
    <li class="relative px-6 py-3"><span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('orangtua/absensi*') ? 'bg-purple-600' : '' }}"></span><a
            class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('orangtua/absensi*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="{{ route('orangtua.absensi.index') }}"><i class="w-5 h-5 fas fa-clipboard-list"></i><span
                class="ml-4">Absensi Anak</span></a></li>
    <li class="relative px-6 py-3"><span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('orangtua/nilai*') ? 'bg-purple-600' : '' }}"></span><a
            class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('orangtua/nilai*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="{{ route('orangtua.nilai.index') }}"><i class="w-5 h-5 fas fa-star"></i><span class="ml-4">Nilai
                Anak</span></a></li>
    <li class="relative px-6 py-3"><span
            class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is('orangtua/berita*') ? 'bg-purple-600' : '' }}"></span><a
            class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is('orangtua/berita*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
            href="#"><i class="w-5 h-5 fas fa-newspaper"></i><span class="ml-4">Berita & Info</span></a></li>
</ul>
