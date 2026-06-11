<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Nonaktifkan foreign key constraint sementara
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        
        // Hapus data lama agar saat di-seed ulang tidak dobel
        Artikel::truncate();

        // Aktifkan kembali foreign key constraint
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $artikels = [
            // ================= RISIKO RENDAH (0-39%) =================
            // Kategori: Pencegahan, Umum
            // Keywords: pencegahan, edukasi, gaya hidup sehat, menjaga imun, mencegah TBC, tuberkulosis
            [
                'kode' => 'PENC-001',
                'nama' => 'Pentingnya Vaksinasi BCG untuk Mencegah TBC',
                'kategori' => 'Pencegahan',
                'isi' => "Vaksin BCG (Bacille Calmette-Guérin) adalah vaksin yang diberikan untuk mencegah penyakit tuberkulosis (TBC). Vaksin ini sangat penting diberikan pada bayi baru lahir untuk mencegah TBC yang parah. BCG bekerja dengan menstimulasi sistem kekebalan tubuh agar mengenali dan melawan bakteri penyebab TBC.",
            ],
            [
                'kode' => 'PENC-002',
                'nama' => 'Gaya Hidup Sehat untuk Menjaga Imun Tubuh',
                'kategori' => 'Pencegahan',
                'isi' => "Orang dengan daya tahan tubuh yang kuat memiliki risiko lebih rendah terinfeksi TBC. Menjaga imun dapat dilakukan dengan mengonsumsi makanan bergizi seimbang, rutin berolahraga, istirahat yang cukup, dan menghindari stres. Daya tahan tubuh adalah garda terdepan melawan infeksi.",
            ],
            [
                'kode' => 'PENC-003',
                'nama' => 'Tips Pencegahan Penularan TBC di Lingkungan Keluarga',
                'kategori' => 'Pencegahan',
                'isi' => "Tuberkulosis menyebar melalui udara saat penderitanya batuk atau bersin. Untuk melakukan pencegahan di rumah, pastikan rumah memiliki ventilasi udara dan pencahayaan sinar matahari yang baik. Terapkan etika batuk dan bersin dengan benar dengan menutup mulut dan hidung.",
            ],
            [
                'kode' => 'UMUM-001',
                'nama' => 'Edukasi Umum: Apa itu Tuberkulosis?',
                'kategori' => 'Umum',
                'isi' => "Tuberkulosis adalah penyakit menular langsung yang disebabkan oleh bakteri Mycobacterium tuberculosis. TBC bukan penyakit keturunan dan sepenuhnya dapat disembuhkan jika diobati dengan benar. Penyakit ini paling sering menyerang paru-paru tetapi juga bisa menyerang organ lain.",
            ],
            [
                'kode' => 'UMUM-002',
                'nama' => 'Edukasi: Mitos dan Fakta Seputar Penyakit TBC',
                'kategori' => 'Umum',
                'isi' => "Masih banyak mitos yang beredar di masyarakat terkait TBC, misalnya TBC tidak bisa disembuhkan atau penyakit turunan. Faktanya, TBC bisa sembuh 100% asalkan disiplin berobat. Penularan juga tidak terjadi melalui berbagi alat makan, melainkan melalui percikan dahak di udara.",
            ],

            // ================= RISIKO SEDANG (40-69%) =================
            // Kategori: Gejala, Penanganan
            // Keywords: gejala, pemeriksaan, deteksi dini, konsultasi, tanda TBC, kapan ke dokter
            [
                'kode' => 'GEJL-001',
                'nama' => 'Mengenali Gejala Awal dan Tanda TBC Paru',
                'kategori' => 'Gejala',
                'isi' => "Tanda TBC sering kali diabaikan. Waspadai gejala batuk yang berlangsung lebih dari 2 minggu, demam meriang yang hilang timbul, berkeringat di malam hari tanpa aktivitas, serta penurunan berat badan tanpa sebab yang jelas. Jika Anda mengalami keluhan ini, segera waspada.",
            ],
            [
                'kode' => 'GEJL-002',
                'nama' => 'Deteksi Dini: Perbedaan Batuk Biasa dan Gejala TBC',
                'kategori' => 'Gejala',
                'isi' => "Deteksi dini sangat membantu penyembuhan. Batuk karena flu biasanya akan membaik dalam beberapa hari. Namun, batuk karena TBC cenderung menetap dan semakin parah seiring waktu, tidak mempan dengan obat batuk biasa, dan sering kali disertai dahak berwarna atau bahkan bercak darah.",
            ],
            [
                'kode' => 'PENA-001',
                'nama' => 'Kapan Harus Melakukan Pemeriksaan Medis?',
                'kategori' => 'Penanganan',
                'isi' => "Jika Anda memiliki gejala mirip TBC selama lebih dari dua minggu, atau memiliki riwayat kontak erat dengan pasien TBC, Anda sangat disarankan untuk segera melakukan pemeriksaan medis. Jangan menunda, deteksi dini sangat penting untuk keberhasilan pengobatan.",
            ],
            [
                'kode' => 'PENA-002',
                'nama' => 'Kapan ke Dokter Jika Anda Dicurigai TBC?',
                'kategori' => 'Penanganan',
                'isi' => "Kapan ke dokter? Jawabannya adalah segera setelah batuk lebih dari dua minggu. Gunakan masker medis saat berinteraksi dengan orang lain untuk mencegah penularan. Pisahkan sementara peralatan tidur dan makan jika memungkinkan.",
            ],
            [
                'kode' => 'PENA-003',
                'nama' => 'Pentingnya Konsultasi ke Fasilitas Kesehatan',
                'kategori' => 'Penanganan',
                'isi' => "Mengobati sendiri tanpa diagnosis yang tepat dapat berbahaya. Melalui konsultasi fasilitas kesehatan akan melakukan Tes Cepat Molekuler (TCM) atau rontgen dada untuk memastikan apakah keluhan yang Anda rasakan benar-benar disebabkan oleh infeksi bakteri TBC.",
            ],

            // ================= RISIKO TINGGI (70-100%) =================
            // Kategori: Pengobatan, Tindakan Segera
            // Keywords: pengobatan, diagnosis, penanganan, dokter, terapi, tindakan segera, pemeriksaan lanjutan
            [
                'kode' => 'TIND-001',
                'nama' => 'Tindakan Segera Jika Risiko TBC Anda Tinggi',
                'kategori' => 'Tindakan Segera',
                'isi' => "Jika hasil skrining atau prediksi Anda menunjukkan risiko sangat tinggi, jangan panik namun tindakan segera wajib dilakukan. Anda harus menuju fasilitas layanan kesehatan terdekat (Puskesmas/Rumah Sakit) hari ini juga atau selambatnya esok hari untuk melakukan tes dahak.",
            ],
            [
                'kode' => 'TIND-002',
                'nama' => 'Pentingnya Pemeriksaan Lanjutan TBC',
                'kategori' => 'Tindakan Segera',
                'isi' => "Pemeriksaan lanjutan sangat krusial. Anda akan diminta untuk memberikan sampel dahak yang akan diperiksa di laboratorium menggunakan alat TCM (Tes Cepat Molekuler). Tes ini sangat akurat dan hasilnya bisa diketahui dalam waktu singkat untuk menentukan penanganan selanjutnya.",
            ],
            [
                'kode' => 'PENG-001',
                'nama' => 'Mengenal Proses Diagnosis Tuberkulosis (TBC)',
                'kategori' => 'Pengobatan',
                'isi' => "Proses diagnosis TBC biasanya melibatkan dua hal utama: pemeriksaan klinis dan uji laboratorium. Tenaga medis akan mendengarkan suara paru-paru Anda, meminta foto rontgen dada, dan yang paling penting adalah pemeriksaan bakteriologis melalui sampel dahak.",
            ],
            [
                'kode' => 'PENG-002',
                'nama' => 'Pengobatan TBC: Kenali Terapi Anti Tuberkulosis',
                'kategori' => 'Pengobatan',
                'isi' => "TBC diobati dengan kombinasi pengobatan antibiotik dan terapi yang disebut OAT selama minimal 6 bulan tanpa putus. Meminum obat secara rutin adalah kunci utama kesembuhan. Menghentikan pengobatan sebelum waktunya dapat menyebabkan bakteri kebal obat (TBC MDR).",
            ],
            [
                'kode' => 'PENG-003',
                'nama' => 'Anjuran Konsultasi Penanganan dengan Dokter Spesialis Paru',
                'kategori' => 'Pengobatan',
                'isi' => "Dalam kasus dengan risiko tinggi atau gejala yang berat, penanganan oleh dokter spesialis paru sangat disarankan. Mereka akan mengevaluasi kerusakan paru-paru dan meresepkan dosis yang tepat dan memantau efek samping secara ketat.",
            ],
        ];

        foreach ($artikels as $artikel) {
            Artikel::create($artikel);
        }
    }
}
