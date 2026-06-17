<?php

namespace Tests\Browser\Forum;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminViewForumTest extends DuskTestCase
{
    /**
     * Test admin can view forum.
     */
    public function testAdminCanViewForum(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('#username', 10)
                    ->type('#username', 'admin')
                    ->type('#password', 'admin123')
                    ->press('Login')
                    ->waitForLocation('/admin/dashboard', 10);

            $browser->visit('/admin/forum')
                    ->assertSee('Daftar Forum');
        });
    }
}
