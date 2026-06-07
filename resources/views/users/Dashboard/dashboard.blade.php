<x-user-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>

    {{-- PBI #1 - Grafik Perkembangan TBC --}}
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

    {{-- PBI #2 - Timeline Artikel Terbaru --}}
    <section class="row">
        <div class="col-md-6">
            <x-card>
                <x-slot name="title">
                    Artikel Terbaru
                </x-slot>
                <ul class="list-group list-group-flush">
                    @forelse($artikels as $artikel)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $artikel->nama }}</span>
                            <span class="badge badge-primary">{{ $artikel->kode }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">Belum ada artikel</li>
                    @endforelse
                </ul>
            </x-card>
        </div>

        {{-- PBI #3 - Riwayat Kuesioner --}}
        <div class="col-md-6">
            <x-card>
                <x-slot name="title">
                    Riwayat Prediksi TBC Saya
                </x-slot>
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
                                    {{ unserialize($row->cf_max)[1] }}
                                    <b>
                                        (<span class="text-danger">
                                            {{ number_format(unserialize($row->cf_max)[0] * 100, 2) }}%
                                        </span>)
                                    </b>
                                </td>
                                <td>{{ $row->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Belum ada riwayat prediksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-card>
        </div>
    </section>

    <x-slot name="script">
        <script>
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
        </script>
    </x-slot>
</x-user-app-layout>