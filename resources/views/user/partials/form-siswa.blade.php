<div>
    <label for="nisn" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NISN</label>
    <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn ?? '') }}"
           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('nisn') border-red-500 @enderror">
    @error('nisn') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
</div>

<div>
    <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
    <input type="text" name="nama" id="nama" value="{{ old('nama', $siswa->nama ?? '') }}"
           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('nama') border-red-500 @enderror">
    @error('nama') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
</div>

<div>
    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin</label>
    <select name="jenis_kelamin" id="jenis_kelamin"
            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray @error('jenis_kelamin') border-red-500 @enderror">
        <option value="Laki-laki" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki')>Laki-laki</option>
        <option value="Perempuan" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan')>Perempuan</option>
    </select>
    @error('jenis_kelamin') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
</div>

<div>
    <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tempat Lahir</label>
    <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}"
           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('tempat_lahir') border-red-500 @enderror">
    @error('tempat_lahir') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
</div>

<div>
    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}"
           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('tanggal_lahir') border-red-500 @enderror">
    @error('tanggal_lahir') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
</div>

<div>
    <label for="agama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Agama</label>
    <input type="text" name="agama" id="agama" value="{{ old('agama', $siswa->agama ?? '') }}"
           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('agama') border-red-500 @enderror">
    @error('agama') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
</div>

<div>
    <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
    <textarea name="alamat" id="alamat" rows="3"
              class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray @error('alamat') border-red-500 @enderror">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
    @error('alamat') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
</div>