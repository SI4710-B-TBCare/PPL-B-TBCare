<?php

namespace App\Traits;

trait RekomendasiTrait
{
    public function getRekomendasi(float $cf): array
    {
        $persen = round($cf * 100, 1);

        if ($cf >= 0.8) {
            return [
                'level'  => 'danger',
                'judul'  => 'Risiko Sangat Tinggi — Segera Ambil Tindakan',
                'persen' => $persen,
                'saran'  => [
                    'Segera kunjungi dokter spesialis paru atau rumah sakit terdekat <strong>hari ini</strong>.',
                    'Lakukan pemeriksaan dahak (sputum BTA) dan foto rontgen dada untuk konfirmasi diagnosis.',
                    'Isolasi diri dari anggota keluarga, terutama anak-anak dan lansia, hingga mendapat kepastian dari dokter.',
                    'Gunakan masker di dalam maupun luar rumah untuk mencegah penularan.',
                    'Jangan menunda — TBC yang ditangani cepat memiliki tingkat kesembuhan sangat tinggi.',
                    'Jika terkonfirmasi TBC, jalani program OAT (Obat Anti Tuberkulosis) minimal 6 bulan penuh tanpa putus.',
                ],
            ];
        } elseif ($cf >= 0.6) {
            return [
                'level'  => 'warning',
                'judul'  => 'Risiko Tinggi — Periksakan Diri Segera',
                'persen' => $persen,
                'saran'  => [
                    'Kunjungi puskesmas atau dokter umum dalam <strong>1–2 hari ke depan</strong> untuk pemeriksaan lanjutan.',
                    'Sampaikan gejala yang kamu alami secara lengkap kepada dokter.',
                    'Lakukan pemeriksaan rontgen dada dan tes dahak sebagai langkah konfirmasi.',
                    'Sementara menunggu hasil, gunakan masker dan kurangi kontak dekat dengan orang lain.',
                    'Tingkatkan asupan nutrisi: konsumsi makanan bergizi tinggi protein, vitamin C, dan D.',
                    'Istirahat cukup minimal 8 jam per hari dan hindari paparan asap rokok.',
                ],
            ];
        } elseif ($cf >= 0.4) {
            return [
                'level'  => 'info',
                'judul'  => 'Risiko Sedang — Perlu Pemantauan',
                'persen' => $persen,
                'saran'  => [
                    'Jadwalkan konsultasi ke dokter atau puskesmas dalam <strong>minggu ini</strong>.',
                    'Pantau perkembangan gejala setiap hari — jika memburuk, segera ke fasilitas kesehatan.',
                    'Catat gejala yang kamu rasakan (durasi, intensitas) untuk disampaikan ke dokter.',
                    'Jaga kebersihan lingkungan rumah: ventilasi udara yang baik sangat penting.',
                    'Perkuat daya tahan tubuh dengan olahraga ringan, tidur cukup, dan konsumsi makanan bergizi.',
                    'Hindari kontak terlalu dekat dengan penderita TBC aktif yang diketahui.',
                ],
            ];
        } elseif ($cf >= 0.2) {
            return [
                'level'  => 'secondary',
                'judul'  => 'Risiko Rendah — Tetap Waspada',
                'persen' => $persen,
                'saran'  => [
                    'Kemungkinan TBC relatif rendah, namun tetap pantau gejala yang kamu rasakan.',
                    'Jika gejala seperti batuk berlanjut lebih dari 2 minggu, segera konsultasikan ke dokter.',
                    'Jaga pola hidup sehat: konsumsi makanan bergizi, olahraga teratur, dan tidur cukup.',
                    'Pastikan rumah mendapat cukup sinar matahari dan sirkulasi udara yang baik.',
                    'Lakukan pemeriksaan kesehatan rutin setidaknya 6 bulan sekali.',
                ],
            ];
        } else {
            return [
                'level'  => 'success',
                'judul'  => 'Risiko Sangat Rendah — Jaga Kesehatan',
                'persen' => $persen,
                'saran'  => [
                    'Berdasarkan gejala yang diinputkan, kemungkinan TBC sangat kecil.',
                    'Tetap jaga pola hidup sehat sebagai langkah pencegahan.',
                    'Konsumsi makanan bergizi seimbang dan olahraga minimal 30 menit per hari.',
                    'Pastikan lingkungan tempat tinggal bersih, berventilasi baik, dan terkena sinar matahari.',
                    'Lakukan pemeriksaan kesehatan rutin dan vaksinasi BCG jika belum pernah.',
                ],
            ];
        }
    }
}