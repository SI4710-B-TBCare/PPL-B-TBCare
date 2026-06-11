<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>

    <section class="row">
        <x-card-sum
            text="Total User"
            value="{{ $totalUser }}"
            icon="users"
            color="success"
        />

        <x-card-sum
            text="Total Diagnosa"
            value="{{ App\Models\TbPrediction::count() }}"
            icon="stethoscope"
            color="primary"
        />

        <x-card-sum
            text="Daftar Fasilitas Kesehatan"
            value="{{ App\Models\FasilitasKesehatan::count() }}"
            icon="th-list"
            color="warning"
        />

        <x-card-sum
            text="Daftar Artikel"
            value="{{ App\Models\Artikel::count() }}"
            icon="th-list"
            color="danger"
        />
    </section>

    <section class="row">

        {{-- Log Activity --}}
        <div class="col-md-6">
            <x-card>
                <x-slot name="title">
                    Log Activity
                </x-slot>

                <x-slot name="option">
                    <a href="{{ route('admin.logs') }}" class="btn btn-primary btn-sm">
                        More
                    </a>
                </x-slot>

                <table class="table">
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->description }}</td>
                                <td>
                                    <small>{{ $log->created_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    No Data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-card>
        </div>

        {{-- Statistik Diagnosa --}}
        <div class="col-md-6">
            <div class="card mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Statistik Hasil Diagnosa
                    </h6>
                </div>

                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>

            </div>
        </div>

    </section>

    {{-- Sebaran Wilayah --}}
    <section class="row">

        <div class="col-md-6">
            <x-card>

                <x-slot name="title">
                    Sebaran Wilayah Pengguna
                </x-slot>

                <table class="table table-hover border">
                    <thead>
                        <tr>
                            <th>Provinsi</th>
                            <th>Jumlah Pengguna</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($sebaranWilayah as $data)
                            <tr>
                                <td>{{ $data->provinsi ?? '-' }}</td>
                                <td>
                                    <b>{{ $data->total }}</b>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    Belum ada data wilayah
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </x-card>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Grafik Sebaran Wilayah
                    </h6>
                </div>

                <div class="card-body">
                    <canvas id="sebaranChart"></canvas>
                </div>

            </div>
        </div>

    </section>

    {{-- Riwayat Diagnosa --}}
    <section class="row">

        <div class="col-12">

            <x-card>

                <x-slot name="title">
                    Riwayat Diagnosa Terbaru
                </x-slot>

                <div class="table-responsive">

                    <table class="table table-hover border">

                        <thead>
                            <tr>
                                <th>ID</th>

                                @role('Admin')
                                    <td>{{ $row->user->name ?? '-' }}</td>
                                @endrole

                                <th>Penyakit Terdiagnosa</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($riwayatList as $row)

                                <tr>
                                    <td>{{ $row->id }}</td>

                                    @role('Admin')
                                        <td>{{ $row->nama }}</td>
                                    @endrole

                                    <td>
                                        {{ $row->risk_level }}

                                        <b>
                                            (<span class="text-danger">
                                                {{ number_format($row->risk_percentage, 2) }}%
                                            </span>)
                                        </b>
                                    </td>

                                    <td>
                                        {{ $row->created_at->format('d M Y, H:i:s') }}
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="text-center">
                                        No Data
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </x-card>

        </div>

    </section>

    <x-slot name="script">

        <script>
            Chart.defaults.global.defaultFontFamily =
                'Nunito,-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';

            Chart.defaults.global.defaultFontColor = '#858796';

            function number_format(number, decimals, dec_point, thousands_sep) {

                number = (number + '').replace(',', '').replace(' ', '');

                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function(n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + Math.round(n * k) / k;
                    };

                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');

                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }

                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }

                return s.join(dec);
            }

            // Area Chart
            var ctx = document.getElementById("myAreaChart");

            new Chart(ctx, {
                type: 'line',

                data: {
                    labels: {!! json_encode($riwayat->pluck('days')->toArray()) !!},

                    datasets: [{
                        label: "Total Diagnosa",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78,115,223,0.2)",
                        borderColor: "rgba(78,115,223,1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78,115,223,1)",
                        pointBorderColor: "rgba(78,115,223,1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78,115,223,1)",
                        pointHoverBorderColor: "rgba(78,115,223,1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: {!! json_encode($riwayat->pluck('total')->toArray()) !!}
                    }]
                },

                options: {
                    maintainAspectRatio: false,

                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },

                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },

                            ticks: {
                                maxTicksLimit: 7
                            }
                        }],

                        yAxes: [{
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,

                                callback: function(value) {
                                    return number_format(value);
                                }
                            },

                            gridLines: {
                                color: "rgb(234,236,244)",
                                zeroLineColor: "rgb(234,236,244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }]
                    },

                    legend: {
                        display: false
                    },

                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,

                        callbacks: {
                            label: function(tooltipItem, chart) {

                                var datasetLabel =
                                    chart.datasets[tooltipItem.datasetIndex].label || '';

                                return datasetLabel + ': ' +
                                    number_format(tooltipItem.yLabel);
                            }
                        }
                    }
                }
            });

            // Sebaran Wilayah Chart
            var sebaranCtx = document.getElementById("sebaranChart");

            new Chart(sebaranCtx, {
                type: 'bar',

                data: {
                    labels: @json($sebaranWilayah->pluck('provinsi')),

                    datasets: [{
                        label: 'Jumlah Pengguna',
                        data: @json($sebaranWilayah->pluck('total')),
                        backgroundColor: 'rgba(78,115,223,0.5)',
                        borderColor: 'rgba(78,115,223,1)',
                        borderWidth: 1
                    }]
                },

                options: {
                    responsive: true,

                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                precision: 0
                            }
                        }]
                    },

                    legend: {
                        display: false
                    }
                }
            });
        </script>

    </x-slot>

</x-app-layout>