<x-app-layout>
	<x-slot name="title">Daftar Forum</x-slot>
	<x-alert-error></x-alert-error>
	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif
	<x-card>
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
						<div class="d-flex justify-between-space">
							<a href="{{ route('admin.forum.show', $row->id) }}" class="btn btn-info btn-sm mr-1"><i class="fas fa-eye"></i></a>
							<form action="{{ route('admin.forum.destroy', $row->id) }}" method="post">
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
			{{ $forums->links() }}
		</div>
	</x-card>
	<x-slot name="script">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
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
		</script>
	</x-slot>
</x-app-layout>
