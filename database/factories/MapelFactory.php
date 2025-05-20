<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MapelFactory extends Factory
{
    public function definition()
    {
        $namaMapel = $this->faker->randomElement([
            'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris',
            'Fisika', 'Kimia', 'Biologi', 'Ekonomi', 'Geografi',
            'Sosiologi', 'Sejarah', 'PKN', 'Seni Budaya'
        ]);

        return [
            'kode' => strtoupper(Str::slug(substr($namaMapel, 0, 3))) . sprintf('%03d', rand(1, 999)),
            'nama' => $namaMapel,
            'kkm' => 75,
            'jumlah_jam' => $this->faker->numberBetween(2, 5),
        ];
    }
}
