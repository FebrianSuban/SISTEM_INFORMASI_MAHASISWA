@extends('layouts.admin')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-extrabold text-[#2b0b5a]">Data Mahasiswa</h2>
        <a href="{{ route('admin.mahasiswa.create') }}" class="bg-[#2b0b5a] hover:opacity-95 text-white px-4 py-2 rounded-md text-sm font-medium inline-flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Mahasiswa
        </a>
    </div>

    <div class="bg-white rounded-lg card-soft-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#2b0b5a] uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#2b0b5a] uppercase tracking-wider">NIM</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#2b0b5a] uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#2b0b5a] uppercase tracking-wider">Jurusan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#2b0b5a] uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#2b0b5a] uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($mahasiswas as $mahasiswa)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($mahasiswa->foto)
                                <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="{{ $mahasiswa->nama_lengkap }}" class="h-12 w-12 rounded-full object-cover card-soft-shadow">
                            @else
                                <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center card-soft-shadow">
                                    <i class="fas fa-user text-gray-600"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $mahasiswa->nim }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $mahasiswa->nama_lengkap }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $mahasiswa->jurusan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $mahasiswa->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.mahasiswa.show', $mahasiswa) }}" class="text-[#2b0b5a] hover:text-[#6b2fb3] mr-3" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}" class="text-[#2b0b5a] hover:text-[#6b2fb3] mr-3" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data mahasiswa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $mahasiswas->links() }}
    </div>
</div>
@endsection
