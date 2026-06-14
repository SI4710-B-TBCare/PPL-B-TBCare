<?php

namespace Tests\Browser\Dashboard;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SearchTest extends DuskTestCase
{
    public function test_user_dapat_melihat_search_bar()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'johni')->first())
                    ->visit('/users/dashboard')
                    ->assertPresent('input[name="search"]')
                    ->screenshot('search-01');
        });
    }

    public function test_user_dapat_mencari_artikel()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'johni')->first())
                    ->visit('/users/dashboard')
                    ->type('input[name="search"]', 'TBC')
                    ->press('Cari')
                    ->waitForText('Hasil pencarian untuk')
                    ->assertSee('Hasil pencarian untuk')
                    ->screenshot('search-02');
        });
    }

    public function test_user_dapat_mencari_riwayat_prediksi()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'johni')->first())
                    ->visit('/users/dashboard')
                    ->type('input[name="search"]', 'Tinggi')
                    ->press('Cari')
                    ->waitForText('Hasil pencarian untuk')
                    ->assertSee('Riwayat Prediksi TBC Saya')
                    ->screenshot('search-03');
        });
    }

    public function test_pencarian_kata_kunci_tidak_ditemukan()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'johni')->first())
                    ->visit('/users/dashboard')
                    ->type('input[name="search"]', 'xyzxyzxyz123')
                    ->press('Cari')
                    ->waitForText('Hasil pencarian untuk')
                    ->assertSee('Tidak ada artikel')
                    ->screenshot('search-04');
        });
    }

    public function test_user_dapat_reset_pencarian()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'johni')->first())
                    ->visit('/users/dashboard')
                    ->type('input[name="search"]', 'TBC')
                    ->press('Cari')
                    ->waitForText('Hasil pencarian untuk')
                    ->clickLink('Reset')
                    ->assertPathIs('/users/dashboard')
                    ->screenshot('search-05');
        });
    }
}