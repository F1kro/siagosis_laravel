<form action="{{ isset($todo) ? route('siswa.todolist.update', $todo->id) : route('siswa.todolist.store') }}"
    method="POST">
    @csrf
    @if (isset($todo))
        @method('PUT')
    @endif

    <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400">Judul Tugas <span class="text-red-500">*</span></span>
        <input class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input"
            name="judul" placeholder="Contoh: Mengerjakan LKS Halaman 50" value="{{ old('judul', $todo->judul ?? '') }}"
            required />
    </label>

    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">Mata Pelajaran (Opsional)</span>
        <select name="mapel_id"
            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select">
            <option value="">Tugas Pribadi / Lainnya</option>
            @foreach ($mapels as $mapel)
                <option value="{{ $mapel->id }}"
                    {{ old('mapel_id', $todo->mapel_id ?? '') == $mapel->id ? 'selected' : '' }}>
                    {{ $mapel->nama }}
                </option>
            @endforeach
        </select>
    </label>

    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">Deadline <span class="text-red-500">*</span></span>
        <input type="date" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input"
            name="deadline" value="{{ old('deadline', isset($todo) ? $todo->deadline->format('Y-m-d') : '') }}"
            required />
    </label>

    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">Deskripsi (Opsional)</span>
        <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea"
            rows="3" name="deskripsi" placeholder="Tulis catatan tambahan di sini...">{{ old('deskripsi', $todo->deskripsi ?? '') }}</textarea>
    </label>

    <div class="mt-6">
        <button type="submit"
            class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            {{ isset($todo) ? 'Update Tugas' : 'Simpan Tugas' }}
        </button>
        <a href="{{ route('siswa.todolist.index') }}"
            class="px-5 py-3 font-medium leading-5 text-gray-700 transition-colors duration-150 bg-gray-100 border border-transparent rounded-lg dark:text-gray-400 dark:bg-gray-700">
            Batal
        </a>
    </div>
</form>
