# SIAGOSIS - Sistem Informasi Siswa, Guru, dan Orang Tua

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql)

## Deskripsi

[cite_start]SIAGOSIS adalah Sistem Informasi berbasis web yang dikembangkan untuk memenuhi tugas mata kuliah Sistem Informasi di Universitas Mataram. [cite_start]Proyek ini dirancang sebagai solusi atas tantangan dalam sistem pendidikan, seperti kurangnya pengawasan kehadiran siswa, komunikasi yang tidak efektif antara sekolah dan orang tua, serta terbatasnya akses data akademik secara *real-time*.

[cite_start]Aplikasi ini tidak hanya mempermudah pencatatan dan pelaporan untuk guru dan admin, tetapi juga menyediakan portal bagi orang tua untuk memantau perkembangan anak mereka secara transparan [cite: 9, 13][cite_start], dengan tujuan utama mengurangi angka ketidakhadiran, meningkatkan tanggung jawab siswa, dan membangun hubungan yang lebih baik antara semua pihak yang terlibat dalam pendidikan.

## Tampilan Aplikasi (Screenshots)

Berikut adalah beberapa tampilan dari prototipe SIAGOSIS:

| Halaman Login | Dashboard Siswa | To-Do List Siswa |
| :---: | :---: | :---: |
| ![Screenshot Login](httpshttps://i.imgur.com/4gH4A3q.png) | ![Screenshot Dashboard Siswa](https://i.imgur.com/uX1Jz9h.png) | ![Screenshot To-Do List](https://i.imgur.com/Y6D7b3T.png) |
| **Dashboard Orang Tua** | **Rekap Presensi (Orang Tua)** | **Dashboard Admin** |
| ![Screenshot Dashboard Orang Tua](https://i.imgur.com/BfxsJ3t.png) | ![Screenshot Rekap Presensi](https://i.imgur.com/gK95J5Q.png) | ![Screenshot Dashboard Admin](https://i.imgur.com/Wl8J2N1.png) |

## Fitur Utama
[cite_start]Aplikasi ini memiliki beberapa fitur inti yang terbagi berdasarkan peran pengguna (Aktor):

### 👤 Operator / Admin
- [cite_start]**Manajemen Pengguna:** Membuat, mengubah, dan menghapus akun untuk siswa, guru, dan orang tua.
- [cite_start]**Manajemen Data Master:** Mengelola data inti seperti data siswa, guru, kelas, dan mata pelajaran.
- [cite_start]**Dashboard Statistik:** Memantau data agregat seperti total siswa, guru, orang tua/wali, dan rerata nilai dalam bentuk grafik.

### 👮 Guru
- [cite_start]**Manajemen Akademik:** Menginput dan mengelola data presensi dan nilai siswa.
- [cite_start]**Catatan Perilaku:** Memberikan umpan balik atau catatan terkait perilaku siswa.
- [cite_start]**Analisis Kinerja:** Menganalisis kinerja kelas dan menghasilkan laporan untuk membantu perencanaan pengajaran.
- [cite_start]**Komunikasi:** Mengirimkan notifikasi dan berkomunikasi dengan orang tua.

### 👨‍👩‍👧‍👦 Orang Tua
- [cite_start]**Pemantauan Real-time:** Mengakses informasi kehadiran, nilai, ranking, dan catatan perilaku anak secara *real-time*.
- [cite_start]**Komunikasi Langsung:** Menghubungi guru atau wali kelas secara langsung melalui sistem.
- [cite_start]**Menerima Notifikasi:** Mendapatkan pemberitahuan penting dari sekolah terkait kegiatan atau perkembangan anak.

### 🎓 Siswa
- [cite_start]**Dashboard Pribadi:** Mengakses informasi jadwal pelajaran, nilai, rekap absensi, dan catatan perilaku.
- [cite_start]**Manajemen Tugas:** Menggunakan fitur To-Do List untuk mencatat tugas dan menerima notifikasi deadline.
- [cite_start]**Informasi Sekolah:** Melihat berita dan pengumuman penting dari sekolah.

## Teknologi yang Digunakan
[cite_start]Berdasarkan analisis kelayakan, proyek ini dikembangkan sebagai **Sistem Berbasis Web**  [cite_start]dengan pertimbangan biaya yang lebih rendah dan implementasi yang lebih sederhana.
- [cite_start]**Framework:** [Laravel](https://laravel.com) (Direkomendasikan dalam dokumen) 
- **Bahasa Pemrograman:** PHP
- **Database:** MySQL
- [cite_start]**Arsitektur:** Sistem Tersentralisasi berbasis Cloud 

## Instalasi & Konfigurasi Lokal
Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan pengembangan lokal Anda.

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/F1kro/siagosis_laravel.git](https://github.com/F1kro/siagosis_laravel.git)
    cd siagosis_laravel
    ```

2.  **Install Dependensi**
    Pastikan Anda memiliki Composer dan NPM terinstal.
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Lingkungan**
    Salin file `.env.example` menjadi `.env`.
    ```bash
    cp .env.example .env
    ```

4.  **Generate Kunci Aplikasi**
    ```bash
    php artisan key:generate
    ```

5.  **Atur Koneksi Database**
    Buka file `.env` dan sesuaikan pengaturan database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=user_database_anda
    DB_PASSWORD=password_anda
    ```

6.  **Jalankan Migrasi & Seeder**
    Perintah ini akan membuat semua tabel yang diperlukan di database Anda dan mengisi data awal (jika ada seeder, misalnya untuk akun admin, guru, dan orang tua contoh).
    ```bash
    php artisan migrate --seed
    ```

7.  **Build Aset Frontend**
    ```bash
    npm run build
    ```
    Atau untuk mode pengembangan:
    ```bash
    npm run dev
    ```

8.  **Jalankan Server Lokal**
    ```bash
    php artisan serve
    ```
    Aplikasi Anda sekarang akan berjalan di `http://127.0.0.1:8000`.

## Tim Pengembang
[cite_start]Proyek ini disusun oleh **Kelompok 1** dari Program Studi Teknik Informatika, Fakultas Teknik, Universitas Mataram.
- I Putu Ananta Sugiartha (F1D02310113)
- Fiqro Najiah (F1D02310051)
- Ahmad Madani (F1D02310101)
- Zainul Majdi (F1D02310028)
- Nanang Alifian Riski Fakhroni (F1D02310128)

[cite_start]Dosen Pengampu: **Herliana Rosika, S.Kom., M.Kom.**.

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE.md).
