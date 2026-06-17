<?php

namespace Tests\Browser\Feedback;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserDeleteFeedbackTest extends DuskTestCase
{
    /**
     * Test user can delete their feedback.
     */
    public function testUserCanDeleteFeedback(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('#username', 10)
                    ->type('#username', 'user')
                    ->type('#password', 'user123')
                    ->press('Login')
                    ->waitForLocation('/users/dashboard', 10);

            $browser->visit('/users/feedback')
                    ->assertSee('Daftar Feedback')
                    ->click('.delete')
                    ->waitForText('Hapus feedback?', 5)
                    ->pause(500)
                    ->press('Ya, hapus!')
                    ->waitForText('Data feedback berhasil dihapus', 5);
        });
    }
}
