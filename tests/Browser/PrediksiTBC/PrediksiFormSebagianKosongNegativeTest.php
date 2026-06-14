<?php

namespace Tests\Browser\PrediksiTBC;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class PrediksiFormSebagianKosongNegativeTest extends DuskTestCase
{
    /**
     * Tujuan: Memastikan aplikasi menolak submit jika pengguna hanya 
     * mengisi sebagian form prediksi, dan memastikan jawaban yang 
     * sudah diisi tidak hilang (old input validation).
     * 
     * @return void
     */
    public function testSubmitSebagianKosong()
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
            $browser->loginAs($user)
                    // 1. Buka halaman kuesioner prediksi TBC
                    ->visit('/users/prediksi/create')
                    
                    // 2. Isi HANYA sebagian pertanyaan (misal 3 pertanyaan pertama)
                    ->select('CO', '0') // Batuk: Ringan
                    ->select('FV', '1') // Demam: Sedang
                    ->select('NS', '2') // Keringat Malam: Berat
                    
                    // 3. Biarkan sisa field lainnya kosong, dan tekan submit
                    ->press('Prediksi Sekarang')
                    ->pause(1000); // Tunggu proses redirect kembali karena validasi error

            // ==========================================
            // Assert
            // ==========================================
            // 4. Pastikan URL tidak berpindah ke halaman hasil (masih di halaman create)
            $browser->assertPathIs('/users/prediksi/create')
            
                    // 5. Pastikan nilai dari dropdown yang sebelumnya diisi tetap terpilih (old input)
                    ->assertSelected('CO', '0')
                    ->assertSelected('FV', '1')
                    ->assertSelected('NS', '2')
                    
                    // 6. Ambil tangkapan layar full untuk membuktikan adanya validasi error
                    ->fitContent()
                    ->screenshot('prediksi-sebagian-kosong-negative-test');
        });
    }
}
