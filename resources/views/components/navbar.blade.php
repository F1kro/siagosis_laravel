<div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
    <button type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 md:hidden" @click="document.getElementById('sidebar').classList.toggle('hidden')">
        <span class="sr-only">Open sidebar</span>
        <i class="fas fa-bars"></i>
    </button>
    <div class="flex-1 px-4 flex justify-between">
        <div class="flex-1 flex items-center">
            <h1 class="text-xl font-semibold text-gray-800">
                @if(auth()->user()->isAdmin())
                    Admin Panel
                @elseif(auth()->user()->isGuru())
                    Panel Guru
                @elseif(auth()->user()->isSiswa())
                    Panel Siswa
                @elseif(auth()->user()->isOrangtua())
                    Panel Orang Tua
                @endif
            </h1>
        </div>
        <div class="ml-4 flex items-center md:ml-6">
            <!-- Notification dropdown -->
            <div class="ml-3 relative" x-data="{ open: false }">
                <button type="button" class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" @click="open = !open">
                    <span class="sr-only">View notifications</span>
                    <i class="fas fa-bell"></i>
                </button>
                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" style="display: none;">
                    <div class="px-4 py-2 border-b border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700">Notifikasi</h3>
                    </div>
                    <div class="max-h-60 overflow-y-auto">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <p class="font-medium">Pengumuman Ujian</p>
                            <p class="text-xs text-gray-500">2 jam yang lalu</p>
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <p class="font-medium">Nilai telah diupdate</p>
                            <p class="text-xs text-gray-500">5 jam yang lalu</p>
                        </a>
                    </div>
                    <div class="px-4 py-2 border-t border-gray-200">
                        <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-500">Lihat semua notifikasi</a>
                    </div>
                </div>
            </div>

            <!-- Profile dropdown -->
            <div class="ml-3 relative" x-data="{ open: false }">
                <div>
                    <button type="button" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" @click="open = !open">
                        <span class="sr-only">Open user menu</span>
                        <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=0D8ABC&color=fff" alt="{{ auth()->user()->name }}">
                    </button>
                </div>
                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" style="display: none;">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>