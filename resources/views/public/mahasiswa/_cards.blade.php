@if($mahasiswas->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="mahasiswa-cards">
        @foreach($mahasiswas as $mahasiswa)
            <div class="bg-white rounded-xl card-soft-shadow overflow-hidden hover:shadow-2xl transition duration-300">
                <!-- Foto / Top panel -->
                <div class="h-40 sm:h-48 md:h-56 bg-[#2b0b5a] flex items-center justify-center overflow-hidden">
                        @if($mahasiswa->foto)
                            <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="{{ $mahasiswa->nama_lengkap }}" class="w-full h-full object-cover object-center" style="object-position: center 30%;">
                        @else
                            <i class="fas fa-user text-white text-5xl"></i>
                        @endif
                    </div>

                <!-- Content -->
                <div class="p-5 bg-white">
                    <div class="mb-3">
                        <span class="inline-block bg-purple-100 text-[#2b0b5a] text-xs px-3 py-1 rounded-full font-semibold">
                            {{ $mahasiswa->nim }}
                        </span>
                    </div>

                    <h3 class="text-lg font-semibold text-[#2b0b5a] mb-2">{{ $mahasiswa->nama_lengkap }}</h3>

                    <div class="space-y-2 mb-4 text-sm text-gray-600">
                        <p class="flex items-center">
                            <i class="fas fa-graduation-cap w-5 mr-2 text-[#2b0b5a]"></i>
                            <span>{{ $mahasiswa->jurusan }}</span>
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-envelope w-5 mr-2 text-[#2b0b5a]"></i>
                            <span class="truncate">{{ $mahasiswa->email }}</span>
                        </p>
                    </div>

                    <a href="{{ route('mahasiswa.show', $mahasiswa) }}" class="inline-flex items-center justify-center gap-2 w-full bg-[#2b0b5a] text-white py-2 rounded-full hover:opacity-95">
                        <i class="fas fa-eye"></i>
                        <span>Lihat Detail</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8" id="mahasiswa-pagination">
        {{ $mahasiswas->withQueryString()->links() }}
    </div>
@else
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
        <h3 class="text-2xl font-semibold text-gray-700 mb-2">Tidak Ada Data</h3>
        <p class="text-gray-500">
            @if(request('search'))
                Tidak ditemukan mahasiswa dengan kata kunci "{{ request('search') }}"
            @else
                Belum ada data mahasiswa yang terdaftar.
            @endif
        </p>
    </div>
@endif
