<x-app-layout>

    <x-slot name="title">
        Daftar Monitoring
    </x-slot>

    <x-alert-error></x-alert-error>

    @if(session()->has('success'))
        <x-alert
            type="success"
            message="{{ session()->get('success') }}" />
    @endif

    <x-card>

        <table class="table table-hover border">

            <thead>
                <tr>
                    <th>User</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Hasil Lab</th>
                    <th>File Hasil Lab</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($monitoring as $row)

                <tr>

                    <td>
                        {{ $row->user->name ?? '-' }}
                    </td>

                    <td>
                        <b>{{ $row->nama }}</b>
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
                        {{ Str::limit($row->keterangan,50) }}
                    </td>

                    <td>

                        <span class="badge badge-{{ $row->status == 'sembuh' ? 'success' : 'warning' }}">

                            {{ ucfirst($row->status) }}

                        </span>

                    </td>

                    <td>

                        <button
                            class="btn btn-primary btn-sm edit"
                            data-id="{{ $row->id }}">

                            <i class="fas fa-edit"></i>

                        </button>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8" class="text-center">
                        No Data
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

        <div class="mt-2">
            {{ $monitoring->links() }}
        </div>

    </x-card>


    {{-- MODAL EDIT STATUS MONITORING --}}

    <x-modal
        title="Edit Monitoring"
        id="edit-monitoring">

        <form
            action="{{ route('admin.monitoring.update') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <input
                type="hidden"
                name="id">

            <div class="form-group">

                <label>Nama Pasien</label>

                <input
                    type="text"
                    class="form-control"
                    name="nama"
                    readonly>

            </div>

            <div class="form-group">

                <label>Tanggal</label>

                <input
                    type="date"
                    class="form-control"
                    name="tanggal"
                    readonly>

            </div>

            <div class="form-group">

                <label>Hasil Lab</label>

                <input
                    type="text"
                    class="form-control"
                    name="hasil_lab"
                    readonly>

            </div>

            <div class="form-group">

                <label>Keterangan</label>

                <textarea
                    class="form-control"
                    name="keterangan"
                    rows="4"
                    readonly></textarea>

            </div>

            <div class="form-group">

                <label>Status Monitoring</label>

                <select
                    class="form-control"
                    name="status">

                    <option value="proses">
                        Proses
                    </option>

                    <option value="sembuh">
                        Sembuh
                    </option>

                </select>

            </div>

            <button
                type="submit"
                class="btn btn-primary">

                Update Status

            </button>

        </form>

    </x-modal>


    <x-slot name="script">

        <script>

            $('.edit').click(function(){

                const id = $(this).data('id')

                $.get(
                    `{{ route('admin.monitoring.json') }}?id=${id}`,
                    function(res){

                        $('#edit-monitoring input[name="id"]').val(res.id)
                        $('#edit-monitoring input[name="nama"]').val(res.nama)
                        $('#edit-monitoring input[name="tanggal"]').val(res.tanggal)
                        $('#edit-monitoring input[name="hasil_lab"]').val(res.hasil_lab)
                        $('#edit-monitoring textarea[name="keterangan"]').val(res.keterangan)
                        $('#edit-monitoring select[name="status"]').val(res.status)

                        $('#edit-monitoring').modal('show')

                    }
                )

            })

        </script>

    </x-slot>

</x-app-layout>