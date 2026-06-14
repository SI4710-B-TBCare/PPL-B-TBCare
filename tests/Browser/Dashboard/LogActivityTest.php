<?php

namespace Tests\Browser\Dashboard;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LogActivityTest extends DuskTestCase
{
    public function test_admin_dapat_melihat_log_aktivitas()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'admin')->first())
                    ->visit('/admin/logs')
                    ->assertSee('Activity Log')
                    ->screenshot('log-activity-01');
        });
    }

    public function test_halaman_log_aktivitas_memiliki_tabel()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'admin')->first())
                    ->visit('/admin/logs')
                    ->assertSee('Description')
                    ->assertSee('Properties')
                    ->assertSee('Date')
                    ->screenshot('log-activity-02');
        });
    }

    public function test_admin_dapat_akses_halaman_log_lengkap()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'admin')->first())
                    ->visit('/admin/logs')
                    ->assertPathIs('/admin/logs')
                    ->screenshot('log-activity-03');
        });
    }

    public function test_halaman_log_menampilkan_tombol_delete()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('username', 'admin')->first())
                    ->visit('/admin/logs')
                    ->assertSee('Delete 7 days ago')
                    ->screenshot('log-activity-04');
        });
    }

    public function test_guest_tidak_bisa_akses_log_aktivitas()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/admin/logs')
                    ->assertPathIs('/login')
                    ->screenshot('log-activity-05');
        });
    }
}