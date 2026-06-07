<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
            ->waitFor('#username', 10)
            ->type('#username', 'admin')
            ->type('#password', 'admin123')
            ->press('Login')
            ->waitForLocation('/panel/dashboard')
            ->assertPathIs('/panel/dashboard')
            ->assertSee('Dashboard')
            ->screenshot('after-login');
        });
    }
}