<x-user-app-layout>
    <x-slot name="title">Detail Artikel: {{ $artikel->nama }}</x-slot>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Detail Artikel</h6>
            <div>
                <a href="{{ route('users.artikel.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($artikel->gambar)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->nama }}" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                </div>
            @endif

            <div class="mb-3">
                <span class="badge badge-info">{{ $artikel->kategori ?? 'Tanpa Kategori' }}</span>
                <span class="badge badge-secondary">Kode: {{ $artikel->kode }}</span>
            </div>

            <h3 class="font-weight-bold mb-4">{{ $artikel->nama }}</h3>

            <div class="artikel-isi" style="font-size: 1rem; line-height: 1.8; color: #4a5568; white-space: pre-line;">
                {{ $artikel->isi ?? 'Belum ada isi artikel.' }}
            </div>
        </div>
    </div>
</x-user-app-layout>