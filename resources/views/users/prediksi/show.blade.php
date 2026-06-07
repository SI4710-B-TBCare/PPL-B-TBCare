<x-app-layout>
    <x-slot name="title">Hasil Prediksi TBC</x-slot>

    <section class="row">
        <div class="col-md-8 offset-md-2">

            @php
                if ($tbPrediction->risk_level === 'Tinggi') {
                    $alertClass = 'alert-danger';
                    $badgeClass = 'badge-danger';
                } elseif ($tbPrediction->risk_level === 'Sedang') {
                    $alertClass = 'alert-warning';
                    $badgeClass = 'badge-warning';
                } else {
                    $alertClass = 'alert-success';
                    $badgeClass = 'badge-success';
                }
            @endphp

            <div class="alert {{ $alertClass }} text-center">
                <h4 class="font-weight-bold">
                    Tingkat Risiko TBC:
                    <span class="badge {{ $badgeClass }} p-2 ml-2" style="font-size:1rem;">
                        {{ $tbPrediction->risk_level }}
                    </span>
                </h4>
                <h2 class="font-weight-bold mt-2">{{ $tbPrediction->risk_percentage }}%</h2>
                <small class="text-muted">
                    Diprediksi pada: {{ $tbPrediction->created_at->format('d M Y, H:i') }}
                </small>
            </div>

            <div class="card mt-3">
                <div class="card-body text-center">
                    {{-- Link menggunakan route name baru --}}
                    <a href="{{ route('users.prediksi.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-history mr-1"></i> Riwayat Saya
                    </a>
                    <a href="{{ route('users.chatbot.prediksi', $tbPrediction->id) }}" class="btn btn-success mr-2">
                        <i class="fas fa-robot mr-1"></i> Tanya AI tentang Hasil Ini
                    </a>
                    <a href="{{ route('users.prediksi.create') }}" class="btn btn-primary">
                        <i class="fas fa-redo mr-1"></i> Prediksi Ulang
                    </a>
                </div>
            </div>

        </div>
    </section>

</x-app-layout>
