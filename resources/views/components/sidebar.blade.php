<div class="flex flex-col h-full bg-primary-800 text-white">
    <div class="flex items-center justify-center h-16 px-4 bg-primary-900">
        <div class="flex items-center">
            <i class="fas fa-graduation-cap text-2xl mr-2"></i>
            <span class="text-lg font-semibold">SIAKAD</span>
        </div>
    </div>
    <div class="flex-1 flex flex-col overflow-y-auto">
        <nav class="flex-1 px-2 py-4 space-y-1">
            @if(auth()->user()->isAdmin())
                <x-sidebar-item route="admin.dashboard" icon="fas fa-tachometer-alt" text="Dashboard" />
                <x-sidebar-item route="admin.guru.index" icon="fas fa-chalkboard-teacher" text="Data Guru" />
                <x-sidebar-item route="admin.siswa.index" icon="fas fa-user-graduate" text="Data Siswa" />
                <x-sidebar-item route="admin.kelas.index" icon="fas fa-school" text="Data Kelas" />
                <x-sidebar-item route="admin.mapel.index" icon="fas fa-book" text="Mata Pelajaran" />
                <x-sidebar-item route="admin.jadwal.index" icon="fas fa-calendar-alt" text="Jadwal Pelajaran" />
                <x-sidebar-item route="admin.nilai.index" icon="fas fa-file-alt" text="Data Nilai" />
                <x-sidebar-item route="admin.absensi.index" icon="fas fa-clipboard-list" text="Data Absensi" />
                <x-sidebar-item route="admin.berita.index" icon="fas fa-newspaper" text="Berita" />
                <x-sidebar-item route="admin.guru-mapel.index" icon="fas fa-user-tie" text="Guru Mapel" />
            @elseif(auth()->user()->isGuru())
                <x-sidebar-item route="guru.dashboard" icon="fas fa-tachometer-alt" text="Dashboard" />
                <x-sidebar-item route="guru.nilai.index" icon="fas fa-file-alt" text="Data Nilai" />
                <x-sidebar-item route="guru.absensi.index" icon="fas fa-clipboard-list" text="Data Absensi" />
                <x-sidebar-item route="guru.mapel.index" icon="fas fa-book" text="Mata Pelajaran" />
                <x-sidebar-item route="guru.siswa.index" icon="fas fa-user-graduate" text="Daftar Siswa" />
                <x-sidebar-item route="guru.berita.index" icon="fas fa-newspaper" text="Berita" />
                <x-sidebar-item route="guru.notifikasi.index" icon="fas fa-bell" text="Notifikasi" />
                <x-sidebar-item route="guru.aktivitas.index" icon="fas fa-chart-line" text="Aktivitas" />
                <x-sidebar-item route="guru.pesan.index" icon="fas fa-envelope" text="Pesan" />
            @elseif(auth()->user()->isSiswa())
                <x-sidebar-item route="siswa.dashboard" icon="fas fa-tachometer-alt" text="Dashboard" />
                <x-sidebar-item route="siswa.nilai.index" icon="fas fa-file-alt" text="Nilai" />
                <x-sidebar-item route="siswa.kehadiran.index" icon="fas fa-clipboard-list" text="Kehadiran" />
                <x-sidebar-item route="siswa.jadwal.index" icon="fas fa-calendar-alt" text="Jadwal" />
                <x-sidebar-item route="siswa.mapel.index" icon="fas fa-book" text="Mata Pelajaran" />
                <x-sidebar-item route="siswa.todo.index" icon="fas fa-tasks" text="To-Do List" />
                <x-sidebar-item route="siswa.berita.index" icon="fas fa-newspaper" text="Berita" />
                <x-sidebar-item route="siswa.notifikasi.index" icon="fas fa-bell" text="Notifikasi" />
            @elseif(auth()->user()->isOrangtua())
                <x-sidebar-item route="orangtua.dashboard" icon="fas fa-tachometer-alt" text="Dashboard" />
                <x-sidebar-item route="orangtua.anak.index" icon="fas fa-child" text="Data Anak" />
                <x-sidebar-item route="orangtua.nilai.index" icon="fas fa-file-alt" text="Nilai Anak" />
                <x-sidebar-item route="orangtua.kehadiran.index" icon="fas fa-clipboard-list" text="Kehadiran Anak" />
                <x-sidebar-item route="orangtua.ranking.index" icon="fas fa-chart-bar" text="Ranking Anak" />
                <x-sidebar-item route="orangtua.pesan.index" icon="fas fa-envelope" text="Pesan" />
                <x-sidebar-item route="orangtua.notifikasi.index" icon="fas fa-bell" text="Notifikasi" />
            @endif
        </nav>
    </div>
    <div class="p-4 border-t border-primary-700">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-white rounded-md bg-primary-700 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i class="fas fa-sign-out-alt mr-2"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>