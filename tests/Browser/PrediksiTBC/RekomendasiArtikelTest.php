<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class RekomendasiArtikelTest extends DuskTestCase
{
    /**
     * Tujuan: Memastikan pengguna dapat membuka rekomendasi artikel yang relevan 
     * berdasarkan hasil prediksi.
     * 
     * @return void
     */
    public function testBukaRekomendasiArtikel()
    {
        $this->browse(function (Browser $browser) {
            // ==========================================
            // Arrange
            // ==========================================
            $user = User::factory()->create();
            $user->syncRoles(['user']);

            // ==========================================
            // Act
            // ==========================================
            // 1. Jalankan seluruh langkah pada PrediksiRandomForest.
            $browser->loginAs($user)
                    ->visit('/users/prediksi/create')
                    ->select('CO', '0')
                    ->select('FV', '1')
                    ->select('NS', '2')
                    ->select('SP', '1')
                    ->select('BD', '0')
                    ->select('CP', '1')
                    ->select('IS', '1')
                    ->select('LP', '0')
                    ->select('CH', '1')
                    ->select('LC', '0')
                    ->select('IR', '1')
                    ->select('LA', '0')
                    ->select('LE', '1')
                    ->select('LNE', '0')
                    ->select('SBP', '0')
                    ->select('BMI', '1')
                    ->press('Prediksi Sekarang')
                    ->waitForText('Hasil Prediksi TBC', 15);
            
            // 2. Pada halaman hasil prediksi, cari rekomendasi artikel yang tersedia.
            $browser->waitForText('Rekomendasi Artikel Untuk Anda', 5)
                    ->assertSee('Rekomendasi Artikel Untuk Anda')
                    ->fitContent()
                    // 3. Ambil screenshot daftar rekomendasi artikel
                    ->screenshot('daftar-rekomendasi-artikel-berhasil');
        });
    }
}
