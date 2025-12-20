<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    protected $model = Mahasiswa::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jurusan = ['Sistem Informasi', 'Teknik Informatika', 'Administrasi Bisnis', 'Akutansi'];
        
        return [
            'nim' => fake()->unique()->numerify('##############'),
            'nama_lengkap' => fake()->name(),
            'jurusan' => fake()->randomElement($jurusan),
            'tempat_lahir' => fake()->city() . ', ' . fake()->country(),
            'tanggal_lahir' => fake()->date('Y-m-d', '-18 years'),
            'nomor_telepon' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'alamat_tinggal' => fake()->address(),
            'foto' => null,
        ];
    }
}
