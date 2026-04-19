<x-app-layout>
	<x-slot name="title">Daftar Fasilitas Kesehatan</x-slot>
	<x-alert-error></x-alert-error>
	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif
	<x-card>
		<x-slot name="option">
			<div class="btn btn-success add">
				<i class="fas fa-plus mr-1"></i> Tambahkan Fasilitas Kesehatan
			</div>
		</x-slot>
		<table class="table table-hover border">
			<thead>
				<th>Kode</th>
				<th>Nama Fasilitas</th>
				<th>Penyebab</th>
				<th></th>
			</thead>
			<tbody>
				@forelse($fasilitasKesehatan as $row)
				<tr>
					<td><b>{{ $row->kode }}</b></td>
					<td>{{ $row->nama }}</td>
					<td>{{ $row->penyebab }}</td>
					<td>
						<div class="d-flex justify-between-space">
							<div>
								<button class="btn btn-primary btn-sm edit" data-id="{{ $row->id }}"><i class="fas fa-edit"></i></button>
							</div>
							<form action="{{ route('admin.fasilitasKesehatan.destroy', $row->id) }}" method="post">
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
	</x-card>

	<x-modal title="Tambahkan Fasilitas Kesehatan" id="fasilitasKesehatan">
		<form action="{{ route('admin.fasilitasKesehatan.store') }}" method="POST">
			@csrf
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="kode">Kode Fasilitas</label>
						<input type="text" class="form-control" name="kode">
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
						<label for="nama">Nama Fasilitas</label>
						<input type="text" class="form-control" name="nama">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="penyebab">Penyebab</label>
				<textarea class="form-control" name="penyebab" rows="3"></textarea>
			</div>
			<div class="mt-2">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
	</x-modal>

	<x-modal title="Edit Fasilitas Kesehatan" id="edit-fasilitasKesehatan">
		<form action="{{ route('admin.fasilitasKesehatan.update') }}" method="POST">
			@csrf
			<input type="hidden" name="id">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="kode">Kode Fasilitas</label>
						<input type="text" class="form-control" name="kode">
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
						<label for="nama">Nama Fasilitas</label>
						<input type="text" class="form-control" name="nama">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="penyebab">Penyebab</label>
				<textarea class="form-control" name="penyebab" rows="3"></textarea>
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
				$('#fasilitasKesehatan').modal('show')
			})

			$('.delete').click(function(e) {
				e.preventDefault()
				Swal.fire({
				  title: 'Hapus data fasilitas kesehatan?',
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

				$.get(`{{ route('admin.fasilitasKesehatan.json') }}?id=${id}`, function(res) {
					$('#edit-fasilitasKesehatan input[name="id"]').val(res.id)
					$('#edit-fasilitasKesehatan input[name="nama"]').val(res.nama)
					$('#edit-fasilitasKesehatan input[name="kode"]').val(res.kode)
					$('#edit-fasilitasKesehatan textarea[name="penyebab"]').val(res.penyebab)

					$('#edit-fasilitasKesehatan').modal('show')
				})
			})
		</script>
	</x-slot>
</x-app-layout>
