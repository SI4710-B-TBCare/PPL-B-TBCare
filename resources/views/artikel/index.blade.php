<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Artikel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .artikel-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
            height: 100%;
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
        .card-body { padding: 16px; }
        .card-title { font-weight: 700; font-size: 1rem; }
        .card-text { font-size: 0.85rem; color: #6c757d; }
    </style>
</head>
<body>
    <div class="container py-5">
        <h3 class="mb-4 font-weight-bold">Daftar Artikel TBCare</h3>

        {{-- Search --}}
        <form method="GET" action="{{ route('artikel.public.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="search"
                       placeholder="Cari artikel..."
                       value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if($search)
                        <a href="{{ route('artikel.public.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Hasil --}}
        @if($artikel->isEmpty())
            <div class="alert alert-info">Tidak ada artikel yang ditemukan.</div>
        @else
            <div class="row">
                @foreach($artikel as $row)
                <div class="col-md-4 mb-4">
                    <div class="card artikel-card">
                        @if($row->gambar)
                            <img src="{{ Storage::url($row->gambar) }}" alt="{{ $row->nama }}">
                        @else
                            <div class="no-image">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $row->nama }}</h5>
                            <p class="card-text">
                                {{ Str::limit($row->isi, 80, '...') }}
                            </p>
                            <a href="{{ route('artikel.show', $row->id) }}"
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>