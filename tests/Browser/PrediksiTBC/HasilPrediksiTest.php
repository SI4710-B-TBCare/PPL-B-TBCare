<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Spatie\Permission\PermissionRegistrar;


class HasilPrediksiTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testUserCanViewResult()
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
                    el.selectedIndex = 7;
                });
            ");

            $browser->press('Prediksi sekarang')
                ->pause(3000)
                ->assertSee('Hasil diagnosa')
                ->assertSee('Gejala yang kamu alami saat ini')
                ->assertSee('Tabel perhitungan penyakit: Tuberkulosis (TBC) (P001)')            
                ->assertSee('Kesimpulan')            
                ->screenshot('after-submit-form');
                
        });
    }
}
