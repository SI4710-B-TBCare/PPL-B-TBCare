<x-app-layout>
	<x-slot name="title">Daftar Forum</x-slot>
	<x-alert-error></x-alert-error>
	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif
	<x-card>
		<x-slot name="option">
			<div class="btn btn-success add">
				<i class="fas fa-plus mr-1"></i> Tambahkan Forum
			</div>
		</x-slot>
		<table class="table table-hover border">
			<thead>
				<th>Author</th>
				<th>Judul</th>
				<th>Konten</th>
				<th></th>
			</thead>
			<tbody>
				@forelse($forums as $row)
				<tr>
					<td>{{ $row->user ? $row->user->name : '-' }}</td>
					<td><b>{{ $row->judul }}</b></td>
					<td>{{ Str::limit($row->konten, 50) }}</td>
					<td>
						<div class="d-flex">
							<a href="{{ route('users.forum.show', $row->id) }}" class="btn btn-info btn-sm mr-1"><i class="fas fa-eye"></i></a>
							@if($row->user_id == auth()->id())
							<button class="btn btn-primary btn-sm edit" data-id="{{ $row->id }}"><i class="fas fa-edit"></i></button>
							<form action="{{ route('users.forum.destroy', $row->id) }}" method="post" class="ml-1">
								@csrf
								<button type="submit" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button>
							</form>
							@endif
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
			{{ $forums->links() }}
		</div>
	</x-card>

	<x-modal title="Tambahkan Forum" id="forum">
		<form action="{{ route('users.forum.store') }}" method="POST">
			@csrf
			<div class="form-group">
				<label for="judul">Judul</label>
				<input type="text" class="form-control" name="judul">
			</div>
			<div class="form-group">
				<label for="konten">Konten</label>
				<textarea class="form-control" name="konten" rows="4"></textarea>
			</div>
			<div class="mt-2">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
	</x-modal>

	<x-modal title="Edit Forum" id="edit-forum">
		<form action="{{ route('users.forum.update') }}" method="POST">
			@csrf
			<input type="hidden" name="id">
			<div class="form-group">
				<label for="judul">Judul</label>
				<input type="text" class="form-control" name="judul">
			</div>
			<div class="form-group">
				<label for="konten">Konten</label>
				<textarea class="form-control" name="konten" rows="4"></textarea>
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
				$('#forum').modal('show')
			})

			$('.delete').click(function(e) {
				e.preventDefault()
				Swal.fire({
				  title: 'Hapus forum?',
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

				$.get(`{{ route('users.forum.json') }}?id=${id}`, function(res) {
					$('#edit-forum input[name="id"]').val(res.id)
					$('#edit-forum input[name="judul"]').val(res.judul)
					$('#edit-forum textarea[name="konten"]').val(res.konten)

					$('#edit-forum').modal('show')
				})
			})
		</script>
	</x-slot>
</x-app-layout>
