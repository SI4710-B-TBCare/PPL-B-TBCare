<x-app-layout>
	<x-slot name="title">Daftar Monitoring</x-slot>
	<x-alert-error></x-alert-error>
	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif
	<x-card>
		<x-slot name="option">
			<div class="btn btn-success add">
				<i class="fas fa-plus mr-1"></i> Tambahkan Monitoring
			</div>
		</x-slot>
		<table class="table table-hover border">
			<thead>
				<th>Nama</th>
				<th>Keterangan</th>
				<th>Status</th>
				<th></th>
			</thead>
			<tbody>
				@forelse($monitoring as $row)
				<tr>
					<td><b>{{ $row->nama }}</b></td>
					<td>{{ Str::limit($row->keterangan, 50) }}</td>
					<td><span class="badge badge-{{ $row->status == 'aktif' ? 'success' : 'danger' }}">{{ $row->status }}</span></td>
					<td>
						<div class="d-flex justify-between-space">
							<div>
								<button class="btn btn-primary btn-sm edit" data-id="{{ $row->id }}"><i class="fas fa-edit"></i></button>
							</div>
							<form action="{{ route('admin.monitoring.destroy', $row->id) }}" method="post">
								@csrf
								<button type="submit" class="btn btn-danger btn-sm ml-1 delete"><i class="fas fa-trash"></i></button>
							</form>
						</div>
					</td>
				</tr>
				@empty
				<tr>
					<td colspan="4" class="text-center">No Data</td>
				</tr>
				@endforelse
			</tbody>
		</table>
		<div class="mt-2">
			{{ $monitoring->links() }}
		</div>
	</x-card>

	<x-modal title="Tambahkan Monitoring" id="monitoring">
		<form action="{{ route('admin.monitoring.store') }}" method="POST">
			@csrf
			<div class="form-group">
				<label for="nama">Nama</label>
				<input type="text" class="form-control" name="nama">
			</div>
			<div class="form-group">
				<label for="keterangan">Keterangan</label>
				<textarea class="form-control" name="keterangan" rows="3"></textarea>
			</div>
			<div class="form-group">
				<label for="status">Status</label>
				<select class="form-control" name="status">
					<option value="">-- Pilih Status --</option>
					<option value="aktif">Aktif</option>
					<option value="nonaktif">Nonaktif</option>
				</select>
			</div>
			<div class="mt-2">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
	</x-modal>

	<x-modal title="Edit Monitoring" id="edit-monitoring">
		<form action="{{ route('admin.monitoring.update') }}" method="POST">
			@csrf
			<input type="hidden" name="id">
			<div class="form-group">
				<label for="nama">Nama</label>
				<input type="text" class="form-control" name="nama">
			</div>
			<div class="form-group">
				<label for="keterangan">Keterangan</label>
				<textarea class="form-control" name="keterangan" rows="3"></textarea>
			</div>
			<div class="form-group">
				<label for="status">Status</label>
				<select class="form-control" name="status">
					<option value="">-- Pilih Status --</option>
					<option value="aktif">Aktif</option>
					<option value="nonaktif">Nonaktif</option>
				</select>
			</div>
			<div class="mt-2">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
	</x-modal>

	<x-slot name="script">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			$('.add').click(function() {
				$('#monitoring').modal('show')
			})

			$('.delete').click(function(e) {
				e.preventDefault()
				Swal.fire({
				  title: 'Hapus data monitoring?',
				  text: "Kamu tidak akan bisa mengembalikannya kembali!",
				  icon: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#d33',
				  cancelButtonColor: '#3085d6',
				  cancelButtonText: 'Batal',
				  confirmButtonText: 'Ya, hapus!'
				}).then((result) => {
				  if (result.isConfirmed) {
				    $(this).parent().submit()
				  }
				})
			})

			$('.edit').click(function() {
				const id = $(this).data('id')

				$.get(`{{ route('admin.monitoring.json') }}?id=${id}`, function(res) {
					$('#edit-monitoring input[name="id"]').val(res.id)
					$('#edit-monitoring input[name="nama"]').val(res.nama)
					$('#edit-monitoring textarea[name="keterangan"]').val(res.keterangan)
					$('#edit-monitoring select[name="status"]').val(res.status)

					$('#edit-monitoring').modal('show')
				})
			})
		</script>
	</x-slot>
</x-app-layout>
