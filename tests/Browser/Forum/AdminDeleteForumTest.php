<?php

namespace Tests\Browser\Forum;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminDeleteForumTest extends DuskTestCase
{
    /**
     * Test admin can delete forum.
     */
    public function testAdminCanDeleteForum(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('#username', 10)
                    ->type('#username', 'admin')
                    ->type('#password', 'admin123')
                    ->press('Login')
                    ->waitForLocation('/admin/dashboard', 10);

            $browser->visit('/admin/forum')
                    ->assertSee('Daftar Forum')
                    ->click('.delete')
                    ->waitForText('Hapus forum?', 5)
                    ->pause(500)
                    ->press('Ya, hapus!')
                    ->waitForText('Data berhasil dihapus', 10);
        });
    }
}
