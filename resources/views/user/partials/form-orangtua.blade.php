<div>
    <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
    <input type="text" name="nama" id="nama" value="{{ old('nama', $orangtua->nama ?? '') }}"
           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('nama') border-red-500 @enderror">
    @error('nama') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
</div>

<div>
    <label for="telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon</label>
    <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $orangtua->telepon ?? '') }}"
           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('telepon') border-red-500 @enderror">
    @error('telepon') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
</div>

<div>
    <label for="pekerjaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pekerjaan</label>
    <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan', $orangtua->pekerjaan ?? '') }}"
           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('pekerjaan') border-red-500 @enderror">
    @error('pekerjaan') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
</div>

<div>
    <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
    <textarea name="alamat" id="alamat" rows="3"
              class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray @error('alamat') border-red-500 @enderror">{{ old('alamat', $orangtua->alamat ?? '') }}</textarea>
    @error('alamat') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
</div>