<?php

namespace Tests\Browser\Dashboard;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ArtikelTest extends DuskTestCase
{
    public function test_user_dapat_melihat_halaman_artikel()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'johni')->first())
                    ->visit('/users/artikel')
                    ->assertSee('Daftar Artikel TBCare')
                    ->screenshot('artikel-01');
        });
    }

    public function test_halaman_artikel_memiliki_search_bar()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'johni')->first())
                    ->visit('/users/artikel')
                    ->assertPresent('input[name="search"]')
                    ->screenshot('artikel-02');
        });
    }

    public function test_halaman_artikel_memiliki_filter_kategori()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'johni')->first())
                    ->visit('/users/artikel')
                    ->assertSee('Semua')
                    ->assertSee('Pencegahan')
                    ->assertSee('Gejala')
                    ->assertSee('Penanganan')
                    ->screenshot('artikel-03');
        });
    }

    public function test_halaman_artikel_kosong_menampilkan_pesan()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'johni')->first())
                    ->visit('/users/artikel')
                    ->assertSee('Tidak ada artikel yang ditemukan')
                    ->screenshot('artikel-04');
        });
    }

    public function test_guest_tidak_bisa_akses_halaman_artikel()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/users/artikel')
                    ->assertPathIs('/login')
                    ->screenshot('artikel-05');
        });
    }
}