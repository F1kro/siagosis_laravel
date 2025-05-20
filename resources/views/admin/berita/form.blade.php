@php
    $berita = $berita ?? $beritum ?? null;
@endphp

<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{ isset($berita) ? 'Edit' : 'Tambah' }} Berita
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ isset($berita) ? route('admin.berita.update', $berita->id) : route('admin.berita.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($berita))
                @method('PUT')
            @endif

            {{-- Judul --}}
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Judul</span>
                <input
                    type="text"
                    name="judul"
                    value="{{ old('judul', $berita->judul ?? '') }}"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    required
                    placeholder="Masukan Judul"
                />
                @error('judul')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Kategori --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Kategori</span>
                <select
                    name="kategori"
                    class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300"
                    required
                >
                    <option value="">-- Pilih Kategori --</option>
                    @foreach(['Pendidikan', 'Informasi', 'Kegiatan', 'Pengumuman'] as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori', $berita->kategori ?? '') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Status --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Status</span>
                <select
                    name="status"
                    class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300"
                    required
                >
                    @foreach(['Unpublish', 'Published', 'Arsip'] as $status)
                        <option value="{{ $status }}" {{ old('status', $berita->status ?? 'Unpublish') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Konten --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Konten</span>
                <textarea
                    name="konten"
                    id="konten"
                    rows="10"
                    class="block w-full mt-1 text-sm form-textarea dark:bg-gray-700 dark:text-gray-300"
                    required
                >{{ old('konten', $berita->konten ?? '') }}</textarea>
                @error('konten')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Foto --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Foto (opsional)</span>
                <input
                    type="file"
                    name="foto"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                />
                @error('foto')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
                @if(isset($berita) && $berita->foto)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $berita->foto) }}" alt="Foto saat ini" class="w-32 rounded shadow">
                    </div>
                @endif
            </label>

            {{-- Submit --}}
            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white bg-purple-600 rounded-lg hover:bg-purple-700"
                >
                    {{ isset($berita) ? 'Update' : 'Simpan' }} Berita
                </button>
            </div>
        </form>
    </div>
</div>

{{-- CKEditor --}}
@push('scripts')
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('konten', {
            filebrowserUploadUrl: "{{ route('admin.berita.upload') }}?_token={{ csrf_token() }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
