<x-app-layout>
	<x-slot name="title">Daftar Feedback</x-slot>
	<x-alert-error></x-alert-error>
	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif
	<x-card>
		<x-slot name="option">
			<div class="btn btn-success add">
				<i class="fas fa-plus mr-1"></i> Tambahkan Feedback
			</div>
		</x-slot>
		<table class="table table-hover border">
			<thead>
				<th>Nama</th>
				<th>Email</th>
				<th>Pesan</th>
				<th></th>
			</thead>
			<tbody>
				@forelse($feedback as $row)
				<tr>
					<td><b>{{ $row->nama }}</b></td>
					<td>{{ $row->email }}</td>
					<td>{{ Str::limit($row->pesan, 50) }}</td>
					<td>
						<div class="d-flex justify-between-space">
							<div>
								<button class="btn btn-primary btn-sm edit" data-id="{{ $row->id }}"><i class="fas fa-edit"></i></button>
							</div>
							<form action="{{ route('user.feedback.destroy', $row->id) }}" method="post">
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
			{{ $feedback->links() }}
		</div>
	</x-card>

	<x-modal title="Tambahkan Feedback" id="feedback">
		<form action="{{ route('user.feedback.store') }}" method="POST">
			@csrf
			<div class="form-group">
				<label for="nama">Nama</label>
				<input type="text" class="form-control" name="nama">
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" name="email">
			</div>
			<div class="form-group">
				<label for="pesan">Pesan</label>
				<textarea class="form-control" name="pesan" rows="4"></textarea>
			</div>
			<div class="mt-2">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
	</x-modal>

	<x-modal title="Edit Feedback" id="edit-feedback">
		<form action="{{ route('user.feedback.update') }}" method="POST">
			@csrf
			<input type="hidden" name="id">
			<div class="form-group">
				<label for="nama">Nama</label>
				<input type="text" class="form-control" name="nama">
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" name="email">
			</div>
			<div class="form-group">
				<label for="pesan">Pesan</label>
				<textarea class="form-control" name="pesan" rows="4"></textarea>
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
				$('#feedback').modal('show')
			})

			$('.delete').click(function(e) {
				e.preventDefault()
				Swal.fire({
				  title: 'Hapus feedback?',
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

				$.get(`{{ route('user.feedback.json') }}?id=${id}`, function(res) {
					$('#edit-feedback input[name="id"]').val(res.id)
					$('#edit-feedback input[name="nama"]').val(res.nama)
					$('#edit-feedback input[name="email"]').val(res.email)
					$('#edit-feedback textarea[name="pesan"]').val(res.pesan)

					$('#edit-feedback').modal('show')
				})
			})
		</script>
	</x-slot>
</x-app-layout>
