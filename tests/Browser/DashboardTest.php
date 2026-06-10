<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DashboardTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'PermissionTableSeeder']);
        $this->artisan('db:seed', ['--class' => 'CreateAdminUserSeeder']);
    }

    // TC-001: PBI #1 - Grafik Perkembangan TBC
    public function test_grafik_statistik_diagnosa_tampil()
    {
        $user = User::where('username', 'admin')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/panel/dashboard')
                ->assertSee('Statistik Hasil Diagnosa')
                ->assertPresent('#myAreaChart');
        });
    }

    // TC-002: PBI #2 - Log Activity Tampil
    public function test_log_activity_tampil()
    {
        $user = User::where('username', 'admin')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/panel/dashboard')
                ->assertSee('Log Activity');
        });
    }

    // TC-003: PBI #3 - Riwayat Diagnosa Tampil
    public function test_riwayat_diagnosa_tampil()
    {
        $user = User::where('username', 'admin')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/panel/dashboard')
                ->assertSee('Riwayat Diagnosa Terbaru');
        });
    }
}