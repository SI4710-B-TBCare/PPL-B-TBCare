<x-app-layout>
	<x-slot name="title">Detail Forum</x-slot>
	<x-alert-error></x-alert-error>
	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif

	<div class="card mb-4">
		<div class="card-header d-flex flex-row align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">{{ $forum->judul }}</h6>
		</div>
		<div class="card-body">
			<div class="mb-3 text-muted small">
				Diposting oleh: <strong>{{ $forum->user ? $forum->user->name : '-' }}</strong> pada {{ $forum->created_at->format('d M Y H:i') }}
			</div>
			<p>{!! nl2br(e($forum->konten)) !!}</p>
		</div>
	</div>

	<h5 class="mb-3">Komentar</h5>
	
	@forelse($forum->comments as $comment)
	<div class="card mb-3">
		<div class="card-body">
			<div class="d-flex justify-content-between">
				<div>
					<strong>{{ $comment->user ? $comment->user->name : '-' }}</strong>
					<span class="text-muted small ml-2">{{ $comment->created_at->format('d M Y H:i') }}</span>
				</div>
				@if($comment->user_id == auth()->id())
				<form action="{{ route('users.forum.comment.destroy', $comment->id) }}" method="post">
					@csrf
					<button type="submit" class="btn btn-danger btn-sm delete-comment"><i class="fas fa-trash"></i></button>
				</form>
				@endif
			</div>
			<div class="mt-2">
				{!! nl2br(e($comment->konten)) !!}
			</div>
		</div>
	</div>
	@empty
	<div class="alert alert-secondary">
		Belum ada komentar. Jadilah yang pertama berkomentar!
	</div>
	@endforelse

	<div class="card mt-4">
		<div class="card-header">
			<h6 class="m-0 font-weight-bold text-primary">Tambahkan Komentar</h6>
		</div>
		<div class="card-body">
			<form action="{{ route('users.forum.comment.store', $forum->id) }}" method="post">
				@csrf
				<div class="form-group">
					<textarea class="form-control" name="konten" rows="3" placeholder="Tulis komentar Anda di sini..." required></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Kirim Komentar</button>
			</form>
		</div>
	</div>

	<a href="{{ route('users.forum') }}" class="btn btn-secondary mt-3">Kembali</a>

	<x-slot name="script">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			$('.delete-comment').click(function(e) {
				e.preventDefault()
				Swal.fire({
				  title: 'Hapus komentar?',
				  text: "Komentar ini akan dihapus permanen!",
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
