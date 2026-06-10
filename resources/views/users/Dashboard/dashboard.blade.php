<x-user-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    {{-- PBI #23 - Search Bar --}}
    <section class="row mb-4">
        <div class="col-12">
            <form action="{{ route('user.dashboard') }}" method="GET">
                <div class="input-group">
                    <input
                        type="text"
                        name="search"
                        class="form-control bg-light border-0 small"
                        placeholder="Cari artikel atau riwayat prediksi..."
                        value="{{ $search ?? '' }}"
                    >
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i> Cari
                        </button>
                    </div>
                    @if($search)
                    <div class="input-group-append">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </section>

    @if($search)
    <section class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info">
                Hasil pencarian untuk: <strong>{{ $search }}</strong>
            </div>
        </div>
    </section>
    @endif

    {{-- PBI #1 - Grafik Perkembangan TBC --}}
    @if(!$search)
    <section class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Perkembangan TBC Saya</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="grafikTBC"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- PBI #2 - Timeline Artikel Terbaru --}}
    <section class="row">
        <div class="col-md-6">
            <x-card>
                <x-slot name="title">Artikel Terbaru</x-slot>
                <ul class="list-group list-group-flush">
                    @forelse($artikels as $artikel)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $artikel->nama }}</span>
                            <span class="badge badge-primary">{{ $artikel->kode }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">
                            {{ $search ? 'Tidak ada artikel dengan kata kunci "'.$search.'"' : 'Belum ada artikel' }}
                        </li>
                    @endforelse
                </ul>
            </x-card>
        </div>

        {{-- PBI #3 - Riwayat Kuesioner --}}
        <div class="col-md-6">
            <x-card>
                <x-slot name="title">Riwayat Prediksi TBC Saya</x-slot>
                <table class="table table-hover border">
                    <thead>
                        <tr>
                            <th>Hasil Diagnosa</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                       @forelse($riwayatList as $row)
    <tr>
        <td>
            {{ $row->risk_level }}
            <b>
                (<span class="text-danger">
                    {{ number_format($row->risk_percentage, 2) }}%
                </span>)
            </b>
        </td>
        <td>{{ $row->created_at->format('d M Y') }}</td>
    </tr>
@empty
    <tr>
        <td colspan="2" class="text-center text-muted">
            {{ $search ? 'Tidak ada riwayat dengan kata kunci "'.$search.'"' : 'Belum ada riwayat prediksi' }}
        </td>
    </tr>
@endforelse
                    </tbody>
                </table>
            </x-card>
        </div>
    </section>

    <x-slot name="script">
        <script>
            @if(!$search)
            var ctx = document.getElementById("grafikTBC");
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($grafik->pluck('tanggal')),
                    datasets: [{
                        label: "Total Diagnosa",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.5)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: @json($grafik->pluck('total')),
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: { padding: { left: 10, right: 25, top: 25, bottom: 0 } },
                    scales: {
                        xAxes: [{ gridLines: { display: false, drawBorder: false }, ticks: { maxTicksLimit: 7 } }],
                        yAxes: [{ ticks: { beginAtZero: true, precision: 0, maxTicksLimit: 5, padding: 10 }, gridLines: { color: "rgb(234, 236, 244)", zeroLineColor: "rgb(234, 236, 244)", drawBorder: false, borderDash: [2] } }],
                    },
                    legend: { display: false },
                }
            });
            @endif
        </script>
    </x-slot>
</x-user-app-layout>