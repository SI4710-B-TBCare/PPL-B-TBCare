<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class DiskusiHasilDenganChatbotTest extends DuskTestCase
{
    /**
     * Tujuan: Memastikan pengguna dapat berdiskusi lebih lanjut mengenai 
     * hasil prediksi TBC melalui chatbot.
     * 
     * @return void
     */
    public function testDiskusiDenganChatbot()
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
            
            // 2. Pastikan terdapat tombol "Tanya Lebih Lanjut di Chatbot"
            $browser->assertSee('Tanya Lebih Lanjut di Chatbot')
            
                    // 3. Klik tombol tersebut.
                    ->clickLink('Tanya Lebih Lanjut di Chatbot')
                    ->pause(1000);

            // ==========================================
            // Assert & Act Lanjutan
            // ==========================================
            // 4. Pastikan pengguna diarahkan ke URL: users/chatbot/{id}
            $this->assertMatchesRegularExpression('/\/users\/chatbot\/\d+/', $browser->driver->getCurrentURL());
            
            // 5. Assert halaman chatbot berhasil ditampilkan.
            $browser->assertPresent('#chat-box')
            
                    // 6. Ketik pesan ke chatbot
                    ->type('#user-input', 'rumah sakit mana yang bisa menangani ini? dan apa namanya?')
                    
                    // 7. Klik tombol "Kirim"
                    ->click('#btn-send')
                    
                    // 8. Tunggu 5 detik agar respons muncul
                    ->pause(5000)
                    
                    // 9. Ambil tangkapan layar full
                    ->fitContent()
                    ->screenshot('respons-chatbot-berhasil');
        });
    }
}
