<div class="py-4 text-gray-500 dark:text-gray-400">
    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
        SIAGOSIS
    </a>

    @php
        $role = auth()->user()->role;
        $dashboardUrl = '';
        $dashboardPath = '';
        $isSubMenuOpen = [
            'master' => false,
        ];

        switch ($role) {
            case 'admin':
                $dashboardUrl = route('admin.dashboard');
                $dashboardPath = '/admin/dashboard';
                $isSubMenuOpen['master'] =
                    request()->is('admin/siswa*') ||
                    request()->is('admin/guru*') ||
                    request()->is('admin/ortu*') ||
                    request()->is('admin/users*') ||
                    request()->is('admin/kelas*') ||
                    request()->is('admin/mapel*') ||
                    request()->is('admin/jadwal*') ||
                    request()->is('admin/guru-mapel*');
                break;
            case 'guru':
                $dashboardUrl = route('guru.dashboard');
                $dashboardPath = '/guru/dashboard';
                break;
            case 'siswa':
                $dashboardUrl = route('siswa.dashboard');
                $dashboardPath = '/siswa/dashboard';
                break;
            case 'orangtua':
                $dashboardUrl = route('orangtua.dashboard');
                $dashboardPath = '/orangtua/dashboard';
                break;
        }
    @endphp

    <ul class="mt-6">
        <li class="relative px-6 py-3">
            <span
                class="absolute inset-y-0 left-0 w-1 rounded-tr-lg rounded-br-lg {{ request()->is(ltrim($dashboardPath, '/')) ? 'bg-purple-600' : '' }}"
                aria-hidden="true"></span>
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->is(ltrim($dashboardPath, '/')) ? 'text-gray-800 dark:text-gray-100' : '' }}"
                href="{{ $dashboardUrl }}">
                <i class="w-5 h-5 fas fa-home"></i>
                <span class="ml-4">Dashboard</span>
            </a>
        </li>
    </ul>

    @if ($role == 'admin')
        @include('layouts.partials.menu-admin', ['isSubMenuOpen' => $isSubMenuOpen])
    @elseif ($role == 'guru')
        @include('layouts.partials.menu-guru')
    @elseif ($role == 'siswa')
        @include('layouts.partials.menu-siswa')
    @elseif ($role == 'orangtua')
        @include('layouts.partials.menu-orangtua')
    @endif

    <div class="px-6 my-6">
        <a href="{{ url('/') }}"
            class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            <span>Landing Page</span>
            <i class="ml-2 fas fa-sign-out-alt"></i>
        </a>
    </div>
</div>
