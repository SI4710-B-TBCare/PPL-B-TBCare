<?php

namespace Tests\Browser;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ArtikelKategoriTest extends DuskTestCase
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

    public function testTambahArtikelDenganKategori()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsAdmin($browser);

            $browser->visit('/panel/artikel')
                    ->click('.add')
                    ->waitFor('#artikel.show', 5)
                    ->within('#artikel', function (Browser $modal) {
                        $modal->type('input[name="nama"]', 'Artikel Kategori Pencegahan')
                              ->select('select[name="kategori"]', 'Pencegahan')
                              ->type('textarea[name="isi"]', 'Isi artikel pencegahan');
                    })
                    ->press('Simpan')
                    ->waitForReload()
                    ->assertSee('Artikel Kategori Pencegahan')
                    ->assertSee('Pencegahan');

            $this->assertDatabaseHas('artikels', [
                'nama'     => 'Artikel Kategori Pencegahan',
                'kategori' => 'Pencegahan',
            ]);
        });
    }

    public function testUpdateKategoriArtikel()
    {
        $artikel = Artikel::create([
            'kode'     => 'ART-001',
            'nama'     => 'Artikel Lama',
            'kategori' => 'Umum',
            'isi'      => 'Isi artikel lama',
            'gambar'   => null,
        ]);

        $this->browse(function (Browser $browser) use ($artikel) {
            $this->loginAsAdmin($browser);

            $browser->visit('/panel/artikel')
                    ->click(".edit[data-id='{$artikel->id}']")
                    ->waitFor('#edit-artikel.show', 5)
                    ->within('#edit-artikel', function (Browser $modal) {
                        $modal->select('select[name="kategori"]', 'Pengobatan')
                              ->press('Simpan');
                    })
                    ->waitForReload()
                    ->assertSee('Pengobatan')
                    ->assertSee('Data artikel berhasil diubah');

            $this->assertDatabaseHas('artikels', [
                'id'       => $artikel->id,
                'kategori' => 'Pengobatan',
            ]);
        });
    }

    public function testFilterKategoriArtikelAdmin()
    {
        Artikel::create([
            'kode' => 'ART-001', 'nama' => 'Artikel Gejala',
            'kategori' => 'Gejala', 'isi' => 'Isi gejala', 'gambar' => null,
        ]);
        Artikel::create([
            'kode' => 'ART-002', 'nama' => 'Artikel Pengobatan',
            'kategori' => 'Pengobatan', 'isi' => 'Isi pengobatan', 'gambar' => null,
        ]);

        $this->browse(function (Browser $browser) {
            $this->loginAsAdmin($browser);

            $browser->visit('/panel/artikel')
                    ->select('select[name="kategori"]', 'Gejala')
                    ->waitForReload()
                    ->assertSee('Artikel Gejala')
                    ->assertDontSee('Artikel Pengobatan');
        });
    }
}