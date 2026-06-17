<?php

namespace Tests\Browser\Forum;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserDeleteForumTest extends DuskTestCase
{
    /**
     * Test user can delete forum.
     */
    public function testUserCanDeleteForum(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('#username', 10)
                    ->type('#username', 'user')
                    ->type('#password', 'user123')
                    ->press('Login')
                    ->waitForLocation('/users/dashboard', 10);

            $browser->visit('/users/forum')
                    ->assertSee('Daftar Forum')
                    ->click('.delete')
                    ->waitForText('Hapus forum?', 5)
                    ->pause(500)
                    ->press('Ya, hapus!')
                    ->waitForText('Data berhasil dihapus', 10);
        });
    }
}
