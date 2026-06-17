<?php

namespace Tests\Browser\Forum;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserAddForumTest extends DuskTestCase
{
    /**
     * Test user can add forum.
     */
    public function testUserCanAddForum(): void
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
                    ->click('.add')
                    ->waitFor('#forum', 5)
                    ->pause(1000)
                    ->type('#forum input[name="judul"]', 'Judul Forum Baru')
                    ->type('#forum textarea[name="konten"]', 'Ini adalah konten forum baru yang dibuat menggunakan Dusk.')
                    ->press('#forum button[type="submit"]')
                    ->assertSee('Judul Forum Baru');
        });
    }
}
