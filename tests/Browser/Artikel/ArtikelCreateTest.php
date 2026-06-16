<?php

namespace Tests\Browser;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ArtikelCreateTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $permissions = ['artikel-list', 'artikel-create', 'artikel-edit', 'artikel-delete'];
        foreach ($permissions as $perm) {
            $p = Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
            $role->givePermissionTo($p);
        }

        $user = User::factory()->create([
            'name'     => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('admin');
    }

    protected function loginAsAdmin(Browser $browser): void
    {
        $browser->visit('/login')
                ->type('username', 'admin')
                ->type('password', 'password')
                ->press('Login')
                ->waitForLocation('/panel/dashboard');
    }

    public function testHalamanDaftarArtikelTampil()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsAdmin($browser);

            $browser->visit('/panel/artikel')
                    ->assertPathIs('/panel/artikel')
                    ->assertSee('Daftar Artikel')
                    ->assertPresent('table');
        });
    }

    public function testModalTambahArtikelDanGenerateKode()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsAdmin($browser);

            $browser->visit('/panel/artikel')
                    ->click('.add')
                    ->waitFor('#artikel.show', 5)
                    ->assertVisible('#artikel')
                    ->assertSee('Tambahkan Artikel')
                    ->assertInputValueIsNot('input[name="kode"]', '');
        });
    }

    public function testTambahArtikelBaru()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsAdmin($browser);

            $browser->visit('/panel/artikel')
                    ->click('.add')
                    ->waitFor('#artikel.show', 5)
                    ->within('#artikel', function (Browser $modal) {
                        $modal->type('input[name="nama"]', 'Artikel Test Otomatis')
                              ->select('select[name="kategori"]', 'Umum')
                              ->type('textarea[name="isi"]', 'Ini adalah isi artikel test');
                    })
                    ->press('Simpan')
                    ->waitForReload()
                    ->assertSee('Artikel Test Otomatis')
                    ->assertSee('Data artikel berhasil disimpan');

            $this->assertDatabaseHas('artikels', [
                'nama' => 'Artikel Test Otomatis',
            ]);
        });
    }

    public function testTambahArtikelTanpaNamaGagal()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsAdmin($browser);

            $browser->visit('/panel/artikel')
                    ->click('.add')
                    ->waitFor('#artikel.show', 5)
                    ->within('#artikel', function (Browser $modal) {
                        $modal->select('select[name="kategori"]', 'Umum')
                              ->press('Simpan');
                    })
                    ->waitForReload();

            $this->assertDatabaseMissing('artikels', [
                'nama' => '',
            ]);
        });
    }
}