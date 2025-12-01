<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Biodata - {{ $mahasiswa->nama_lengkap }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Print specific styles */
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none !important; }
            .page { page-break-after: avoid; }
        }

        .card-soft-shadow { box-shadow: 0 18px 30px rgba(43,11,90,0.08); }
        .print-container { max-width: 820px; margin: 24px auto; }
    </style>
</head>
<body class="bg-white text-gray-900">
    <div class="print-container bg-white border rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <img src="/images/642.jpg" alt="logo" class="h-14 w-auto object-contain" onerror="this.style.display='none'">
                <div>
                    <h1 class="text-xl font-bold text-[#2b0b5a]">INSTITUT DIGITAL EKONOMI LPKIA</h1>
                    <div class="text-sm text-gray-600">Sistem Informasi Biodata Mahasiswa</div>
                </div>
            </div>

            <div class="no-print">
                <a href="#" onclick="window.print(); return false;" class="inline-flex items-center px-4 py-2 bg-[#2b0b5a] text-white rounded-md">Print</a>
                <a href="{{ route('admin.mahasiswa.show', $mahasiswa) }}" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md">Kembali</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <div class="bg-gray-100 p-4 rounded-lg flex items-center justify-center card-soft-shadow">
                    @if($mahasiswa->foto)
                        <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="{{ $mahasiswa->nama_lengkap }}" class="w-48 h-56 object-cover object-center" style="object-position: center 30%;">
                    @else
                        <div class="w-48 h-56 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-user text-gray-400 text-5xl"></i>
                        </div>
                    @endif
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white p-4 rounded-lg">
                    <h2 class="text-2xl font-semibold text-[#2b0b5a] mb-4">{{ $mahasiswa->nama_lengkap }}</h2>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <div class="font-semibold text-gray-700">NIM</div>
                            <div class="text-gray-900">{{ $mahasiswa->nim }}</div>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-700">Jurusan</div>
                            <div class="text-gray-900">{{ $mahasiswa->jurusan }}</div>
                        </div>

                        <div>
                            <div class="font-semibold text-gray-700">Tempat, Tanggal Lahir</div>
                            <div class="text-gray-900">{{ $mahasiswa->tempat_lahir }}, {{ $mahasiswa->tanggal_lahir->format('d F Y') }}</div>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-700">Nomor Telepon</div>
                            <div class="text-gray-900">{{ $mahasiswa->nomor_telepon }}</div>
                        </div>

                        <div class="col-span-2">
                            <div class="font-semibold text-gray-700">Email</div>
                            <div class="text-gray-900">{{ $mahasiswa->email }}</div>
                        </div>

                        <div class="col-span-2">
                            <div class="font-semibold text-gray-700">Alamat Tinggal</div>
                            <div class="text-gray-900">{{ $mahasiswa->alamat_tinggal }}</div>
                        </div>
                    </div>

                    <div class="mt-6 text-sm text-gray-600">
                        <div>Terdaftar: {{ $mahasiswa->created_at->format('d F Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 text-xs text-gray-500">
            <div>Dicetak pada: {{ now()->format('d F Y H:i') }}</div>
        </div>
    </div>

    <script>
        // Auto-trigger print dialog when opened in new tab (optional)
        if (window.self === window.top && location.search.indexOf('autoprint') !== -1) {
            window.print();
        }
    </script>
</body>
</html>
