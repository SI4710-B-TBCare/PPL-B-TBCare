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

            <!-- Ringkasan Jawaban Kuesioner -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-list-check mr-1"></i> Ringkasan Jawaban Kuesioner</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($labels as $key => $label)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $label }}
                                @php
                                    $val = $tbPrediction->$key;
                                    $valLabel = '';
                                    if ($key === 'SP') {
                                        $valLabel = $sputum[$val] ?? $val;
                                    } else {
                                        $valLabel = $options[$val] ?? $val;
                                    }
                                @endphp
                                <span class="badge badge-secondary p-2">{{ $valLabel }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
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

            <!-- Rekomendasi Artikel -->
            @if(isset($topArticles) && $topArticles->count() > 0)
            <div class="card mt-4 mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-book-open mr-1"></i> Rekomendasi Artikel Untuk Anda</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($topArticles as $artikel)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    @if($artikel->gambar)
                                        <img src="{{ asset('storage/' . $artikel->gambar) }}" class="card-img-top" alt="{{ $artikel->nama }}" style="height: 150px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <i class="fas fa-image text-muted fa-3x"></i>
                                        </div>
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title font-weight-bold">{{ $artikel->nama }}</h6>
                                        <p class="card-text small text-muted text-truncate" style="max-height: 40px; overflow: hidden;">
                                            {{ Str::limit(strip_tags($artikel->isi), 80) }}
                                        </p>
                                        <div class="mt-auto text-right">
                                            <a href="{{ route('users.artikel.show', $artikel->id) }}" class="btn btn-sm btn-outline-primary">Baca Artikel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if(isset($moreArticles) && $moreArticles->count() > 0)
                    <div class="text-center mt-3">
                        <button class="btn btn-outline-success" type="button" data-toggle="collapse" data-target="#moreArticlesCollapse" aria-expanded="false" aria-controls="moreArticlesCollapse">
                            Lihat Selengkapnya <i class="fas fa-chevron-down ml-1"></i>
                        </button>
                    </div>
                    
                    <div class="collapse mt-4" id="moreArticlesCollapse">
                        <div class="row">
                            @foreach($moreArticles as $artikel)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        @if($artikel->gambar)
                                            <img src="{{ asset('storage/' . $artikel->gambar) }}" class="card-img-top" alt="{{ $artikel->nama }}" style="height: 150px; object-fit: cover;">
                                        @else
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                                <i class="fas fa-image text-muted fa-3x"></i>
                                            </div>
                                        @endif
                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title font-weight-bold">{{ $artikel->nama }}</h6>
                                            <p class="card-text small text-muted text-truncate" style="max-height: 40px; overflow: hidden;">
                                                {{ Str::limit(strip_tags($artikel->isi), 80) }}
                                            </p>
                                            <div class="mt-auto text-right">
                                                <a href="{{ route('users.artikel.show', $artikel->id) }}" class="btn btn-sm btn-outline-primary">Baca Artikel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

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
