<x-app-layout>
    <x-slot name="title">Log Prediksi TBC</x-slot>

    <section class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="title">Log Aktivitas Prediksi</x-slot>

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
                                <th>Email</th>
                                <th>Waktu Prediksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($predictions as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->user->name ?? '-' }}</td>
                                    <td>{{ $row->user->email ?? '-' }}</td>
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
