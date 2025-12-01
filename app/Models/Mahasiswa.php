<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'nama_lengkap',
        'jurusan',
        'tempat_lahir',
        'tanggal_lahir',
        'nomor_telepon',
        'email',
        'alamat_tinggal',
        'foto'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
}
