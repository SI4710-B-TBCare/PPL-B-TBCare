<?php

namespace Tests\Browser\Feedback;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminDeleteFeedbackTest extends DuskTestCase
{
    /**
     * Test admin can delete feedback.
     */
    public function testAdminCanDeleteFeedback(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('#username', 10)
                    ->type('#username', 'admin')
                    ->type('#password', 'admin123')
                    ->press('Login')
                    ->waitForLocation('/admin/dashboard', 10);

            $browser->visit('/admin/feedback')
                    ->assertSee('Daftar Feedback')
                    ->click('.delete')
                    ->waitForText('Hapus feedback?', 5)
                    ->pause(500)
                    ->press('Ya, hapus!')
                    ->waitForText('Data feedback berhasil dihapus', 5);
        });
    }
}
