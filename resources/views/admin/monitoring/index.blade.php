<x-app-layout>
	<x-slot name="title">Daftar Monitoring</x-slot>

	<x-alert-error></x-alert-error>

	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif

	<x-card>

		<x-slot name="option">
			<div class="btn btn-success add">
				<i class="fas fa-plus mr-1"></i>
				Tambahkan Monitoring
			</div>
		</x-slot>

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
					<th width="150">Aksi</th>
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

						<div class="d-flex">

    <button
        class="btn btn-primary btn-sm edit"
        data-id="{{ $row->id }}">

        <i class="fas fa-edit"></i>

    </button>

    <button
        type="button"
        class="btn btn-info btn-sm ml-1 perkembangan"
        data-id="{{ $row->id }}"
        data-nama="{{ $row->nama }}">

        <i class="fas fa-notes-medical"></i>

    </button>

    <form
        action="{{ route('admin.monitoring.destroy',$row->id) }}"
        method="POST">

        @csrf

        <button
            type="submit"
            class="btn btn-danger btn-sm ml-1 delete">

            <i class="fas fa-trash"></i>

        </button>

    </form>

</div>

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

	{{-- MODAL TAMBAH --}}

	<x-modal title="Tambahkan Monitoring" id="monitoring">

		<form
			action="{{ route('admin.monitoring.store') }}"
			method="POST"
			enctype="multipart/form-data">

			@csrf

			<div class="form-group">
				<label>Nama Pasien</label>
				<input
					type="text"
					class="form-control"
					name="nama"
					required>
			</div>

			<div class="form-group">
				<label>Tanggal</label>
				<input
					type="date"
					class="form-control"
					name="tanggal"
					required>
			</div>

			<div class="form-group">
				<label>Hasil Lab</label>
				<input
					type="text"
					class="form-control"
					name="hasil_lab"
					required>
			</div>

			<div class="form-group">
				<label>Upload Hasil Lab</label>
				<input
					type="file"
					class="form-control"
					name="file_hasil_lab"
					accept=".pdf,.jpg,.jpeg,.png">
			</div>

			<div class="form-group">
				<label>Keterangan</label>
				<textarea
					class="form-control"
					name="keterangan"></textarea>
			</div>

			<div class="form-group">
				<label>Status</label>

				<select
					class="form-control"
					name="status"
					required>

					<option value="">
						-- Pilih Status --
					</option>

					<option value="proses">
						Proses
					</option>

					<option value="sembuh">
						Sembuh
					</option>

				</select>

			</div>

			<button class="btn btn-primary">
				Simpan
			</button>

		</form>

	</x-modal>

	{{-- MODAL EDIT --}}

	<x-modal title="Edit Monitoring" id="edit-monitoring">

		<form
			action="{{ route('admin.monitoring.update') }}"
			method="POST"
			enctype="multipart/form-data">

			@csrf

			<input type="hidden" name="id">

			<div class="form-group">
				<label>Nama Pasien</label>
				<input
					type="text"
					class="form-control"
					name="nama">
			</div>

			<div class="form-group">
				<label>Tanggal</label>
				<input
					type="date"
					class="form-control"
					name="tanggal">
			</div>

			<div class="form-group">
				<label>Hasil Lab</label>
				<input
					type="text"
					class="form-control"
					name="hasil_lab">
			</div>

			<div class="form-group">
				<label>Upload Hasil Lab Baru</label>
				<input
					type="file"
					class="form-control"
					name="file_hasil_lab"
					accept=".pdf,.jpg,.jpeg,.png">
			</div>

			<div class="form-group">
				<label>Keterangan</label>
				<textarea
					class="form-control"
					name="keterangan"></textarea>
			</div>

			<div class="form-group">
				<label>Status</label>

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

			<button class="btn btn-primary">
				Update
			</button>

		</form>

	</x-modal>

	{{-- MODAL PERKEMBANGAN KESEHATAN --}}

<x-modal
    title="Catatan Perkembangan Kesehatan"
    id="perkembangan-monitoring">

    <form
        action="{{ route('admin.perkembangan.store') }}"
        method="POST">

        @csrf

        <input
            type="hidden"
            name="monitoring_id"
            id="monitoring_id">

        <div class="form-group">
            <label>Tanggal Catatan</label>

            <input
                type="date"
                class="form-control"
                name="tanggal"
                required>
        </div>

        <div class="form-group">
            <label>Catatan Perkembangan</label>

            <textarea
                class="form-control"
                name="catatan"
                rows="5"
                required></textarea>
        </div>

        <button
            type="submit"
            class="btn btn-success">

            Simpan Catatan

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

			title: 'Hapus data?',

			icon: 'warning',

			showCancelButton: true,

			confirmButtonColor: '#d33',

			confirmButtonText: 'Ya'

		}).then((result)=>{

			if(result.isConfirmed){

				$(this).parent().submit()

			}

		})

	})

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

	$('.perkembangan').click(function(){

    	const monitoring_id = $(this).data('id')

    	$('#monitoring_id').val(monitoring_id)

    	$('#perkembangan-monitoring')
        .modal('show')

	})			
			}
		)

	})

	</script>

	</x-slot>

</x-app-layout>