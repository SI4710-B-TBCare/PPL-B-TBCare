<x-user-app-layout>
    <x-slot name="title">Riwayat Prediksi TBC Saya</x-slot>

    <section class="row">
        <div class="col-md-12">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <x-card>
                <x-slot name="title">Riwayat Prediksi</x-slot>
                <x-slot name="option">
                    <a href="{{ route('users.prediksi.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Prediksi Baru
                    </a>
                </x-slot>

                <div class="table-responsive">
                    <table class="table table-hover border">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Hasil Risiko</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($predictions as $row)
                                @php
                                    if ($row->risk_level === 'Tinggi') {
                                        $badgeClass = 'badge-danger';
                                    } elseif ($row->risk_level === 'Sedang') {
                                        $badgeClass = 'badge-warning';
                                    } else {
                                        $badgeClass = 'badge-success';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $badgeClass }}">{{ $row->risk_level }}</span>
                                        <small class="text-muted ml-1">{{ $row->risk_percentage }}%</small>
                                    </td>
                                    <td>
                                        {{-- Link menggunakan route name baru --}}
                                        <a href="{{ route('users.prediksi.show', $row->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        Belum ada riwayat prediksi.
                                        <a href="{{ route('users.prediksi.create') }}">Mulai prediksi sekarang.</a>
                                    </td>
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

</x-user-app-layout>
