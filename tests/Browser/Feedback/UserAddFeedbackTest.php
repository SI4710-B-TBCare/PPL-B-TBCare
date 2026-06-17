<?php

namespace Tests\Browser\Feedback;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserAddFeedbackTest extends DuskTestCase
{
    /**
     * Test user can add feedback.
     */
    public function testUserCanAddFeedback(): void
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
                    ->assertSee('Tambahkan Feedback')
                    ->click('.add')
                    ->waitFor('#feedback', 5)
                    ->pause(1000)
                    ->type('#feedback input[name="nama"]', 'Test Nama Tambah Dusk')
                    ->type('#feedback input[name="email"]', 'tambahdusk@example.com')
                    ->type('#feedback textarea[name="pesan"]', 'Ini adalah pesan tambah test dari Laravel Dusk.')
                    ->press('#feedback button[type="submit"]')
                    ->waitForText('Data feedback berhasil ditambahkan', 5)
                    ->assertSee('Test Nama Tambah Dusk');
        });
    }
}
