@php
    $isEdit = isset($user);
@endphp

@if ($errors->any())
    <div class="text-red-600">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{ $isEdit ? 'Edit' : 'Tambah' }} User
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ $isEdit ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <!-- Nama -->
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Nama</span>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Masukkan Nama" />
                @error('name')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <!-- Email -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Email</span>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Masukkan Email" />
                @error('email')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <!-- Role -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Role</span>

                <select
                    name="role"
                    class="block w-full mt-1 text-sm text-gray-500 bg-gray-100 form-select dark:bg-gray-700 dark:text-gray-400"
                    @if ($isEdit) disabled @endif
                >
                    <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru" {{ old('role', $user->role ?? '') == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="orangtua" {{ old('role', $user->role ?? '') == 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
                    <option value="siswa" {{ old('role', $user->role ?? '') == 'siswa' ? 'selected' : '' }}>Siswa</option>

                    @if ($isEdit)
                        <option disabled selected>
                            Role tidak bisa diubah. Buat user baru jika ada kesalahan.
                        </option>
                    @endif
                </select>

                {{-- Hidden input untuk tetap kirim role saat edit --}}
                @if ($isEdit)
                    <input type="hidden" name="role" value="{{ old('role', $user->role ?? '') }}">
                @endif
            </label>



            <!-- Password -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Password</span>
                <input type="password" name="password"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    placeholder="{{ $isEdit ? 'Biarkan kosong jika tidak diubah' : 'Masukkan Password' }}" />
                @error('password')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <!-- Password Confirmation -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Konfirmasi Password</span>
                <input type="password" name="password_confirmation"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Konfirmasi Password" />
            </label>

            <!-- Submit Button -->
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    {{ $isEdit ? 'Update' : 'Simpan' }} Data User
                </button>
            </div>
        </form>
    </div>
</div>
