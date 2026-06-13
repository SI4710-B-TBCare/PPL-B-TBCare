<x-app-layout>

    <x-slot name="title">
        Jadwal Pemeriksaan
    </x-slot>

    <x-alert-error></x-alert-error>

    @if(session()->has('success'))
        <x-alert
            type="success"
            message="{{ session()->get('success') }}" />
    @endif

    <x-card>

        <x-slot name="option">

            <div class="btn btn-success add">
                <i class="fas fa-plus mr-1"></i>
                Tambah Jadwal
            </div>

        </x-slot>

        <table class="table table-hover border">

            <thead>

                <tr>
                    <th>Jenis Pemeriksaan</th>
                    <th>Tanggal Pemeriksaan</th>
                    <th>Lokasi</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th width="150">Aksi</th>
                </tr>

            </thead>

            <tbody>

            @forelse($jadwal as $row)

                <tr>

                    <td>
                        {{ $row->jenis_pemeriksaan }}
                    </td>

                    <td>
                        {{ $row->tanggal_pemeriksaan }}
                    </td>

                    <td>
                        {{ $row->lokasi }}
                    </td>

                    <td>
                        {{ Str::limit($row->catatan,50) }}
                    </td>

                    <td>

                        @if($row->status == 'terjadwal')

                            <span class="badge badge-warning">
                                Terjadwal
                            </span>

                        @elseif($row->status == 'selesai')

                            <span class="badge badge-success">
                                Selesai
                            </span>

                        @else

                            <span class="badge badge-danger">
                                Dibatalkan
                            </span>

                        @endif

                    </td>

                    <td>

                        <div class="d-flex">

                            <button
                                class="btn btn-primary btn-sm edit"
                                data-id="{{ $row->id }}"
                                data-jenis="{{ $row->jenis_pemeriksaan }}"
                                data-tanggal="{{ $row->tanggal_pemeriksaan }}"
                                data-lokasi="{{ $row->lokasi }}"
                                data-catatan="{{ $row->catatan }}"
                                data-status="{{ $row->status }}">

                                <i class="fas fa-edit"></i>

                            </button>

                            <form
                                action="{{ route('users.jadwal.destroy',$row->id) }}"
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

                    <td colspan="6" class="text-center">

                        Belum ada jadwal pemeriksaan

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

        <div class="mt-3">

            {{ $jadwal->links() }}

        </div>

    </x-card>

    {{-- MODAL TAMBAH --}}

    <x-modal
        title="Tambah Jadwal Pemeriksaan"
        id="jadwal">

        <form
            action="{{ route('users.jadwal.store') }}"
            method="POST">

            @csrf

            <div class="form-group">

                <label>Jenis Pemeriksaan</label>

                <select
                    class="form-control"
                    name="jenis_pemeriksaan"
                    required>

                    <option value="">
                        -- Pilih --
                    </option>

                    <option value="Tes Dahak">
                        Tes Dahak
                    </option>

                    <option value="Rontgen">
                        Rontgen
                    </option>

                    <option value="Kontrol Dokter">
                        Kontrol Dokter
                    </option>

                </select>

            </div>

            <div class="form-group">

                <label>Tanggal Pemeriksaan</label>

                <input
                    type="date"
                    name="tanggal_pemeriksaan"
                    class="form-control"
                    required>

            </div>

            <div class="form-group">

                <label>Lokasi Pemeriksaan</label>

                <input
                    type="text"
                    name="lokasi"
                    class="form-control"
                    required>

            </div>

            <div class="form-group">

                <label>Catatan</label>

                <textarea
                    name="catatan"
                    class="form-control"></textarea>

            </div>

            <button
                class="btn btn-primary">

                Simpan

            </button>

        </form>

    </x-modal>

    {{-- MODAL EDIT --}}

    <x-modal
        title="Edit Jadwal Pemeriksaan"
        id="edit-jadwal">

        <form
            action="{{ route('users.jadwal.update') }}"
            method="POST">

            @csrf

            <input
                type="hidden"
                name="id">

            <div class="form-group">

                <label>Jenis Pemeriksaan</label>

                <select
                    name="jenis_pemeriksaan"
                    class="form-control">

                    <option value="Tes Dahak">
                        Tes Dahak
                    </option>

                    <option value="Rontgen">
                        Rontgen
                    </option>

                    <option value="Kontrol Dokter">
                        Kontrol Dokter
                    </option>

                </select>

            </div>

            <div class="form-group">

                <label>Tanggal Pemeriksaan</label>

                <input
                    type="date"
                    name="tanggal_pemeriksaan"
                    class="form-control">

            </div>

            <div class="form-group">

                <label>Lokasi Pemeriksaan</label>

                <input
                    type="text"
                    name="lokasi"
                    class="form-control">

            </div>

            <div class="form-group">

                <label>Catatan</label>

                <textarea
                    name="catatan"
                    class="form-control"></textarea>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control">

                    <option value="terjadwal">
                        Terjadwal
                    </option>

                    <option value="selesai">
                        Selesai
                    </option>

                    <option value="dibatalkan">
                        Dibatalkan
                    </option>

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

                $('#jadwal').modal('show')

            })

            $('.delete').click(function(e){

                e.preventDefault()

                Swal.fire({

                    title: 'Hapus jadwal?',

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

                $('#edit-jadwal input[name="id"]')
                    .val($(this).data('id'))

                $('#edit-jadwal select[name="jenis_pemeriksaan"]')
                    .val($(this).data('jenis'))

                $('#edit-jadwal input[name="tanggal_pemeriksaan"]')
                    .val($(this).data('tanggal'))

                $('#edit-jadwal input[name="lokasi"]')
                    .val($(this).data('lokasi'))

                $('#edit-jadwal textarea[name="catatan"]')
                    .val($(this).data('catatan'))

                $('#edit-jadwal select[name="status"]')
                    .val($(this).data('status'))

                $('#edit-jadwal').modal('show')

            })

        </script>

    </x-slot>

</x-app-layout>