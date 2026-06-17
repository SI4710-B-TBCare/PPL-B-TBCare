<?php

namespace Tests\Browser\Feedback;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserEditFeedbackTest extends DuskTestCase
{
    /**
     * Test user can edit their feedback.
     */
    public function testUserCanEditFeedback(): void
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
                    ->click('.edit')
                    ->waitFor('#edit-feedback', 5)
                    ->pause(1000)
                    ->clear('#edit-feedback textarea[name="pesan"]')
                    ->type('#edit-feedback textarea[name="pesan"]', 'Ini pesan yang sudah diedit lewat Dusk Edit Test.')
                    ->press('#edit-feedback button[type="submit"]')
                    ->waitForText('Data feedback berhasil diubah', 5)
                    ->assertSee('Ini pesan yang sudah diedit lewat Dusk Edit Test.');
        });
    }
}
