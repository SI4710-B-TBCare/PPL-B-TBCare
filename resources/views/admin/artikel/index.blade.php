<x-app-layout>
	<x-slot name="title">Daftar Artikel</x-slot>
	<x-alert-error></x-alert-error>
	@if(session()->has('success'))
		<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif

	<x-card>
		<x-slot name="option">
			<div class="btn btn-success add">
				<i class="fas fa-plus mr-1"></i> Tambahkan Artikel
			</div>
		</x-slot>

		<table class="table table-hover border">
			<thead>
				<th>Kode</th>
				<th>Gambar</th>
				<th>Nama Artikel</th>
				<th></th>
			</thead>
			<tbody>
				@forelse($artikel as $row)
				<tr>
					<td><b>{{ $row->kode }}</b></td>
					<td>
						@if($row->gambar)
							<img src="{{ Storage::url($row->gambar) }}"
								alt="{{ $row->nama }}"
								style="width:60px; height:60px; object-fit:cover; border-radius:6px;">
						@else
							<span class="text-muted">-</span>
						@endif
					</td>
					<td>{{ $row->nama }}</td>
					<td>
						<div class="d-flex">
							<button class="btn btn-primary btn-sm edit" data-id="{{ $row->id }}">
								<i class="fas fa-edit"></i>
							</button>
							<form action="{{ route('admin.artikel.destroy', $row->id) }}" method="post" class="ml-1">
								@csrf
								<button type="submit" class="btn btn-danger btn-sm delete">
									<i class="fas fa-trash"></i>
								</button>
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
			{{ $artikel->links() }}
		</div>
	</x-card>

	{{-- Modal Tambah Artikel --}}
	<x-modal title="Tambahkan Artikel" id="artikel">
		<form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Kode Artikel</label>
						<input type="text" class="form-control bg-light" name="kode" id="kode-generate" readonly>
						<small class="text-muted">Kode di-generate otomatis</small>
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
						<label>Nama Artikel</label>
						<input type="text" class="form-control" name="nama">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Gambar Artikel</label>
				<input type="file" class="form-control-file" name="gambar" accept="image/*" id="gambar-preview-input">
				<div class="mt-2" id="gambar-preview-wrapper" style="display:none;">
					<img id="gambar-preview" src="" alt="Preview"
						style="max-width:200px; max-height:150px; object-fit:cover; border-radius:6px; border:1px solid #ddd;">
				</div>
			</div>
			<div class="form-group">
				<label>Isi / Deskripsi Artikel</label>
				<textarea class="form-control" name="isi" rows="5" placeholder="Tulis isi artikel di sini..."></textarea>
			</div>
			<div class="mt-2">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
	</x-modal>

	{{-- Modal Edit Artikel --}}
	<x-modal title="Edit Artikel" id="edit-artikel">
		<form action="{{ route('admin.artikel.update') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="id">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Kode Artikel</label>
						<input type="text" class="form-control" name="kode">
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
						<label>Nama Artikel</label>
						<input type="text" class="form-control" name="nama">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Gambar Artikel</label>
				{{-- Preview gambar existing --}}
				<div class="mb-2">
					<img id="edit-gambar-existing" src="" alt="Gambar Saat Ini"
						style="max-width:200px; max-height:150px; object-fit:cover; border-radius:6px; border:1px solid #ddd; display:none;">
					<p class="text-muted mt-1" id="edit-gambar-existing-label" style="display:none;">
						<small>Gambar saat ini. Upload baru untuk mengganti.</small>
					</p>
				</div>
				<input type="file" class="form-control-file" name="gambar" accept="image/*" id="edit-gambar-preview-input">
				{{-- Preview gambar baru --}}
				<div class="mt-2" id="edit-gambar-preview-wrapper" style="display:none;">
					<img id="edit-gambar-preview" src="" alt="Preview Baru"
						style="max-width:200px; max-height:150px; object-fit:cover; border-radius:6px; border:1px solid #ddd;">
				</div>
			</div>
			<div class="form-group">
				<label>Isi / Deskripsi Artikel</label>
				<textarea class="form-control" name="isi" rows="5"></textarea>
			</div>
			<div class="mt-2">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
	</x-modal>

	<x-slot name="script">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			// ── Tambah: buka modal & generate kode otomatis ──
			$('.add').click(function () {
				$.get('{{ route('admin.artikel.generate-kode') }}', function (res) {
					$('#kode-generate').val(res.kode)
				})
				// Reset form & preview
				$('#artikel input[name="nama"]').val('')
				$('#artikel textarea[name="isi"]').val('')
				$('#artikel input[name="gambar"]').val('')
				$('#gambar-preview-wrapper').hide()

				$('#artikel').modal('show')
			})

			// ── Preview gambar di modal tambah ──
			$('#gambar-preview-input').on('change', function () {
				const file = this.files[0]
				if (file) {
					const reader = new FileReader()
					reader.onload = function (e) {
						$('#gambar-preview').attr('src', e.target.result)
						$('#gambar-preview-wrapper').show()
					}
					reader.readAsDataURL(file)
				}
			})

			// ── Hapus dengan konfirmasi SweetAlert ──
			$(document).on('click', '.delete', function (e) {
				e.preventDefault()
				const form = $(this).closest('form')
				Swal.fire({
					title: 'Hapus data artikel?',
					text: 'Kamu tidak akan bisa mengembalikannya kembali!',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#3085d6',
					cancelButtonText: 'Batal',
					confirmButtonText: 'Ya, hapus!'
				}).then((result) => {
					if (result.isConfirmed) {
						form.submit()
					}
				})
			})

			// ── Edit: ambil data via AJAX & isi modal ──
			$(document).on('click', '.edit', function () {
				const id = $(this).data('id')

				$.get('{{ route('admin.artikel.json') }}?id=' + id, function (res) {
					$('#edit-artikel input[name="id"]').val(res.id)
					$('#edit-artikel input[name="kode"]').val(res.kode)
					$('#edit-artikel input[name="nama"]').val(res.nama)
					$('#edit-artikel textarea[name="isi"]').val(res.isi)

					// Tampilkan gambar existing jika ada
					if (res.gambar) {
						$('#edit-gambar-existing').attr('src', '/storage/' + res.gambar).show()
						$('#edit-gambar-existing-label').show()
					} else {
						$('#edit-gambar-existing').hide()
						$('#edit-gambar-existing-label').hide()
					}

					// Reset preview gambar baru
					$('#edit-gambar-preview-wrapper').hide()
					$('#edit-gambar-preview-input').val('')

					$('#edit-artikel').modal('show')
				})
			})

			// ── Preview gambar baru di modal edit ──
			$('#edit-gambar-preview-input').on('change', function () {
				const file = this.files[0]
				if (file) {
					const reader = new FileReader()
					reader.onload = function (e) {
						$('#edit-gambar-preview').attr('src', e.target.result)
						$('#edit-gambar-preview-wrapper').show()
					}
					reader.readAsDataURL(file)
				}
			})
		</script>
	</x-slot>
</x-app-layout>