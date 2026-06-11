# Panduan Fitur Prediksi Risiko Tuberkulosis (TBC)

## Gambaran Umum

Fitur Prediksi Risiko TBC merupakan fasilitas dalam sistem **TBCare** yang membantu pengguna memperoleh gambaran tingkat risiko Tuberkulosis berdasarkan hasil pengisian kuesioner yang telah disusun mengacu pada instrumen penelitian dan jurnal ilmiah terkait TBC.

Hasil prediksi diproses menggunakan model *Machine Learning* berbasis algoritma **Random Forest**, sehingga pengguna dapat memperoleh informasi risiko secara cepat dan terstruktur. Selain itu, sistem juga menyediakan rekomendasi lanjutan berupa saran berbasis AI, artikel edukasi, serta layanan konsultasi melalui Chatbot TBCare.

Fitur ini memiliki dua jenis akses, yaitu untuk **Admin** dan **Pengguna (User)**.

---

## Akses Admin

### Tujuan

Memberikan kemampuan kepada administrator untuk melakukan pemantauan terhadap aktivitas prediksi yang terjadi di dalam sistem.

### Fitur yang Tersedia

* Melihat daftar aktivitas prediksi yang dilakukan oleh seluruh pengguna.
* Meninjau waktu pelaksanaan prediksi.
* Melihat informasi pengguna yang melakukan prediksi sesuai hak akses yang dimiliki.
* Melakukan pemantauan terhadap penggunaan fitur prediksi sebagai bahan evaluasi sistem.

### Alur Penggunaan Admin

1. Admin masuk ke dalam sistem TBCare.
2. Admin membuka menu **Log Prediksi TBC**.
3. Sistem menampilkan riwayat seluruh aktivitas prediksi yang telah dilakukan pengguna.
4. Admin dapat meninjau data tersebut untuk kebutuhan monitoring dan pengelolaan sistem.

---

## Akses Pengguna (User)

### Tujuan

Membantu pengguna mengetahui tingkat risiko TBC berdasarkan jawaban atas kuesioner yang tersedia.

---

## Alur Prediksi Risiko TBC

### 1. Mengakses Menu Prediksi

Pengguna masuk ke sistem TBCare, kemudian memilih menu **Prediksi TBC**.

---

### 2. Mengisi Kuesioner

Sistem akan menampilkan sejumlah pertanyaan yang disusun berdasarkan indikator pada kuesioner TBC yang diperoleh dari referensi jurnal ilmiah.

Setiap pertanyaan diisi menggunakan pilihan yang telah disediakan dalam bentuk **dropdown**, misalnya:

* Ringan
* Sedang
* Berat

Pengguna wajib mengisi seluruh pertanyaan sebelum proses prediksi dapat dilanjutkan.

---

### 3. Mengirimkan Data Kuesioner

Setelah seluruh pertanyaan terisi, pengguna menekan tombol **Prediksi**.

Sistem akan melakukan proses sebagai berikut:

* Memvalidasi kelengkapan data.
* Mengubah jawaban menjadi format yang dapat diproses oleh model.
* Mengirimkan data ke modul prediksi.
* Melakukan inferensi menggunakan algoritma Machine Learning Random Forest.

---

### 4. Menampilkan Hasil Prediksi

Setelah proses prediksi selesai, pengguna akan diarahkan ke halaman hasil prediksi.

Halaman ini memuat informasi sebagai berikut:

#### a. Persentase Risiko TBC

Sistem menampilkan tingkat risiko yang dihasilkan oleh model Random Forest dalam bentuk persentase untuk masing-masing kategori risiko, seperti:

* Risiko Ringan
* Risiko Sedang
* Risiko Berat

Kategori dengan nilai probabilitas tertinggi akan menjadi hasil utama prediksi pengguna.

#### b. Ringkasan Hasil Prediksi

Sistem menampilkan kategori risiko akhir yang diperoleh pengguna berdasarkan hasil pemrosesan model.

---

### 5. Menampilkan Riwayat Jawaban

Di bawah hasil prediksi, sistem akan menampilkan kembali seluruh jawaban yang sebelumnya diinputkan pengguna.

Tujuannya adalah agar pengguna dapat:

* Melakukan peninjauan ulang terhadap data yang telah diisikan.
* Memastikan kesesuaian jawaban dengan kondisi yang dimaksud.
* Menjadikan hasil prediksi lebih mudah dipahami.

---

### 6. Rekomendasi Berbasis AI

Berdasarkan kategori risiko yang diperoleh, sistem akan menghasilkan rekomendasi secara otomatis menggunakan teknologi Artificial Intelligence (AI).

Contoh rekomendasi yang dapat diberikan antara lain:

* Saran tindakan pencegahan.
* Edukasi mengenai gejala TBC.
* Anjuran untuk melakukan pemeriksaan lanjutan.
* Informasi terkait pola hidup sehat yang mendukung kesehatan pernapasan.

Rekomendasi yang diberikan bersifat informatif dan tidak menggantikan diagnosis maupun keputusan medis dari tenaga kesehatan profesional.

---

### 7. Rekomendasi Artikel Edukasi

Sistem juga menyediakan daftar artikel yang relevan sesuai dengan tingkat risiko pengguna.

Tujuan fitur ini adalah untuk meningkatkan pemahaman pengguna mengenai TBC melalui sumber bacaan yang sesuai dengan kondisi hasil prediksi.

---

### 8. Konsultasi melalui Chatbot TBCare

Setelah melihat hasil prediksi, pengguna dapat mengajukan pertanyaan lanjutan kepada **Chatbot TBCare**.

Pengguna dapat bertanya mengenai:

* Penjelasan hasil prediksi.
* Informasi umum mengenai TBC.
* Langkah pencegahan.
* Informasi gejala.
* Edukasi kesehatan terkait TBC.

Fitur ini membantu pengguna memperoleh informasi tambahan secara lebih interaktif.

---

### 9. Riwayat Prediksi

Setiap hasil prediksi akan disimpan ke dalam sistem.

Pengguna dapat mengakses menu **Riwayat Prediksi** untuk melihat kembali seluruh prediksi yang pernah dilakukan, kapan pun dibutuhkan.

Informasi yang tersedia pada riwayat prediksi meliputi:

* Tanggal dan waktu prediksi.
* Hasil kategori risiko.
* Persentase prediksi.
* Detail jawaban kuesioner.
* Akses kembali ke rekomendasi yang pernah diberikan.

---

## Catatan Penting

* Hasil prediksi merupakan estimasi berdasarkan data kuesioner dan model Machine Learning Random Forest.
* Hasil yang diberikan tidak dapat digunakan sebagai pengganti diagnosis medis.
* Pengguna tetap disarankan untuk berkonsultasi dengan tenaga kesehatan apabila mengalami gejala yang mengarah pada TBC atau memiliki kekhawatiran terhadap kondisi kesehatannya.
