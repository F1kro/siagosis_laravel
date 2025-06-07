@php
    $user = Auth::user();
    $photoPath = null;

    if ($user->isGuru() && $user->guru && $user->guru->foto) {
        $photoPath = $user->guru->foto;
    } elseif ($user->isSiswa() && $user->siswa && $user->siswa->foto) {
        $photoPath = $user->siswa->foto;
    } elseif ($user->isOrangtua() && $user->orangtua && $user->orangtua->foto) {
        $photoPath = $user->orangtua->foto;
    }
@endphp

<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
    <div class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
        <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple" @click="toggleSideMenu" aria-label="Menu">
            <i class="w-6 h-6 fas fa-bars"></i>
        </button>

        <div class="flex justify-center flex-1 lg:mr-32">
            <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    <i class="w-4 h-4 fas fa-search"></i>
                </div>
                <input
                    class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                    type="text"
                    placeholder="Search for projects"
                    aria-label="Search"
                />
            </div>
        </div>

        <ul class="flex items-center flex-shrink-0 space-x-6">
            <li class="flex">
                <button class="rounded-md focus:outline-none focus:shadow-outline-purple" @click="toggleTheme" aria-label="Toggle color mode">
                    <template x-if="!dark">
                        <i class="w-5 h-5 fas fa-moon"></i>
                    </template>
                    <template x-if="dark">
                        <i class="w-5 h-5 fas fa-sun"></i>
                    </template>
                </button>
            </li>

            <li class="relative">
                <button class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple" @click="toggleNotificationsMenu" @keydown.escape="closeNotificationsMenu" aria-label="Notifications" aria-haspopup="true">
                    <i class="w-5 h-5 fas fa-bell"></i>
                    <span aria-hidden="true" class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full dark:border-gray-800"></span>
                </button>
                <template x-if="isNotificationsMenuOpen">
                    <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeNotificationsMenu" @keydown.escape="closeNotificationsMenu" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:text-gray-300 dark:border-gray-700 dark:bg-gray-700">
                        <li class="flex">
                            <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                                <span>Messages</span>
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                                    13
                                </span>
                            </a>
                        </li>
                    </ul>
                </template>
            </li>

            <li class="relative">
                <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none" @click="toggleProfileMenu" @keydown.escape="closeProfileMenu" aria-label="Account" aria-haspopup="true">
                    @if ($photoPath)
                        <img class="object-cover w-8 h-8 rounded-full" src="{{ asset('storage/' . $photoPath) }}" alt="Foto Profil" aria-hidden="true" />
                    @else
                        <div class="flex items-center justify-center w-8 h-8 overflow-hidden bg-gray-200 rounded-full dark:bg-gray-700">
                            <i class="text-gray-500 fas fa-user dark:text-gray-400"></i>
                        </div>
                    @endif
                </button>
                <template x-if="isProfileMenuOpen">
                    <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeProfileMenu" @keydown.escape="closeProfileMenu" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700" aria-label="submenu">
                        <li class="flex">
                            <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="{{ route('user.profile') }}">
                                <i class="w-4 h-4 mr-3 fas fa-user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="flex">
                            <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="w-4 h-4 mr-3 fas fa-sign-out-alt"></i>
                                <span>Log out</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </template>
            </li>
        </ul>
    </div>
</header>