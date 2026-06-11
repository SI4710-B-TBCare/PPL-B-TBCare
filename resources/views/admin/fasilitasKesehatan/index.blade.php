<x-app-layout>
	<x-slot name="title">Daftar Fasilitas Penanganan</x-slot>
	<x-alert-error></x-alert-error>
	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif
	<x-card>
		<x-slot name="option">
			<div class="btn btn-success add">
				<i class="fas fa-plus mr-1"></i> Tambahkan Fasilitas Penanganan
			</div>
		</x-slot>

		{{-- Filter Bar --}}
		<form method="GET" action="{{ route('admin.fasilitasKesehatan') }}" class="mb-3">
			<div class="row align-items-end">
				<div class="col-md-4 mb-2">
					<label class="small font-weight-bold mb-1">Cari Nama / Kode</label>
					<input type="text" name="search" class="form-control form-control-sm"
						placeholder="Cari nama atau kode..." value="{{ request('search') }}">
				</div>
				<div class="col-md-3 mb-2">
					<label class="small font-weight-bold mb-1">Jenis Fasilitas</label>
					<select name="jenis_fasilitas" class="form-control form-control-sm">
						<option value="">-- Semua Jenis --</option>
						@foreach($daftarJenis as $jenis)
						<option value="{{ $jenis }}" {{ request('jenis_fasilitas') == $jenis ? 'selected' : '' }}>
							{{ $jenis }}
						</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-3 mb-2">
					<label class="small font-weight-bold mb-1">Kota</label>
					<select name="kota" class="form-control form-control-sm">
						<option value="">-- Semua Kota --</option>
						@foreach($daftarKota as $kota)
						<option value="{{ $kota }}" {{ request('kota') == $kota ? 'selected' : '' }}>
							{{ $kota }}
						</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-2 mb-2 d-flex">
					<button type="submit" class="btn btn-primary btn-sm mr-1 flex-fill">
						<i class="fas fa-search mr-1"></i> Filter
					</button>
					<a href="{{ route('admin.fasilitasKesehatan') }}" class="btn btn-secondary btn-sm flex-fill">
						<i class="fas fa-times"></i>
					</a>
				</div>
			</div>
		</form>

		{{-- Info hasil filter --}}
		@if(request()->hasAny(['search', 'jenis_fasilitas', 'kota']))
		<div class="alert alert-info py-2 px-3 d-flex justify-content-between align-items-center">
			<span>
				<i class="fas fa-filter mr-1"></i>
				Menampilkan <strong>{{ $fasilitasKesehatan->total() }}</strong> hasil filter
				@if(request('search')) &mdash; Pencarian: <em>"{{ request('search') }}"</em> @endif
				@if(request('jenis_fasilitas')) &mdash; Jenis: <em>{{ request('jenis_fasilitas') }}</em> @endif
				@if(request('kota')) &mdash; Kota: <em>{{ request('kota') }}</em> @endif
			</span>
		</div>
		@endif

		<table class="table table-hover border">
			<thead>
				<th>Kode</th>
				<th>Nama Fasilitas Penanganan</th>
				<th>Kategori</th>
				<th>Kota</th>
				<th>Penyebab/Keterangan</th>
				<th style="width: 150px; text-align: center;">Aksi</th>
			</thead>
			<tbody>
				@forelse($fasilitasKesehatan as $row)
				<tr>
					<td><b>{{ $row->kode }}</b></td>
					<td>{{ $row->nama }}</td>
					<td>
						@if($row->jenis_fasilitas)
						<span class="badge badge-pill
							@switch($row->jenis_fasilitas)
								@case('Rumah Sakit') badge-danger @break
								@case('Puskesmas') badge-success @break
								@case('Klinik') badge-info @break
								@case('Apotek') badge-warning @break
								@default badge-secondary
							@endswitch
						">{{ $row->jenis_fasilitas }}</span>
						@else
						<span class="text-muted small">-</span>
						@endif
					</td>
					<td>{{ $row->kota ?? '-' }}</td>
					<td>{{ Str::limit($row->penyebab, 60) }}</td>
					<td>
						<div class="d-flex justify-content-center">
							<button class="btn btn-info btn-sm view mr-1" data-id="{{ $row->id }}" title="Lihat Detail">
								<i class="fas fa-eye"></i>
							</button>
							<button class="btn btn-primary btn-sm edit mr-1" data-id="{{ $row->id }}" title="Edit">
								<i class="fas fa-edit"></i>
							</button>
							<form action="{{ route('admin.fasilitasKesehatan.destroy', $row->id) }}" method="post">
								@csrf
								<button type="submit" class="btn btn-danger btn-sm delete" title="Hapus">
									<i class="fas fa-trash"></i>
								</button>
							</form>
						</div>
					</td>
				</tr>
				@empty
				<tr>
					<td colspan="6" class="text-center">Tidak ada data ditemukan</td>
				</tr>
				@endforelse
			</tbody>
		</table>
		<div class="mt-3">
			{{ $fasilitasKesehatan->links() }}
		</div>
	</x-card>

	{{-- Modal Detail (VIEW) --}}
	<x-modal title="Detail Fasilitas Penanganan" id="view-fasilitasKesehatan">
		<div class="row mb-3">
			<div class="col-md-4 font-weight-bold">Kode:</div>
			<div class="col-md-8" id="view-kode"></div>
		</div>
		<div class="row mb-3">
			<div class="col-md-4 font-weight-bold">Nama Fasilitas:</div>
			<div class="col-md-8" id="view-nama"></div>
		</div>
		<div class="row mb-3">
			<div class="col-md-4 font-weight-bold">Jenis Fasilitas:</div>
			<div class="col-md-8" id="view-jenis-fasilitas"></div>
		</div>
		<div class="row mb-3">
			<div class="col-md-4 font-weight-bold">Alamat:</div>
			<div class="col-md-8" id="view-alamat"></div>
		</div>
		<div class="row mb-3">
			<div class="col-md-4 font-weight-bold">Kota:</div>
			<div class="col-md-8" id="view-kota"></div>
		</div>
		<div class="row mb-3">
			<div class="col-md-4 font-weight-bold">No. Telepon:</div>
			<div class="col-md-8" id="view-no-telepon"></div>
		</div>
		<div class="row mb-3">
			<div class="col-md-4 font-weight-bold">Jam Operasional:</div>
			<div class="col-md-8" id="view-jam-operasional"></div>
		</div>
		<div class="row mb-3">
			<div class="col-md-12 font-weight-bold">Penyebab / Keterangan:</div>
			<div class="col-md-12 mt-2 p-3 bg-light rounded" id="view-penyebab" style="white-space: pre-wrap;"></div>
		</div>
		<div class="mt-4 text-right">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
		</div>
	</x-modal>

	{{-- Modal Tambah --}}
	<x-modal title="Tambahkan Fasilitas Penanganan" id="fasilitasKesehatan">
		<form action="{{ route('admin.fasilitasKesehatan.store') }}" method="POST">
			@csrf
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Kode</label>
						<input type="text" class="form-control" name="kode" required placeholder="Contoh: P001">
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
						<label>Nama Fasilitas Penanganan</label>
						<input type="text" class="form-control" name="nama" required placeholder="Contoh: Puskesmas Ciputat">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Jenis Fasilitas <span class="text-muted small">(Kategori)</span></label>
						<select class="form-control" name="jenis_fasilitas">
							<option value="">-- Pilih Jenis --</option>
							<option value="Rumah Sakit">Rumah Sakit</option>
							<option value="Puskesmas">Puskesmas</option>
							<option value="Klinik">Klinik</option>
							<option value="Apotek">Apotek</option>
							<option value="Lainnya">Lainnya</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Kota</label>
						<input type="text" class="form-control" name="kota" placeholder="Contoh: Jakarta Selatan">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Alamat</label>
				<textarea class="form-control" name="alamat" rows="2" placeholder="Alamat lengkap fasilitas..."></textarea>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>No. Telepon</label>
						<input type="text" class="form-control" name="no_telepon" placeholder="Contoh: 021-7654321">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Jam Operasional</label>
						<input type="text" class="form-control" name="jam_operasional" placeholder="Contoh: 08.00 - 16.00">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Penyebab / Keterangan</label>
				<textarea class="form-control" name="penyebab" rows="4" required placeholder="Masukkan penyebab atau keterangan penanganan..."></textarea>
			</div>
			<div class="mt-2">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
	</x-modal>

	{{-- Modal Edit --}}
	<x-modal title="Edit Fasilitas Penanganan" id="edit-fasilitasKesehatan">
		<form action="{{ route('admin.fasilitasKesehatan.update') }}" method="POST">
			@csrf
			<input type="hidden" name="id">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Kode</label>
						<input type="text" class="form-control" name="kode" required>
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
						<label>Nama Fasilitas Penanganan</label>
						<input type="text" class="form-control" name="nama" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Jenis Fasilitas <span class="text-muted small">(Kategori)</span></label>
						<select class="form-control" name="jenis_fasilitas">
							<option value="">-- Pilih Jenis --</option>
							<option value="Rumah Sakit">Rumah Sakit</option>
							<option value="Puskesmas">Puskesmas</option>
							<option value="Klinik">Klinik</option>
							<option value="Apotek">Apotek</option>
							<option value="Lainnya">Lainnya</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Kota</label>
						<input type="text" class="form-control" name="kota">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Alamat</label>
				<textarea class="form-control" name="alamat" rows="2"></textarea>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>No. Telepon</label>
						<input type="text" class="form-control" name="no_telepon">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Jam Operasional</label>
						<input type="text" class="form-control" name="jam_operasional">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Penyebab / Keterangan</label>
				<textarea class="form-control" name="penyebab" rows="4" required></textarea>
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
				  title: 'Hapus data ini?',
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

			// Handle VIEW Detail
			$('.view').click(function() {
				const id = $(this).data('id')
				$.get(`{{ route('admin.fasilitasKesehatan.json') }}?id=${id}`, function(res) {
					$('#view-kode').text(res.kode)
					$('#view-nama').text(res.nama)
					$('#view-jenis-fasilitas').text(res.jenis_fasilitas || '-')
					$('#view-alamat').text(res.alamat || '-')
					$('#view-kota').text(res.kota || '-')
					$('#view-no-telepon').text(res.no_telepon || '-')
					$('#view-jam-operasional').text(res.jam_operasional || '-')
					$('#view-penyebab').text(res.penyebab)
					$('#view-fasilitasKesehatan').modal('show')
				})
			})

			// Handle EDIT
			$('.edit').click(function() {
				const id = $(this).data('id')
				$.get(`{{ route('admin.fasilitasKesehatan.json') }}?id=${id}`, function(res) {
					$('#edit-fasilitasKesehatan input[name="id"]').val(res.id)
					$('#edit-fasilitasKesehatan input[name="nama"]').val(res.nama)
					$('#edit-fasilitasKesehatan input[name="kode"]').val(res.kode)
					$('#edit-fasilitasKesehatan select[name="jenis_fasilitas"]').val(res.jenis_fasilitas)
					$('#edit-fasilitasKesehatan input[name="kota"]').val(res.kota)
					$('#edit-fasilitasKesehatan textarea[name="alamat"]').val(res.alamat)
					$('#edit-fasilitasKesehatan input[name="no_telepon"]').val(res.no_telepon)
					$('#edit-fasilitasKesehatan input[name="jam_operasional"]').val(res.jam_operasional)
					$('#edit-fasilitasKesehatan textarea[name="penyebab"]').val(res.penyebab)
					$('#edit-fasilitasKesehatan').modal('show')
				})
			})
		</script>
	</x-slot>
</x-app-layout>
