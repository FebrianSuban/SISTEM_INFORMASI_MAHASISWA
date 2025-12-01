@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <h2 class="text-3xl font-extrabold text-[#2b0b5a] mb-6">Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg card-soft-shadow overflow-hidden">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-gradient-to-br from-[#6b2fb3] to-[#2b0b5a] rounded-md p-3">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Mahasiswa</dt>
                            <dd class="text-3xl font-semibold text-gray-900">{{ $totalMahasiswa }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-3">
                <a href="{{ route('admin.mahasiswa.index') }}" class="text-sm text-[#2b0b5a] hover:underline">Lihat semua <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>

        <div class="bg-white rounded-lg card-soft-shadow overflow-hidden">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-gradient-to-br from-green-400 to-green-600 rounded-md p-3">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tambah Data</dt>
                            <dd class="text-lg font-semibold text-gray-900">Mahasiswa Baru</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-3">
                <a href="{{ route('admin.mahasiswa.create') }}" class="text-sm text-green-600 hover:underline">Tambah data <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>

        <div class="bg-white rounded-lg card-soft-shadow overflow-hidden">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-gradient-to-br from-indigo-500 to-[#6b2fb3] rounded-md p-3">
                        <i class="fas fa-globe text-white text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Website Public</dt>
                            <dd class="text-lg font-semibold text-gray-900">Akses Publik</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-3">
                <a href="{{ route('home') }}" target="_blank" class="text-sm text-[#2b0b5a] hover:underline">Buka website <i class="fas fa-external-link-alt ml-1"></i></a>
            </div>
        </div>
    </div>

    {{-- Recent mahasiswa table (shows last 8) --}}
    <div class="mt-8">
        @php
            $recentMahasiswas = \App\Models\Mahasiswa::latest()->take(8)->get();
        @endphp

        <div class="bg-white rounded-lg card-soft-shadow overflow-hidden">
            <div class="px-6 py-4 flex items-center justify-between border-b">
                <h3 class="text-lg font-semibold text-[#2b0b5a]">Mahasiswa Terbaru</h3>
                <a href="{{ route('admin.mahasiswa.index') }}" class="text-sm text-[#2b0b5a] hover:underline">Lihat semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#2b0b5a] uppercase tracking-wider">Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#2b0b5a] uppercase tracking-wider">NIM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#2b0b5a] uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#2b0b5a] uppercase tracking-wider">Jurusan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#2b0b5a] uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentMahasiswas as $mahasiswa)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($mahasiswa->foto)
                                    <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="{{ $mahasiswa->nama_lengkap }}" class="h-10 w-10 rounded-full object-cover card-soft-shadow">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center card-soft-shadow">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $mahasiswa->nim }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $mahasiswa->nama_lengkap }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mahasiswa->jurusan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.mahasiswa.show', $mahasiswa) }}" class="text-[#2b0b5a] hover:text-[#6b2fb3] mr-3" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}" class="text-[#2b0b5a] hover:text-[#6b2fb3] mr-3" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada mahasiswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 text-sm text-gray-600">Menampilkan sampai 8 mahasiswa terbaru.</div>
        </div>
    </div>
</div>
@endsection
