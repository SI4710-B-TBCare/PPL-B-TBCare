<?php

namespace Tests\Browser\Dashboard;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SebaranWilayahTest extends DuskTestCase
{
    /**
     * TC-22-01: Admin dapat melihat halaman sebaran wilayah
     */
    public function test_admin_can_see_sebaran_wilayah()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'admin')->first())
                    ->visit('/admin/dashboard')
                    ->assertSee('Sebaran Wilayah Pengguna')
                    ->screenshot('sebaran-wilayah-01');
        });
    }

    /**
     * TC-22-02: Tabel sebaran wilayah menampilkan kolom provinsi dan jumlah pengguna
     */
    public function test_tabel_sebaran_wilayah_menampilkan_provinsi()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'admin')->first())
                    ->visit('/admin/dashboard')
                    ->assertSee('Provinsi')
                    ->assertSee('Jumlah Pengguna')
                    ->screenshot('sebaran-wilayah-02');
        });
    }

    /**
     * TC-22-03: Grafik sebaran wilayah tampil
     */
    public function test_grafik_sebaran_wilayah_tampil()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'admin')->first())
                    ->visit('/admin/dashboard')
                    ->assertPresent('canvas')
                    ->assertSee('Grafik Sebaran Wilayah')
                    ->screenshot('sebaran-wilayah-03');
        });
    }

    /**
     * TC-22-04: User biasa tidak melihat fitur admin di dashboard
     */
    public function test_user_biasa_tidak_bisa_akses_admin_dashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'johni')->first())
                    ->visit('/admin/dashboard')
                    ->assertDontSee('Daftar User')
                    ->screenshot('sebaran-wilayah-04');
        });
    }

    /**
     * TC-22-05: Guest tidak bisa akses halaman admin dashboard
     */
    public function test_guest_tidak_bisa_akses_admin_dashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/admin/dashboard')
                    ->assertPathIs('/login')
                    ->screenshot('sebaran-wilayah-05');
        });
    }
}