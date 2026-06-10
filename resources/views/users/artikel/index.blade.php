<x-app-layout>
    <x-slot name="title">Daftar Artikel TBCare</x-slot>

    <style>
        .artikel-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
            height: 100%;
            background: #fff;
        }
        .artikel-card:hover { transform: translateY(-4px); }
        .artikel-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .artikel-card .no-image {
            width: 100%;
            height: 180px;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            font-size: 2rem;
        }
        .filter-btn {
            cursor: pointer;
            border-radius: 20px;
            padding: 5px 16px;
            font-size: 0.85rem;
            border: 1px solid #dee2e6;
            background: #fff;
            margin-right: 6px;
            margin-bottom: 8px;
            display: inline-block;
            text-decoration: none;
            color: #495057;
        }
        .filter-btn:hover, .filter-btn.active {
            background: #007bff;
            color: #fff;
            border-color: #007bff;
            text-decoration: none;
        }
    </style>

    <div class="container-fluid py-2">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Artikel TBCare</h1>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('users.artikel.index') }}" class="mb-3">
            <div class="input-group">
                <input type="hidden" name="kategori" value="{{ $kategori ?? '' }}">
                <input type="text" class="form-control" name="search"
                       placeholder="Cari artikel..."
                       value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if($search || $kategori)
                        <a href="{{ route('users.artikel.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Filter Kategori --}}
        <div class="mb-4">
            <a href="{{ route('users.artikel.index', ['search' => $search ?? '']) }}"
               class="filter-btn {{ !$kategori ? 'active' : '' }}">
                Semua
            </a>
            @foreach(['Pencegahan', 'Pengobatan', 'Gejala', 'Umum'] as $kat)
                <a href="{{ route('users.artikel.index', ['search' => $search ?? '', 'kategori' => $kat]) }}"
                   class="filter-btn {{ ($kategori ?? '') == $kat ? 'active' : '' }}">
                    {{ $kat }}
                </a>
            @endforeach
        </div>

        {{-- Hasil --}}
        @if($artikel->isEmpty())
            <div class="alert alert-info">Tidak ada artikel yang ditemukan.</div>
        @else
            <div class="row">
                @foreach($artikel as $row)
                <div class="col-md-4 mb-4">
                    <div class="card artikel-card">
                        @if($row->gambar)
                            <img src="{{ asset('storage/' . $row->gambar) }}" alt="{{ $row->nama }}">
                        @else
                            <div class="no-image">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            @if($row->kategori)
                                <span class="badge badge-info mb-1">{{ $row->kategori }}</span>
                            @endif
                            <h5 class="card-title">{{ $row->nama }}</h5>
                            <p class="card-text">
                                {{ Str::limit($row->isi, 80, '...') }}
                            </p>
                            <a href="{{ route('users.artikel.show', $row->id) }}"
                               class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $artikel->links() }}
            </div>
        @endif
    </div>
</x-app-layout>