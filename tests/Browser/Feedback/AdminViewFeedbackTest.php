<?php

namespace Tests\Browser\Feedback;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminViewFeedbackTest extends DuskTestCase
{
    /**
     * Test admin can view feedbacks
     */
    public function testAdminCanViewFeedback(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('#username', 10)
                    ->type('#username', 'admin')
                    ->type('#password', 'admin123')
                    ->press('Login')
                    ->waitForLocation('/admin/dashboard', 10);

            $browser->visit('/admin/feedback')
                    ->assertSee('Daftar Feedback');
        });
    }
}
