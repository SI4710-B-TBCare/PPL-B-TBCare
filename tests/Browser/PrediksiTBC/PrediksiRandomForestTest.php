<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class PrediksiRandomForestTest extends DuskTestCase
{
    /**
     * Tujuan: Memastikan pengguna dapat melakukan prediksi TBC dan melihat halaman hasil prediksi.
     * 
     * @return void
     */
    public function testPrediksiDanLihatHasil()
    {
        $this->browse(function (Browser $browser) {
            // ==========================================
            // Arrange
            // ==========================================
            // Membuat dummy user untuk login
            $user = User::factory()->create();
            // Beri role 'user' karena default factory adalah Admin
            $user->syncRoles(['user']);

            // ==========================================
            // Act
            // ==========================================
            $browser->loginAs($user)
                    // 1. Buka halaman kuesioner prediksi TBC.
                    ->visit('/users/prediksi/create')
                    
                    // 3. Isi seluruh pertanyaan kuesioner dengan jawaban valid (Ringan/Sedang/Berat dll).
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
                    
                    // 4. Klik tombol "Submit".
                    ->press('Prediksi Sekarang')
                    
                    // 5. Tunggu proses prediksi selesai.
                    ->waitForReload()
                    ->pause(1000);

            // ==========================================
            // Assert
            // ==========================================
            // 6. Pastikan pengguna diarahkan ke URL: users/prediksi/{id}
            $this->assertMatchesRegularExpression('/\/users\/prediksi\/\d+/', $browser->driver->getCurrentURL());
            
            // 7. Assert bahwa halaman hasil berhasil ditampilkan.
            $browser->assertSee('Hasil Prediksi TBC')
            ->screenshot('hasil-prediksi-berhasil')
                    
                    // 8. Assert pengguna dapat melihat persentase risiko, ringkasan, dll
                    ->assertSee('Tingkat Risiko TBC:')
                    ->assertSee('Ringkasan Jawaban Kuesioner')
                    ->waitFor('#ai-content', 15) // Tunggu rekomendasi AI selesai generate
                    ->assertSee('Rekomendasi AI TBCare')
                    ->assertSee('Rekomendasi Artikel Untuk Anda');
        });
    }
}
