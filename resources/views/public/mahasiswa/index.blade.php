@extends('layouts.public')

@section('title', 'Daftar Mahasiswa')

@section('content')

<!-- Search and Filter -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Jurusan & Total Summary Cards -->
    @php
        $c = $jurusanCounts ?? [
            'Sistem Informasi' => 0,
            'Teknik Informatika' => 0,
            'Administrasi Bisnis' => 0,
            'Akutansi' => 0,
        ];
        $t = $total ?? 0;
    @endphp

    <div class="mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Total card -->
            <div class="bg-gradient-to-r from-[#3b1464] to-[#2b0b5a] text-white rounded-xl shadow-md p-4 flex items-center gap-4 h-28">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 bg-white bg-opacity-10 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-lg"></i>
                    </div>
                </div>
                <div class="flex flex-col justify-center">
                    <div class="text-xs opacity-90">Total Mahasiswa</div>
                    <div class="text-xl font-bold">{{ $t }}</div>
                </div>
            </div>

            <!-- Individual jurusan cards -->
            <div class="bg-white rounded-xl shadow-md p-4 flex items-center gap-3 h-28">
                <div class="h-10 w-10 bg-[#f3e8ff] text-[#2b0b5a] rounded-full flex items-center justify-center">
                    <i class="fas fa-desktop"></i>
                </div>
                <div class="flex flex-col justify-center">
                    <div class="text-xs text-gray-500">Sistem Informasi</div>
                    <div class="font-semibold text-lg text-[#2b0b5a]">{{ $c['Sistem Informasi'] ?? 0 }}</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-4 flex items-center gap-3 h-28">
                <div class="h-10 w-10 bg-[#f0f5ff] text-[#2b0b5a] rounded-full flex items-center justify-center">
                    <i class="fas fa-code"></i>
                </div>
                <div class="flex flex-col justify-center">
                    <div class="text-xs text-gray-500">Teknik Informatika</div>
                    <div class="font-semibold text-lg text-[#2b0b5a]">{{ $c['Teknik Informatika'] ?? 0 }}</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-4 flex items-center gap-3 h-28">
                <div class="h-10 w-10 bg-[#fff7ed] text-[#2b0b5a] rounded-full flex items-center justify-center">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="flex flex-col justify-center">
                    <div class="text-xs text-gray-500">Administrasi Bisnis</div>
                    <div class="font-semibold text-lg text-[#2b0b5a]">{{ $c['Administrasi Bisnis'] ?? 0 }}</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-4 flex items-center gap-3 h-28">
                <div class="h-10 w-10 bg-[#fff1f2] text-[#2b0b5a] rounded-full flex items-center justify-center">
                    <i class="fas fa-calculator"></i>
                </div>
                <div class="flex flex-col justify-center">
                    <div class="text-xs text-gray-500">Akutansi</div>
                    <div class="font-semibold text-lg text-[#2b0b5a]">{{ $c['Akutansi'] ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards Grid (AJAX-updatable) -->
    <div id="mahasiswa-grid">
        @include('public.mahasiswa._cards')
    </div>

    @push('scripts')
        <script>
            (function(){
                const input = document.querySelector('input[name="search"]');
                const grid = document.getElementById('mahasiswa-grid');
                let timer = null;

                if (!input || !grid) return;

                function fetchResults(url){
                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(r => r.text())
                        .then(html => {
                            grid.innerHTML = html;
                        })
                        .catch(err => console.error(err));
                }

                function updateQuery(q){
                    const url = new URL(window.location.href);
                    if (q) url.searchParams.set('search', q); else url.searchParams.delete('search');
                    // update URL without reloading
                    window.history.replaceState({}, '', url);
                    // fetch partial
                    fetchResults(url.toString());
                }

                // debounce input
                input.addEventListener('input', function(e){
                    const q = e.target.value;
                    clearTimeout(timer);
                    timer = setTimeout(() => updateQuery(q), 300);
                });

                // delegate pagination clicks
                document.addEventListener('click', function(e){
                    const a = e.target.closest('#mahasiswa-pagination a');
                    if (a){
                        e.preventDefault();
                        const href = a.getAttribute('href');
                        if (href) fetchResults(href);
                    }
                });
            })();
        </script>
    @endpush
</div>
@endsection
