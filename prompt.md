Kamu bisa menggunakan prompt seperti ini agar AI/cursor lebih memahami konteks dan perubahan yang diinginkan:

---

**Prompt:**

Saat ini sistem sudah memiliki fitur **Artikel**, baik pada akun **Admin** maupun **User**. Selain itu, fitur **Prediksi TBC** juga sudah berjalan dengan alur sebagai berikut:

* User mengisi kuesioner prediksi TBC.
* Setelah seluruh pertanyaan selesai dijawab, sistem melakukan proses prediksi.
* User diarahkan ke halaman **Hasil Prediksi**.
* Halaman tersebut saat ini sudah menampilkan:

  * Persentase atau tingkat risiko hasil prediksi TBC.
  * Rekomendasi otomatis berbasis AI sesuai hasil prediksi.
  * Tombol untuk melanjutkan konsultasi atau pertanyaan lanjutan kepada AI berdasarkan hasil prediksi tersebut.

Saya ingin melakukan beberapa pengembangan pada halaman **Hasil Prediksi**.

### 1. Menampilkan Ringkasan Jawaban Kuesioner

Tambahkan bagian yang menampilkan kembali seluruh jawaban yang dipilih oleh user saat mengisi kuesioner.

Tujuannya agar user dapat melakukan review terhadap data yang telah mereka masukkan.

Contoh tampilan:

* Batuk → Sedang
* Demam → Tidak
* Berat badan menurun → Ya
* Sesak napas → Ringan
* dan seterusnya sesuai seluruh pertanyaan yang ada.

Ketentuan:

* Tampilkan nama pertanyaan beserta opsi jawaban yang dipilih.
* Gunakan data hasil pengisian kuesioner yang baru saja digunakan untuk proses prediksi.
* Urutan tampilan harus sama seperti urutan pertanyaan pada kuesioner.

### 2. Menambahkan Rekomendasi Artikel Berdasarkan Hasil Prediksi

Pada halaman hasil prediksi yang sama, tambahkan fitur **Rekomendasi Artikel** yang menyesuaikan dengan tingkat risiko hasil prediksi.

Tujuannya agar user mendapatkan edukasi dan informasi yang relevan berdasarkan kondisi yang diprediksi oleh sistem.

#### Mekanisme rekomendasi:

Sistem memilih artikel yang sudah tersedia pada fitur Artikel berdasarkan kategori, tag, keyword, atau judul yang paling sesuai dengan tingkat risiko prediksi.

Contoh logika:

* **Risiko rendah (0–39%)**

  * Tampilkan artikel terkait pencegahan TBC, pola hidup sehat, menjaga daya tahan tubuh, dan edukasi umum mengenai TBC.

* **Risiko sedang (40–69%)**

  * Tampilkan artikel terkait gejala TBC, kapan harus melakukan pemeriksaan, langkah awal penanganan, serta pentingnya konsultasi medis.

* **Risiko tinggi (70–100%)**

  * Tampilkan artikel terkait tindakan yang harus segera dilakukan, pentingnya pemeriksaan lanjutan, prosedur diagnosis TBC, pengobatan TBC, serta anjuran untuk segera menghubungi tenaga kesehatan atau dokter.

Ketentuan:

* Buatlah data dummy artikel menggunakan Seeder untuk mempermudah proses testing.
* Artikel dapat dipetakan menggunakan kategori, tag, atau pencocokan keyword pada judul artikel.
* Tampilkan beberapa artikel yang paling relevan (misalnya 3–5 artikel).
* Jika tidak ditemukan artikel yang sesuai, tampilkan artikel edukasi TBC umum sebagai fallback.

### Hasil yang Diharapkan

Halaman **Hasil Prediksi TBC** nantinya akan terdiri dari:

1. Persentase atau tingkat risiko prediksi.
2. Rekomendasi otomatis berbasis AI.
3. Tombol untuk melanjutkan konsultasi dengan AI.
4. Ringkasan jawaban kuesioner yang telah dipilih user.
5. Rekomendasi artikel yang relevan berdasarkan tingkat risiko hasil prediksi.

Mohon implementasikan perubahan ini tanpa mengubah alur prediksi yang sudah berjalan saat ini. Fokus pada penambahan fitur di halaman hasil prediksi dan pastikan integrasinya tetap konsisten dengan struktur data yang sudah ada.
