<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaPublicController extends Controller
{
    public function index(Request $request)
    {
        // Basic validation and sanitization for search input
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $query = Mahasiswa::query();

        // Filter pencarian (safe: Eloquent uses parameter binding)
        if (!empty($validated['search'])) {
            // trim and limit length just in case (already validated)
            $search = trim(mb_substr($validated['search'], 0, 100));

            // Optionally escape wildcard characters if you want literal search
            // $search = str_replace(['%', '_'], ['\\%', '\\_'], $search);

            $query->where(function($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%");
            });
        }

        // paginate 6 per page so the front-end shows "Next" only when > 6
        $mahasiswas = $query->latest()->paginate(6);

        // counts per allowed jurusan and total overall
        $jurusanList = [
            'Sistem Informasi',
            'Teknik Informatika',
            'Administrasi Bisnis',
            'Akutansi',
        ];

        $jurusanCounts = [];
        foreach ($jurusanList as $j) {
            $jurusanCounts[$j] = Mahasiswa::where('jurusan', $j)->count();
        }

        $total = Mahasiswa::count();

        if ($request->ajax()) {
            return view('public.mahasiswa._cards', compact('mahasiswas'));
        }

        return view('public.mahasiswa.index', compact('mahasiswas', 'jurusanCounts', 'total'));
    }

    public function show(Mahasiswa $mahasiswa)
    {
        return view('public.mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Print-friendly public biodata view.
     */
    public function print(Mahasiswa $mahasiswa)
    {
        return view('public.mahasiswa.print', compact('mahasiswa'));
    }
}
