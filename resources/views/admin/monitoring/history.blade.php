<x-app-layout>

    <x-slot name="title">
        Riwayat Monitoring
    </x-slot>

    <x-alert-error></x-alert-error>

    @if(session()->has('success'))
        <x-alert
            type="success"
            message="{{ session()->get('success') }}" />
    @endif

    @if(session()->has('error'))
        <x-alert
            type="danger"
            message="{{ session()->get('error') }}" />
    @endif

    <x-card>

        <x-slot name="option">

            <div class="btn btn-success add">
                <i class="fas fa-plus mr-1"></i>
                Tambah Monitoring
            </div>

        </x-slot>

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
                    <th width="150">Aksi</th>
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
                                href="{{ route('users.monitoring.download', $row->id) }}"
                                class="btn btn-info btn-sm">

                                <i class="fas fa-download mr-1"></i>Lihat File

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

                    <td>

                        <div class="d-flex">

                            <button
                                class="btn btn-primary btn-sm edit"
                                data-id="{{ $row->id }}"
                                data-nama="{{ $row->nama }}"
                                data-tanggal="{{ $row->tanggal }}"
                                data-hasil_lab="{{ $row->hasil_lab }}"
                                data-keterangan="{{ $row->keterangan }}"
                                data-status="{{ $row->status }}">

                                <i class="fas fa-edit"></i>

                            </button>

                            <form
                                action="{{ route('users.monitoring.destroy', $row->id) }}"
                                method="POST">

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm ml-1 delete">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8" class="text-center">

                        Belum Ada Riwayat Monitoring

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </x-card>

    {{-- MODAL TAMBAH --}}

    <x-modal
        title="Tambah Data Monitoring"
        id="monitoring">

        <form
            action="{{ route('users.monitoring.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="form-group">

                <label>Nama Pasien</label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    required>

            </div>

            <div class="form-group">

                <label>Tanggal</label>

                <input
                    type="date"
                    name="tanggal"
                    class="form-control"
                    required>

            </div>

            <div class="form-group">

                <label>Hasil Lab</label>

                <input
                    type="text"
                    name="hasil_lab"
                    class="form-control"
                    required>

            </div>

            <div class="form-group">

                <label>File Hasil Lab (opsional)</label>

                <input
                    type="file"
                    name="file_hasil_lab"
                    class="form-control"
                    accept=".pdf,.jpg,.jpeg,.png">

            </div>

            <div class="form-group">

                <label>Keterangan</label>

                <textarea
                    name="keterangan"
                    class="form-control"
                    rows="3"></textarea>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control"
                    required>

                    <option value="proses">Proses</option>

                    <option value="sembuh">Sembuh</option>

                </select>

            </div>

            <button
                class="btn btn-primary">

                Simpan

            </button>

        </form>

    </x-modal>

    {{-- MODAL EDIT --}}

    <x-modal
        title="Edit Data Monitoring"
        id="edit-monitoring">

        <form
            action="{{ route('users.monitoring.update') }}"
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
                    name="nama"
                    class="form-control"
                    required>

            </div>

            <div class="form-group">

                <label>Tanggal</label>

                <input
                    type="date"
                    name="tanggal"
                    class="form-control"
                    required>

            </div>

            <div class="form-group">

                <label>Hasil Lab</label>

                <input
                    type="text"
                    name="hasil_lab"
                    class="form-control"
                    required>

            </div>

            <div class="form-group">

                <label>Ganti File Hasil Lab (opsional)</label>

                <input
                    type="file"
                    name="file_hasil_lab"
                    class="form-control"
                    accept=".pdf,.jpg,.jpeg,.png">

            </div>

            <div class="form-group">

                <label>Keterangan</label>

                <textarea
                    name="keterangan"
                    class="form-control"
                    rows="3"></textarea>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control"
                    required>

                    <option value="proses">Proses</option>

                    <option value="sembuh">Sembuh</option>

                </select>

            </div>

            <button
                class="btn btn-primary">

                Update

            </button>

        </form>

    </x-modal>

    <x-slot name="script">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>

            $('.add').click(function(){

                $('#monitoring').modal('show')

            })

            $('.delete').click(function(e){

                e.preventDefault()

                Swal.fire({

                    title: 'Hapus data monitoring?',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonText: 'Ya'

                }).then((result)=>{

                    if(result.isConfirmed){

                        $(this).parent().submit()

                    }

                })

            })

            $('.edit').click(function(){

                $('#edit-monitoring input[name="id"]')
                    .val($(this).data('id'))

                $('#edit-monitoring input[name="nama"]')
                    .val($(this).data('nama'))

                $('#edit-monitoring input[name="tanggal"]')
                    .val($(this).data('tanggal'))

                $('#edit-monitoring input[name="hasil_lab"]')
                    .val($(this).data('hasil_lab'))

                $('#edit-monitoring textarea[name="keterangan"]')
                    .val($(this).data('keterangan'))

                $('#edit-monitoring select[name="status"]')
                    .val($(this).data('status'))

                $('#edit-monitoring').modal('show')

            })

        </script>

    </x-slot>

</x-app-layout>