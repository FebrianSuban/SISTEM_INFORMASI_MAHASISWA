@extends('layouts.admin')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-6">
        <a href="{{ route('admin.mahasiswa.index') }}" class="text-[#2b0b5a] hover:underline inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-lg card-soft-shadow overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-[#2b0b5a]">Detail Data Mahasiswa</h3>
            <div class="space-x-2">
                <a href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}" class="inline-flex items-center px-3 py-2 bg-[#2b0b5a] text-white rounded-md hover:opacity-95 text-sm">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('admin.mahasiswa.print', $mahasiswa) }}?autoprint=1" target="_blank" class="inline-flex items-center px-3 py-2 bg-gray-200 text-gray-800 rounded-md hover:opacity-95 text-sm">
                    <i class="fas fa-print mr-2"></i> Print
                </a>
                <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 text-sm">
                        <i class="fas fa-trash mr-2"></i> Hapus
                    </button>
                </form>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Foto -->
                <div class="md:col-span-1">
                    @if($mahasiswa->foto)
                        <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="{{ $mahasiswa->nama_lengkap }}" class="w-full rounded-lg card-soft-shadow object-cover">
                    @else
                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center card-soft-shadow">
                            <i class="fas fa-user text-gray-400 text-6xl"></i>
                        </div>
                    @endif
                </div>

                <!-- Data -->
                <div class="md:col-span-2">
                    <div class="space-y-4">
                        <div class="grid grid-cols-3 gap-2 pb-3 border-b border-gray-100">
                            <div class="font-semibold text-gray-700">NIM</div>
                            <div class="col-span-2 text-gray-900">{{ $mahasiswa->nim }}</div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 pb-3 border-b border-gray-100">
                            <div class="font-semibold text-gray-700">Nama Lengkap</div>
                            <div class="col-span-2 text-gray-900">{{ $mahasiswa->nama_lengkap }}</div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 pb-3 border-b border-gray-100">
                            <div class="font-semibold text-gray-700">Jurusan</div>
                            <div class="col-span-2 text-gray-900">{{ $mahasiswa->jurusan }}</div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 pb-3 border-b border-gray-100">
                            <div class="font-semibold text-gray-700">Tempat, Tanggal Lahir</div>
                            <div class="col-span-2 text-gray-900">{{ $mahasiswa->tempat_lahir }}, {{ $mahasiswa->tanggal_lahir->format('d F Y') }}</div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 pb-3 border-b border-gray-100">
                            <div class="font-semibold text-gray-700">Nomor Telepon</div>
                            <div class="col-span-2 text-gray-900">{{ $mahasiswa->nomor_telepon }}</div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 pb-3 border-b border-gray-100">
                            <div class="font-semibold text-gray-700">Email</div>
                            <div class="col-span-2 text-gray-900">{{ $mahasiswa->email }}</div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 pb-3 border-b border-gray-100">
                            <div class="font-semibold text-gray-700">Alamat Tinggal</div>
                            <div class="col-span-2 text-gray-900">{{ $mahasiswa->alamat_tinggal }}</div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 pb-3">
                            <div class="font-semibold text-gray-700">Terdaftar</div>
                            <div class="col-span-2 text-gray-900">{{ $mahasiswa->created_at->format('d F Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
