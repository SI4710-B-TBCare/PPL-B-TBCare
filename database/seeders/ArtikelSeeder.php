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
        $artikels = [
            // ================= PENCEGAHAN =================
            [
                'kode' => 'PENC-001',
                'nama' => 'Pentingnya Vaksinasi BCG untuk Mencegah TBC',
                'kategori' => 'Pencegahan',
                'isi' => "Vaksin BCG (Bacille Calmette-Guérin) adalah vaksin yang diberikan untuk mencegah penyakit tuberkulosis (TBC). Vaksin ini sangat penting diberikan pada bayi baru lahir untuk mencegah TBC yang parah, seperti meningitis TBC. BCG bekerja dengan menstimulasi sistem kekebalan tubuh agar mengenali dan melawan bakteri penyebab TBC.\n\nPemberian vaksin ini adalah bagian dari program imunisasi wajib pemerintah, sehingga sangat disarankan agar para orang tua tidak melewatkan jadwal imunisasi BCG untuk anak-anak mereka.",
            ],
            [
                'kode' => 'PENC-002',
                'nama' => 'Etika Batuk dan Bersin yang Benar',
                'kategori' => 'Pencegahan',
                'isi' => "Tuberkulosis menyebar melalui udara ketika penderitanya batuk atau bersin. Oleh karena itu, menerapkan etika batuk dan bersin yang benar sangatlah penting untuk memutus mata rantai penularan.\n\nCara yang benar adalah dengan menutup mulut dan hidung menggunakan tisu saat batuk atau bersin, lalu segera buang tisu tersebut ke tempat sampah. Jika tidak ada tisu, gunakan lengan baju bagian dalam, bukan telapak tangan. Selalu cuci tangan setelah batuk atau bersin untuk menjaga kebersihan.",
            ],
            [
                'kode' => 'PENC-003',
                'nama' => 'Pentingnya Ventilasi Udara di Rumah',
                'kategori' => 'Pencegahan',
                'isi' => "Kuman TBC (Mycobacterium tuberculosis) dapat bertahan di udara dalam ruangan tertutup dan lembap selama beberapa jam. Sirkulasi udara yang buruk meningkatkan risiko penularan yang signifikan.\n\nMembuka jendela dan membiarkan sinar matahari masuk ke dalam rumah dapat membantu membunuh kuman TBC yang ada di udara. Pastikan rumah Anda memiliki sirkulasi udara yang baik, terutama jika ada anggota keluarga yang sedang menjalani pengobatan TBC.",
            ],
            [
                'kode' => 'PENC-004',
                'nama' => 'Menjaga Daya Tahan Tubuh agar Terhindar dari TBC',
                'kategori' => 'Pencegahan',
                'isi' => "Orang dengan daya tahan tubuh yang lemah, seperti penderita HIV, diabetes, atau gizi buruk, lebih rentan terinfeksi TBC. Menjaga daya tahan tubuh tetap prima adalah salah satu cara terbaik mencegah TBC.\n\nLangkah-langkah yang bisa dilakukan meliputi mengonsumsi makanan bergizi seimbang, rutin berolahraga, tidur yang cukup, dan mengelola stres. Gaya hidup sehat secara keseluruhan membuat tubuh lebih siap melawan bakteri yang mencoba masuk.",
            ],
            [
                'kode' => 'PENC-005',
                'nama' => 'Hindari Kebiasaan Merokok dan Alkohol',
                'kategori' => 'Pencegahan',
                'isi' => "Kebiasaan merokok dapat merusak paru-paru dan melemahkan pertahanan alaminya, membuat seseorang lebih mudah terserang penyakit pernapasan, termasuk TBC. Demikian juga dengan konsumsi alkohol berlebihan yang melemahkan sistem imun.\n\nBerhenti merokok tidak hanya mencegah TBC, tetapi juga berbagai penyakit paru kronis lainnya. Bagi yang sedang menjalani pengobatan TBC, merokok sangat dilarang karena akan menghambat proses penyembuhan.",
            ],

            // ================= PENGOBATAN =================
            [
                'kode' => 'PENG-001',
                'nama' => 'Mengenal OAT (Obat Anti Tuberkulosis)',
                'kategori' => 'Pengobatan',
                'isi' => "Pengobatan TBC dilakukan dengan menggunakan Obat Anti Tuberkulosis (OAT). OAT merupakan kombinasi beberapa jenis antibiotik yang harus diminum secara rutin oleh penderita TBC. Jenis OAT yang umum digunakan antara lain Isoniazid, Rifampisin, Pirazinamid, dan Etambutol.\n\nKombinasi ini bertujuan untuk membunuh bakteri dengan efektif dan mencegah terjadinya resistensi obat.",
            ],
            [
                'kode' => 'PENG-002',
                'nama' => 'Durasi Pengobatan TBC yang Harus Dipatuhi',
                'kategori' => 'Pengobatan',
                'isi' => "Berbeda dengan infeksi bakteri biasa yang dapat sembuh dalam hitungan hari, pengobatan TBC membutuhkan waktu yang jauh lebih lama, umumnya memakan waktu minimal 6 bulan.\n\nPengobatan ini terbagi menjadi dua fase: fase intensif (2 bulan pertama) di mana pasien meminum obat setiap hari, dan fase lanjutan (4 bulan berikutnya) dengan dosis obat yang dikurangi. Mematuhi durasi ini sangat krusial meskipun pasien sudah merasa sehat sebelum masa pengobatan selesai.",
            ],
            [
                'kode' => 'PENG-003',
                'nama' => 'Bahaya Putus Obat TBC',
                'kategori' => 'Pengobatan',
                'isi' => "Banyak pasien merasa tubuhnya sudah membaik setelah beberapa minggu minum OAT, lalu memutuskan untuk berhenti berobat secara sepihak. Ini adalah tindakan yang sangat berbahaya.\n\nPutus obat dapat menyebabkan bakteri TBC bermutasi dan menjadi kebal terhadap obat yang biasa diberikan, kondisi yang disebut TBC MDR (Multi-Drug Resistant). Jika hal ini terjadi, pengobatan akan jauh lebih sulit, memakan waktu lebih lama (hingga 2 tahun), dan menimbulkan efek samping yang lebih berat.",
            ],
            [
                'kode' => 'PENG-004',
                'nama' => 'Peran PMO (Pengawas Menelan Obat)',
                'kategori' => 'Pengobatan',
                'isi' => "Karena pengobatan TBC memakan waktu berbulan-bulan, risiko pasien lupa atau bosan minum obat sangat tinggi. Di sinilah pentingnya peran PMO (Pengawas Menelan Obat).\n\nPMO biasanya adalah anggota keluarga terdekat, petugas kesehatan, atau kader masyarakat yang bertugas mendampingi dan memastikan pasien menelan obatnya setiap hari sesuai dosis. Dukungan dari PMO sangat membantu kesuksesan kesembuhan pasien.",
            ],
            [
                'kode' => 'PENG-005',
                'nama' => 'Efek Samping Obat TBC dan Cara Mengatasinya',
                'kategori' => 'Pengobatan',
                'isi' => "Seperti obat lainnya, OAT memiliki efek samping. Beberapa pasien mungkin mengalami mual, muntah, hilangnya nafsu makan, gatal-gatal, atau perubahan warna urine menjadi kemerahan (efek dari Rifampisin).\n\nSebagian besar efek samping ini ringan. Namun, jika pasien mengalami kulit atau mata yang menguning, gangguan penglihatan, atau nyeri sendi hebat, segera hubungi dokter. Dokter mungkin perlu menyesuaikan dosis atau memberikan obat tambahan untuk meredakan keluhan tersebut.",
            ],

            // ================= GEJALA =================
            [
                'kode' => 'GEJL-001',
                'nama' => 'Batuk Berkepanjangan Lebih dari 2 Minggu',
                'kategori' => 'Gejala',
                'isi' => "Batuk yang tidak kunjung sembuh, bahkan setelah lebih dari 2 minggu, merupakan salah satu gejala utama dari tuberkulosis paru. Batuk ini biasanya disertai dengan produksi dahak yang banyak.\n\nJika Anda atau keluarga mengalami batuk seperti ini, terutama jika sudah mencoba obat batuk biasa namun tidak ada perubahan, segera periksakan diri ke puskesmas atau rumah sakit untuk dilakukan tes dahak (TCM).",
            ],
            [
                'kode' => 'GEJL-002',
                'nama' => 'Batuk Berdarah: Tanda Peringatan Dini',
                'kategori' => 'Gejala',
                'isi' => "Batuk berdarah (hemoptisis) terjadi ketika infeksi TBC telah menyebabkan kerusakan yang cukup parah pada pembuluh darah di paru-paru. Darah yang keluar bisa berupa bercak pada dahak atau jumlah yang lebih banyak.\n\nIni adalah gejala kegawatdaruratan medis. Jangan tunda lagi, segeralah mencari pertolongan medis jika Anda mulai mengeluarkan darah saat batuk.",
            ],
            [
                'kode' => 'GEJL-003',
                'nama' => 'Penurunan Berat Badan Drastis Tanpa Sebab',
                'kategori' => 'Gejala',
                'isi' => "Infeksi bakteri TBC membuat tubuh bekerja ekstra keras untuk melawan kuman. Akibatnya, tubuh membakar lebih banyak kalori, yang disertai dengan hilangnya nafsu makan.\n\nPenurunan berat badan yang cepat dan tidak wajar, meskipun Anda tidak sedang diet, adalah indikator kuat adanya penyakit kronis di dalam tubuh, salah satunya adalah TBC.",
            ],
            [
                'kode' => 'GEJL-004',
                'nama' => 'Berkeringat di Malam Hari Tanpa Aktivitas',
                'kategori' => 'Gejala',
                'isi' => "Sering terbangun di malam hari karena tubuh basah oleh keringat, padahal suhu ruangan tidak panas dan Anda tidak melakukan aktivitas fisik, merupakan gejala klasik dari TBC.\n\nKeringat malam ini adalah respons sistem kekebalan tubuh terhadap peradangan kronis yang ditimbulkan oleh Mycobacterium tuberculosis.",
            ],
            [
                'kode' => 'GEJL-005',
                'nama' => 'Demam Meriang yang Hilang Timbul',
                'kategori' => 'Gejala',
                'isi' => "Berbeda dengan demam berdarah atau tifus yang memiliki suhu tubuh tinggi, demam pada penderita TBC biasanya berstatus 'meriang' atau demam ringan (subfebris).\n\nDemam ini bisa berlangsung lama dan sering terjadi di sore atau malam hari, disertai dengan badan yang terasa lemas dan menggigil.",
            ],
            [
                'kode' => 'GEJL-006',
                'nama' => 'Nyeri Dada dan Sesak Napas',
                'kategori' => 'Gejala',
                'isi' => "TBC yang menyerang selaput paru (pleura) dapat menyebabkan penumpukan cairan yang membuat paru-paru sulit mengembang. Hal ini memicu rasa nyeri tajam saat menarik napas dalam-dalam atau saat batuk.\n\nSeiring dengan kerusakan jaringan paru-paru, kapasitas oksigen yang dihirup menurun, menyebabkan pasien sering merasa sesak napas saat melakukan aktivitas fisik.",
            ],

            // ================= UMUM =================
            [
                'kode' => 'UMUM-001',
                'nama' => 'Apa itu Tuberkulosis (TBC)?',
                'kategori' => 'Umum',
                'isi' => "Tuberkulosis atau TBC adalah penyakit menular langsung yang disebabkan oleh kuman TB (Mycobacterium tuberculosis). Sebagian besar kuman TB menyerang paru, tetapi juga dapat mengenai organ tubuh lainnya (TBC Ekstra Paru) seperti tulang, kelenjar getah bening, selaput otak, atau ginjal.\n\nTBC bukan penyakit keturunan, juga bukan disebabkan oleh kutukan atau guna-guna. TBC sepenuhnya dapat disembuhkan jika diobati dengan benar.",
            ],
            [
                'kode' => 'UMUM-002',
                'nama' => 'Mitos dan Fakta Seputar Penyakit TBC',
                'kategori' => 'Umum',
                'isi' => "Mitos: TBC adalah penyakit orang miskin.\nFakta: TBC dapat menyerang siapa saja dari berbagai kalangan ekonomi. Namun, lingkungan padat penduduk dan malnutrisi mempertinggi risikonya.\n\nMitos: TBC tidak bisa disembuhkan.\nFakta: TBC bisa disembuhkan 100% asalkan pasien disiplin meminum OAT secara rutin sampai selesai.\n\nMitos: TBC menyebar melalui alat makan.\nFakta: Kuman TBC tidak menyebar melalui piring atau gelas. Penularan hanya melalui percikan dahak (droplet) di udara saat pasien batuk atau bersin.",
            ],
            [
                'kode' => 'UMUM-003',
                'nama' => 'Perbedaan TBC Paru dan TBC Kelenjar',
                'kategori' => 'Umum',
                'isi' => "TBC Paru adalah bentuk yang paling umum terjadi, menyerang jaringan paru-paru dan sangat mudah menular melalui udara. Sementara TBC Kelenjar terjadi ketika kuman TBC menyerang kelenjar getah bening, seringkali di area leher.\n\nTBC kelenjar biasanya ditandai dengan benjolan pada leher atau area lainnya yang terkadang membengkak dan bernanah. Berbeda dengan TBC paru, TBC kelenjar umumnya tidak menular ke orang lain melalui udara.",
            ],
            [
                'kode' => 'UMUM-004',
                'nama' => 'TBC pada Anak: Apa yang Harus Diketahui?',
                'kategori' => 'Umum',
                'isi' => "Gejala TBC pada anak sering kali tidak khas seperti orang dewasa. Anak jarang mengalami batuk berdarah. Gejala yang paling umum justru berupa berat badan tidak kunjung naik (gagal tumbuh), demam lama yang tidak diketahui sebabnya, anak tampak lesu, kurang aktif bermain, dan batuk yang membandel.\n\nDiagnosis TBC pada anak sering menggunakan uji tuberkulin (Mantoux test) dan sistem skoring. Anak yang tinggal serumah dengan penderita TBC dewasa sangat berisiko dan perlu diperiksa.",
            ],
            [
                'kode' => 'UMUM-005',
                'nama' => 'Dukungan Psikososial untuk Pasien TBC',
                'kategori' => 'Umum',
                'isi' => "Stigma negatif tentang penyakit TBC di masyarakat sering membuat pasien merasa dikucilkan, depresi, atau malu untuk berobat. Dukungan psikososial dari keluarga dan teman sangatlah krusial.\n\nBerikan semangat kepada penderita, jangan menjauhi mereka tetapi edukasilah keluarga untuk menerapkan protokol kesehatan di rumah. Motivasi yang baik terbukti meningkatkan tingkat kepatuhan minum obat dan mempercepat proses kesembuhan.",
            ],
        ];

        foreach ($artikels as $artikel) {
            Artikel::create($artikel);
        }
    }
}
