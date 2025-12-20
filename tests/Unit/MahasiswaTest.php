<?php

namespace Tests\Unit;

use App\Models\Mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaTest extends TestCase
{
    use RefreshDatabase;

    public function test_hitung_usia_mahasiswa(): void
    {
        $mahasiswa = new Mahasiswa([
            "tanggal_lahir" => "1999-02-10"
        ]);
        $this->assertEquals(26, $mahasiswa->hitungUmur());
    }
}
