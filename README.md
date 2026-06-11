# TBCare

## Daftar Isi

- [Deskripsi](#deskripsi)
- [Prasyarat](#prasyarat)
- [Instalasi dan Setup Aplikasi](#instalasi-dan-menjalankan-aplikasi)
- [Penggunaan Sistem TBCare](#penggunaan-sistem-tbcare)
- [Troubleshooting](#troubleshooting)

## Deskripsi

TBCare adalah aplikasi untuk membantu pengguna dalam mengetahui potensi risiko terkena penyakit TBC sedini mungkin melalui fitur prediksi TBC berbasis Machine Learning menggunakan algoritma Random Forest. 

Selain itu, TBCare juga menyediakan fitur monitoring perkembangan hasil laboratorium TBC serta berbagai fitur pendukung lainnya, seperti ChatBot untuk menanyakan hal seputar TBC, Artikel tentang TBC, Forum Komunitas TBC, daftar fasilitas kesehatan yang dapat menangani TBC, dan berbagai fitur lainnya.

TBCare terdiri dari dua layanan utama:

* **Python API** (`python_api/`)
* **Laravel Web Application**

Dokumen ini menjelaskan langkah instalasi, konfigurasi, menjalankan aplikasi, penggunaan sistem, serta penyelesaian masalah yang umum terjadi.

---

# Prasyarat

Pastikan perangkat Anda telah memenuhi kebutuhan berikut:

* Laragon atau XAMPP
* PHP **8.2 atau versi yang lebih baru**
* MySQL **8.0 atau versi yang lebih baru**
* Python **3.10 atau versi yang lebih baru**
* Composer
* Pip

---

# Instalasi dan Menjalankan Aplikasi

Aplikasi dijalankan menggunakan dua terminal yang berbeda.

## Terminal 1 – Menjalankan Python API

1. Masuk ke direktori Python API:

   ```bash
   cd python_api/
   ```

2. Install seluruh dependency Python:

   ```bash
   pip install -r requirements.txt
   ```

3. Jalankan server Python:

   ```bash
   python app.py
   ```

---

## Terminal 2 – Menjalankan Laravel

### 1. Pastikan PHP Telah Terpasang

Pastikan PHP versi **8.2 atau lebih tinggi** telah terinstal pada perangkat Anda.

Anda dapat memverifikasinya dengan perintah:

```bash
php -v
```

---

### 2. Install Dependency Composer

Jalankan perintah berikut:

```bash
composer install
```

Apabila muncul error saat proses instalasi dependency, silakan akses bagian [**Troubleshooting**](#troubleshooting) pada dokumen ini.

---

### 3. Salin File Environment

```bash
cp .env.example .env
```

---

### 4. Sesuaikan Konfigurasi Database

Buka file `.env`, kemudian sesuaikan nilai:

```env
DB_PORT=
```

dengan port database yang digunakan pada perangkat Anda.

---

### 5. Konfigurasi GROQ API Key

Konfigurasi `GROQ_API_KEY` telah tersedia secara default pada lingkungan pengembangan tim.

Apabila `GROQ_API_KEY` yang digunakan telah mencapai limit, silakan mengganti nilainya pada file `.env` menggunakan API key Groq yang Anda miliki.

Contoh:

```env
GROQ_API_KEY=your_groq_api_key_here
```

---

### 6. Generate Application Key

```bash
php artisan key:generate
```

---

### 7. Migrasi dan Seeder Database

```bash
php artisan migrate:fresh --seed
```

---

### 8. Membuat Symbolic Link Storage

```bash
php artisan storage:link
```

---

### 9. Menjalankan Laravel

```bash
php artisan serve
```

---

### 10. Akses Aplikasi

Buka URL http://127.0.0.1:8000 melalui browser.

---

# Penggunaan Sistem TBCare

## Login

Lakukan login menggunakan salah satu akun berikut.

### Akun Admin

```text
Username : admin
Password : admin123
```

### Akun User

```text
Username : user
Password : user123
```

---

## Daftar Panduan Penggunaan Fitur

Berikut adalah daftar panduan penggunaan fitur-fitur yang ada pada sistem TBCare:

* [Panduan Penggunaan Fitur Dashboard](#)
* [Panduan Penggunaan Fitur Prediksi TBC](docs/PANDUAN_PREDIKSI_TBC.md)
* [Panduan Penggunaan Fitur ChatBot](docs/PANDUAN_CHATBOT.md)
* [Panduan Penggunaan Fitur Artikel TBC](#)
* [Panduan Penggunaan Fitur Forum TBC](#)
* [Panduan Penggunaan Fitur Feedback](#)
* [Panduan Penggunaan Fitur Monitoring TBC](#)
* [Panduan Penggunaan Fitur Fasilitas Kesehatan TBC](#)

---

## Eksplorasi Fitur

Silakan mengeksplorasi sistem sesuai fitur dan Product Backlog Item (PBI) milik masing-masing anggota.

Untuk detail PBI dapat dilihat pada dokumen berikut:

[KELOMPOKB_SPRINTPLANNING2_TBCare.docx](https://docs.google.com/document/d/1ZsZ37hMKsKj47ynR45LTphjufLCvZSW5/edit)

---

# Troubleshooting

## Composer Install Gagal karena `ext-zip`

### Gejala

Saat menjalankan:

```bash
composer install
```

muncul error terkait ekstensi `ext-zip`.

---

### Penyebab

Ekstensi PHP `zip` belum aktif pada instalasi PHP yang digunakan.

---

### Solusi

1. Cari lokasi file konfigurasi PHP (`php.ini`) yang digunakan.

   Jalankan:

   ```bash
   php --ini
   ```

2. Buka file `php.ini` tersebut.

   Contoh lokasi:

   ```text
   C:\Laragon\bin\php\php-8.2.29-Win32-vs16-x64\php.ini
   ```

3. Cari baris berikut:

   ```ini
   ;extension=zip
   ```

4. Hapus tanda titik koma (`;`) sehingga menjadi:

   ```ini
   extension=zip
   ```

5. Simpan perubahan pada file `php.ini`.

6. Tutup terminal yang sedang digunakan.

7. Buka kembali terminal atau restart aplikasi seperti Laragon/XAMPP apabila diperlukan.

8. Verifikasi bahwa ekstensi ZIP sudah aktif:

   ```bash
   php -m
   ```

   Pastikan terdapat output:

   ```text
   zip
   ```

9. Jalankan kembali:

   ```bash
   composer install
   ```

---

### Alternatif Sementara

Jika belum dapat mengaktifkan ekstensi ZIP, Composer dapat dijalankan dengan mengabaikan requirement tersebut:

```bash
composer install --ignore-platform-req=ext-zip
```

Namun, solusi ini hanya bersifat sementara dan disarankan tetap mengaktifkan ekstensi ZIP secara permanen.
