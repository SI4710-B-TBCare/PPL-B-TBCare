<x-app-layout>

    <x-slot name="title">
        Riwayat Monitoring
    </x-slot>

    <x-card>

        <table class="table table-bordered table-hover">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Hasil Lab</th>
                    <th>File Hasil Lab</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody>

                @forelse($monitoring as $key => $row)

                <tr>

                    <td>
                        {{ $key + 1 }}
                    </td>

                    <td>
                        {{ $row->nama }}
                    </td>

                    <td>
                        {{ $row->tanggal }}
                    </td>

                    <td>
                        {{ $row->hasil_lab }}
                    </td>

                    <td>

                        @if($row->file_hasil_lab)

                            <a
                                href="{{ asset('storage/'.$row->file_hasil_lab) }}"
                                target="_blank"
                                class="btn btn-info btn-sm">

                                Lihat File

                            </a>

                        @else

                            -

                        @endif

                    </td>

                    <td>
                        {{ $row->keterangan }}
                    </td>

                    <td>

                        <span
                            class="badge badge-{{ $row->status == 'sembuh' ? 'success' : 'warning' }}">

                            {{ ucfirst($row->status) }}

                        </span>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7" class="text-center">

                        Belum Ada Riwayat Monitoring

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </x-card>

</x-app-layout>