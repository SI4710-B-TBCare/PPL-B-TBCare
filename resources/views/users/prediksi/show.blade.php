<x-user-app-layout>
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
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-robot mr-1"></i> Rekomendasi AI TBCare</h5>
                </div>
                <div class="card-body">
                    <div id="ai-recommendation-container">
                        <div id="ai-loading" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted">AI sedang menyusun rekomendasi untuk Anda...</p>
                        </div>
                        <div id="ai-content" class="text-justify" style="display: none;"></div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body text-center">
                    {{-- Link menggunakan route name baru --}}
                    <a href="{{ route('users.prediksi.index') }}" class="btn btn-secondary mr-2 mb-2">
                        <i class="fas fa-history mr-1"></i> Riwayat Saya
                    </a>
                    <a href="{{ route('users.chatbot.prediksi', $tbPrediction->id) }}" class="btn btn-success mr-2 mb-2">
                        <i class="fas fa-comments mr-1"></i> Tanya Lebih Lanjut di Chatbot
                    </a>
                    <a href="{{ route('users.prediksi.create') }}" class="btn btn-primary mb-2">
                        <i class="fas fa-redo mr-1"></i> Prediksi Ulang
                    </a>
                </div>
            </div>

        </div>
    </section>

    <x-slot name="script">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const predictionId = {{ $tbPrediction->id }};
            const aiContent = document.getElementById('ai-content');
            const aiLoading = document.getElementById('ai-loading');

            fetch(`/users/prediksi/${predictionId}/auto-recommendation`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal memuat rekomendasi');
                }
                return response.json();
            })
            .then(data => {
                if (data.reply) {
                    aiContent.innerHTML = marked.parse(data.reply);
                } else if (data.error) {
                    aiContent.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                }
            })
            .catch(error => {
                aiContent.innerHTML = `<div class="alert alert-warning">Maaf, saat ini sistem AI kami sedang sibuk memproses permintaan. Kami menyarankan Anda untuk berkonsultasi langsung dengan tenaga medis berdasarkan hasil prediksi Anda.</div>`;
            })
            .finally(() => {
                aiLoading.style.display = 'none';
                aiContent.style.display = 'block';
            });
        });
    </script>
    </x-slot>

</x-app-layout>
