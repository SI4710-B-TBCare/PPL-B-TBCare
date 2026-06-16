<x-app-layout>
    <x-slot name="title">Log Prediksi Risiko TBC</x-slot>

    <section class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="title">Detail Log Aktivitas</x-slot>

                <p class="text-muted mb-3">
                    <i class="fas fa-info-circle mr-1"></i>
                    Daftar aktivitas prediksi risiko TBC oleh pengguna sistem.
                    Data medis dan hasil kuesioner tidak ditampilkan di sini.
                </p>

                <div class="table-responsive">
                    <table class="table table-hover border">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama User</th>
                                <th>Tingkat Risiko</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($predictions as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->user->name ?? '-' }}</td>
                                    <td>
                                        {{ $row->risk_level }}

                                        <b>
                                            (<span class="text-danger">
                                                {{ number_format($row->risk_percentage, 2) }}%
                                            </span>)
                                        </b>
                                    </td>
                                    <td>{{ $row->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada aktivitas prediksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $predictions->links() }}
                    </div>
                </div>

            </x-card>
        </div>
    </section>

</x-app-layout>
