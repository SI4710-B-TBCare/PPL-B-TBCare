<x-app-layout>
    <x-slot name="title">Prediksi Risiko TBC</x-slot>

    <section class="row">
        <div class="col-md-12">
            <x-alert-error></x-alert-error>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <p class="mb-4 text-muted">
                        Isi kuesioner berikut sesuai kondisi yang Anda rasakan saat ini. Semua pertanyaan wajib diisi.
                    </p>

                    {{-- Form action menggunakan route name baru --}}
                    <form action="{{ route('users.prediksi.store') }}" method="POST" id="form-prediksi">
                        @csrf

                        {{-- KELOMPOK A: Gejala Utama --}}
                        <h6 class="font-weight-bold text-primary mb-3">
                            <i class="fas fa-exclamation-circle mr-1"></i> Gejala Utama
                        </h6>
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="CO"><b>Batuk</b></label>
                                <select name="CO" id="CO" class="form-control @error('CO') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih tingkat keparahan --</option>
                                    <option value="0" {{ old('CO') === '0' ? 'selected' : '' }}>Ringan</option>
                                    <option value="1" {{ old('CO') === '1' ? 'selected' : '' }}>Sedang</option>
                                    <option value="2" {{ old('CO') === '2' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('CO')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="FV"><b>Demam</b></label>
                                <select name="FV" id="FV" class="form-control @error('FV') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih tingkat keparahan --</option>
                                    <option value="0" {{ old('FV') === '0' ? 'selected' : '' }}>Ringan</option>
                                    <option value="1" {{ old('FV') === '1' ? 'selected' : '' }}>Sedang</option>
                                    <option value="2" {{ old('FV') === '2' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('FV')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="NS"><b>Keringat Malam</b></label>
                                <select name="NS" id="NS" class="form-control @error('NS') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih tingkat keparahan --</option>
                                    <option value="0" {{ old('NS') === '0' ? 'selected' : '' }}>Ringan</option>
                                    <option value="1" {{ old('NS') === '1' ? 'selected' : '' }}>Sedang</option>
                                    <option value="2" {{ old('NS') === '2' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('NS')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- SP: Dahak — opsi BERBEDA dari severity --}}
                            <div class="col-md-6 mb-3">
                                <label for="SP"><b>Dahak (Sputum)</b></label>
                                <select name="SP" id="SP" class="form-control @error('SP') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih jenis dahak --</option>
                                    <option value="0" {{ old('SP') === '0' ? 'selected' : '' }}>Berdarah</option>
                                    <option value="1" {{ old('SP') === '1' ? 'selected' : '' }}>Bening / Tidak Berwarna</option>
                                    <option value="2" {{ old('SP') === '2' ? 'selected' : '' }}>Kehijauan</option>
                                </select>
                                @error('SP')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                        </div>

                        <hr>

                        {{-- KELOMPOK B: Gejala Pendukung --}}
                        <h6 class="font-weight-bold text-secondary mb-3">
                            <i class="fas fa-list mr-1"></i> Gejala Pendukung
                        </h6>
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="BD"><b>Kesulitan Bernapas</b></label>
                                <select name="BD" id="BD" class="form-control @error('BD') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih tingkat keparahan --</option>
                                    <option value="0" {{ old('BD') === '0' ? 'selected' : '' }}>Ringan</option>
                                    <option value="1" {{ old('BD') === '1' ? 'selected' : '' }}>Sedang</option>
                                    <option value="2" {{ old('BD') === '2' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('BD')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="CP"><b>Nyeri Dada</b></label>
                                <select name="CP" id="CP" class="form-control @error('CP') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih tingkat keparahan --</option>
                                    <option value="0" {{ old('CP') === '0' ? 'selected' : '' }}>Ringan</option>
                                    <option value="1" {{ old('CP') === '1' ? 'selected' : '' }}>Sedang</option>
                                    <option value="2" {{ old('CP') === '2' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('CP')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- IS: 4 opsi (0-3) --}}
                            <div class="col-md-6 mb-3">
                                <label for="IS"><b>Penurunan Imunitas</b></label>
                                <select name="IS" id="IS" class="form-control @error('IS') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih tingkat --</option>
                                    <option value="0" {{ old('IS') === '0' ? 'selected' : '' }}>Tidak ada</option>
                                    <option value="1" {{ old('IS') === '1' ? 'selected' : '' }}>Ringan</option>
                                    <option value="2" {{ old('IS') === '2' ? 'selected' : '' }}>Sedang</option>
                                    <option value="3" {{ old('IS') === '3' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('IS')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="LP"><b>Kehilangan Minat</b></label>
                                <select name="LP" id="LP" class="form-control @error('LP') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih tingkat keparahan --</option>
                                    <option value="0" {{ old('LP') === '0' ? 'selected' : '' }}>Ringan</option>
                                    <option value="1" {{ old('LP') === '1' ? 'selected' : '' }}>Sedang</option>
                                    <option value="2" {{ old('LP') === '2' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('LP')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="CH"><b>Menggigil</b></label>
                                <select name="CH" id="CH" class="form-control @error('CH') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih tingkat keparahan --</option>
                                    <option value="0" {{ old('CH') === '0' ? 'selected' : '' }}>Ringan</option>
                                    <option value="1" {{ old('CH') === '1' ? 'selected' : '' }}>Sedang</option>
                                    <option value="2" {{ old('CH') === '2' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('CH')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="LC"><b>Sulit Berkonsentrasi</b></label>
                                <select name="LC" id="LC" class="form-control @error('LC') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih tingkat keparahan --</option>
                                    <option value="0" {{ old('LC') === '0' ? 'selected' : '' }}>Ringan</option>
                                    <option value="1" {{ old('LC') === '1' ? 'selected' : '' }}>Sedang</option>
                                    <option value="2" {{ old('LC') === '2' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('LC')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="IR"><b>Mudah Tersinggung</b></label>
                                <select name="IR" id="IR" class="form-control @error('IR') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih tingkat keparahan --</option>
                                    <option value="0" {{ old('IR') === '0' ? 'selected' : '' }}>Ringan</option>
                                    <option value="1" {{ old('IR') === '1' ? 'selected' : '' }}>Sedang</option>
                                    <option value="2" {{ old('IR') === '2' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('IR')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="LA"><b>Kehilangan Nafsu Makan</b></label>
                                <select name="LA" id="LA" class="form-control @error('LA') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih tingkat keparahan --</option>
                                    <option value="0" {{ old('LA') === '0' ? 'selected' : '' }}>Ringan</option>
                                    <option value="1" {{ old('LA') === '1' ? 'selected' : '' }}>Sedang</option>
                                    <option value="2" {{ old('LA') === '2' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('LA')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- LE: 4 opsi (0-3) --}}
                            <div class="col-md-6 mb-3">
                                <label for="LE"><b>Kehilangan Energi</b></label>
                                <select name="LE" id="LE" class="form-control @error('LE') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih tingkat --</option>
                                    <option value="0" {{ old('LE') === '0' ? 'selected' : '' }}>Tidak ada</option>
                                    <option value="1" {{ old('LE') === '1' ? 'selected' : '' }}>Ringan</option>
                                    <option value="2" {{ old('LE') === '2' ? 'selected' : '' }}>Sedang</option>
                                    <option value="3" {{ old('LE') === '3' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('LE')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="LNE"><b>Pembengkakan Kelenjar Limfa</b></label>
                                <select name="LNE" id="LNE" class="form-control @error('LNE') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih tingkat keparahan --</option>
                                    <option value="0" {{ old('LNE') === '0' ? 'selected' : '' }}>Ringan</option>
                                    <option value="1" {{ old('LNE') === '1' ? 'selected' : '' }}>Sedang</option>
                                    <option value="2" {{ old('LNE') === '2' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('LNE')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="SBP"><b>Tekanan Darah Sistolik</b></label>
                                <select name="SBP" id="SBP" class="form-control @error('SBP') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih kategori --</option>
                                    <option value="0" {{ old('SBP') === '0' ? 'selected' : '' }}>Normal</option>
                                    <option value="1" {{ old('SBP') === '1' ? 'selected' : '' }}>Elevated</option>
                                    <option value="2" {{ old('SBP') === '2' ? 'selected' : '' }}>Tinggi</option>
                                </select>
                                @error('SBP')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="BMI"><b>Indeks Massa Tubuh (BMI)</b></label>
                                <select name="BMI" id="BMI" class="form-control @error('BMI') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih kategori --</option>
                                    <option value="0" {{ old('BMI') === '0' ? 'selected' : '' }}>Underweight (Kurus)</option>
                                    <option value="1" {{ old('BMI') === '1' ? 'selected' : '' }}>Normal</option>
                                    <option value="2" {{ old('BMI') === '2' ? 'selected' : '' }}>Overweight / Obesitas</option>
                                </select>
                                @error('BMI')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                        </div>

                        <div class="mt-3">
                            <button type="submit" id="btn-prediksi" class="btn btn-primary">
                                <i class="fas fa-search-plus mr-1"></i> Prediksi Sekarang
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <x-slot name="script">
        <script>
            document.getElementById('btn-prediksi').addEventListener('click', function () {
                this.disabled = true;
                this.closest('form').submit();
            });
        </script>
    </x-slot>

</x-app-layout>
