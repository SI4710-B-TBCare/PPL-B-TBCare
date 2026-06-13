<x-app-layout>

    <x-slot name="title">
        Perkembangan Kesehatan
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
                Tambah Catatan
            </div>

        </x-slot>

        <div class="mb-3">
            <p><strong>Monitoring:</strong> {{ $monitoring->nama }} — {{ $monitoring->tanggal }}</p>
        </div>

        <table class="table table-hover border">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Catatan</th>
                    <th width="150">Aksi</th>
                </tr>

            </thead>

            <tbody>

            @forelse($perkembangan as $key => $row)

                <tr>

                    <td>
                        {{ $key + 1 }}
                    </td>

                    <td>
                        {{ $row->tanggal }}
                    </td>

                    <td>
                        {{ Str::limit($row->catatan, 80) }}
                    </td>

                    <td>

                        <div class="d-flex">

                            <button
                                class="btn btn-primary btn-sm edit"
                                data-id="{{ $row->id }}"
                                data-tanggal="{{ $row->tanggal }}"
                                data-catatan="{{ $row->catatan }}">

                                <i class="fas fa-edit"></i>

                            </button>

                            <form
                                action="{{ route('users.perkembangan.destroy', $row->id) }}"
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

                    <td colspan="4" class="text-center">

                        Belum ada catatan perkembangan kesehatan

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </x-card>

    {{-- MODAL TAMBAH --}}

    <x-modal
        title="Tambah Catatan Perkembangan"
        id="perkembangan">

        <form
            action="{{ route('users.perkembangan.store') }}"
            method="POST">

            @csrf

            <input
                type="hidden"
                name="monitoring_id"
                value="{{ $monitoring->id }}">

            <div class="form-group">

                <label>Tanggal</label>

                <input
                    type="date"
                    name="tanggal"
                    class="form-control"
                    required>

            </div>

            <div class="form-group">

                <label>Catatan Perkembangan</label>

                <textarea
                    name="catatan"
                    class="form-control"
                    rows="4"
                    required></textarea>

            </div>

            <button
                class="btn btn-primary">

                Simpan

            </button>

        </form>

    </x-modal>

    {{-- MODAL EDIT --}}

    <x-modal
        title="Edit Catatan Perkembangan"
        id="edit-perkembangan">

        <form
            action="{{ route('users.perkembangan.update') }}"
            method="POST">

            @csrf

            <input
                type="hidden"
                name="id">

            <div class="form-group">

                <label>Tanggal</label>

                <input
                    type="date"
                    name="tanggal"
                    class="form-control">

            </div>

            <div class="form-group">

                <label>Catatan Perkembangan</label>

                <textarea
                    name="catatan"
                    class="form-control"
                    rows="4"></textarea>

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

                $('#perkembangan').modal('show')

            })

            $('.delete').click(function(e){

                e.preventDefault()

                Swal.fire({

                    title: 'Hapus catatan?',

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

                $('#edit-perkembangan input[name="id"]')
                    .val($(this).data('id'))

                $('#edit-perkembangan input[name="tanggal"]')
                    .val($(this).data('tanggal'))

                $('#edit-perkembangan textarea[name="catatan"]')
                    .val($(this).data('catatan'))

                $('#edit-perkembangan').modal('show')

            })

        </script>

    </x-slot>

</x-app-layout>
