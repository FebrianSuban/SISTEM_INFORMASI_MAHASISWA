@extends('layouts.public')

@section('title', 'Detail ' . $mahasiswa->nama_lengkap)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Back Button and Print (aligned right) -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('home') }}" class="inline-flex items-center text-[#2b0b5a] hover:opacity-90">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Mahasiswa
            </a>
        </div>

        <div>
            <a href="{{ route('mahasiswa.print', $mahasiswa) }}?autoprint=1" target="_blank" class="inline-flex items-center px-3 py-2 bg-gray-200 text-gray-800 rounded-md hover:opacity-90">
                <i class="fas fa-print mr-2"></i> Print
            </a>
        </div>
    </div>

    <!-- Card Detail -->
    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-[#2b0b5a] px-8 py-6">
            <h1 class="text-3xl font-bold text-white">Detail Biodata Mahasiswa</h1>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Foto Section -->
                <div class="md:col-span-1">
                    <div class="sticky top-8">
                        @if($mahasiswa->foto)
                            <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="{{ $mahasiswa->nama_lengkap }}" class="w-full rounded-lg shadow-lg">
                        @else
                            <div class="w-full h-80 bg-[#2b0b5a] rounded-lg flex items-center justify-center shadow-lg">
                                <i class="fas fa-user text-white text-8xl"></i>
                            </div>
                        @endif

                        <div class="mt-4 bg-purple-50 rounded-lg p-4">
                            <p class="text-center text-sm text-gray-600">
                                <i class="fas fa-id-card mr-2 text-[#2b0b5a]"></i>
                                <span class="font-semibold text-[#2b0b5a]">{{ $mahasiswa->nim }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Data Section -->
                <div class="md:col-span-2">
                    <div class="space-y-6">
                        <!-- Informasi Pribadi -->
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-[#2b0b5a]">
                                <i class="fas fa-user mr-2 text-[#2b0b5a]"></i> Informasi Pribadi
                            </h2>
                            <div class="space-y-4">
                                <div class="flex">
                                    <div class="w-1/3 font-semibold text-gray-700">Nama Lengkap</div>
                                    <div class="w-2/3 text-gray-900">{{ $mahasiswa->nama_lengkap }}</div>
                                </div>
                                <div class="flex">
                                    <div class="w-1/3 font-semibold text-gray-700">Tempat Lahir</div>
                                    <div class="w-2/3 text-gray-900">{{ $mahasiswa->tempat_lahir }}</div>
                                </div>
                                <div class="flex">
                                    <div class="w-1/3 font-semibold text-gray-700">Tanggal Lahir</div>
                                    <div class="w-2/3 text-gray-900">{{ $mahasiswa->tanggal_lahir->format('d F Y') }}</div>
                                </div>
                                <div class="flex">
                                    <div class="w-1/3 font-semibold text-gray-700">Usia</div>
                                    <div class="w-2/3 text-gray-900">{{ $mahasiswa->tanggal_lahir->age }} tahun</div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Akademik -->
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-[#2b0b5a]">
                                <i class="fas fa-graduation-cap mr-2 text-[#2b0b5a]"></i> Informasi Akademik
                            </h2>
                            <div class="space-y-4">
                                <div class="flex">
                                    <div class="w-1/3 font-semibold text-gray-700">NIM</div>
                                    <div class="w-2/3 text-gray-900">{{ $mahasiswa->nim }}</div>
                                </div>
                                <div class="flex">
                                    <div class="w-1/3 font-semibold text-gray-700">Jurusan</div>
                                    <div class="w-2/3 text-gray-900">{{ $mahasiswa->jurusan }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Kontak -->
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-[#2b0b5a]">
                                <i class="fas fa-address-book mr-2 text-[#2b0b5a]"></i> Informasi Kontak
                            </h2>
                            <div class="space-y-4">
                                <div class="flex">
                                    <div class="w-1/3 font-semibold text-gray-700">Email</div>
                                    <div class="w-2/3 text-gray-900">
                                        <a href="mailto:{{ $mahasiswa->email }}" class="text-[#2b0b5a] hover:opacity-90">
                                            {{ $mahasiswa->email }}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="w-1/3 font-semibold text-gray-700">Nomor Telepon</div>
                                    <div class="w-2/3 text-gray-900">
                                        <a href="tel:{{ $mahasiswa->nomor_telepon }}" class="text-[#2b0b5a] hover:opacity-90">
                                            {{ $mahasiswa->nomor_telepon }}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="w-1/3 font-semibold text-gray-700">Alamat Tinggal</div>
                                    <div class="w-2/3 text-gray-900">{{ $mahasiswa->alamat_tinggal }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Tambahan -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-clock mr-2"></i>
                                Data terdaftar sejak: <span class="font-semibold">{{ $mahasiswa->created_at->format('d F Y') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
