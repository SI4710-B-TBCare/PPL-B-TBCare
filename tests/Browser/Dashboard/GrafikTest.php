<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Spatie\Permission\PermissionRegistrar;


class GrafikTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testUserCanViewGraph()
    {
        $this->browse(function (Browser $browser) {

            $user = \App\Models\User::factory()->create();
            $user->assignRole('Admin');

            // 🔥 penting banget
            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            $browser->loginAs($user)

                ->visit('/panel/diagnosa')

                ->waitFor('input[name=nama]', 10) // sekarang harusnya muncul
                ->type('nama', 'Sultan');

            // isi diagnosa
            $browser->script("
                document.querySelectorAll('select[name=\"diagnosa[]\"]').forEach(el => {
                    el.selectedIndex = 1;
                });
            ");

            $browser->press('Prediksi sekarang')
                ->pause(3000)
                ->visit('/panel/dashboard')
                ->assertSee('Statistik Hasil Diagnosa')
                ->screenshot('after-view-dashboard');
                
        });
    }
}
