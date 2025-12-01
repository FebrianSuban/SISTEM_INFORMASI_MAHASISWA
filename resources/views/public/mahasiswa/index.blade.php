@extends('layouts.public')

@section('title', 'Daftar Mahasiswa')

@section('content')

<!-- Search and Filter -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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
