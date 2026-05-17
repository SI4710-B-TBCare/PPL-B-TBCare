<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artikel->nama }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .artikel-card {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .artikel-gambar {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
        }
        .artikel-body {
            padding: 30px;
        }
        .artikel-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2d3748;
        }
        .artikel-isi {
            font-size: 1rem;
            line-height: 1.8;
            color: #4a5568;
            white-space: pre-line;
        }
        .btn-kembali {
            margin: 0 30px 30px 30px;
        }
    </style>
</head>
<body>

    <div class="artikel-card">
        {{-- Gambar --}}
        @if($artikel->gambar)
            <img src="{{ Storage::url($artikel->gambar) }}"
                 alt="{{ $artikel->nama }}"
                 class="artikel-gambar">
        @endif

        <div class="artikel-body">
            {{-- Judul --}}
            <div class="artikel-title">{{ $artikel->nama }}</div>

            {{-- Isi --}}
            <div class="artikel-isi">
                {{ $artikel->isi ?? 'Belum ada isi artikel.' }}
            </div>
        </div>
    </div>

    <div class="text-center mb-4">
        <a href="{{ url('/panel/artikel') }}" class="btn btn-secondary">
            &larr; Kembali
        </a>
    </div>

</body>
</html>