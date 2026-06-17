<?php

namespace Tests\Browser\Forum;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserEditForumTest extends DuskTestCase
{
    /**
     * Test user can edit forum.
     */
    public function testUserCanEditForum(): void
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
                    ->click('.edit')
                    ->waitFor('#edit-forum', 5)
                    ->pause(1000)
                    ->clear('#edit-forum input[name="judul"]')
                    ->type('#edit-forum input[name="judul"]', 'Judul Forum Diedit')
                    ->clear('#edit-forum textarea[name="konten"]')
                    ->type('#edit-forum textarea[name="konten"]', 'Konten telah diedit menggunakan Dusk.')
                    ->press('#edit-forum button[type="submit"]')
                    ->waitForText('Data berhasil diubah', 10)
                    ->assertSee('Judul Forum Diedit');
        });
    }
}
