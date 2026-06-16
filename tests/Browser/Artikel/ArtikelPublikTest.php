<?php

namespace Tests\Browser;

use App\Models\Artikel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ArtikelPublikTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testHalamanPublikArtikelTampil()
    {
        Artikel::create([
            'kode'     => 'ART-001',
            'nama'     => 'Artikel Publik Test',
            'kategori' => 'Umum',
            'isi'      => 'Isi artikel publik test',
            'gambar'   => null,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/artikel')
                    ->assertPathIs('/artikel')
                    ->assertSee('Daftar Artikel TBCare')
                    ->assertSee('Artikel Publik Test')
                    ->assertSee('Semua')
                    ->assertSee('Pencegahan')
                    ->assertSee('Pengobatan')
                    ->assertSee('Gejala')
                    ->assertSee('Umum');
        });
    }

    public function testSearchArtikelPublik()
    {
        Artikel::create([
            'kode' => 'ART-001', 'nama' => 'Cara Mencegah TBC',
            'kategori' => 'Pencegahan', 'isi' => 'Isi pencegahan', 'gambar' => null,
        ]);
        Artikel::create([
            'kode' => 'ART-002', 'nama' => 'Pengobatan TBC Modern',
            'kategori' => 'Pengobatan', 'isi' => 'Isi pengobatan', 'gambar' => null,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/artikel')
                    ->type('input[name="search"]', 'Mencegah')
                    ->press('Cari')
                    ->waitForReload()
                    ->assertSee('Cara Mencegah TBC')
                    ->assertDontSee('Pengobatan TBC Modern');
        });
    }

    public function testFilterKategoriArtikelPublik()
    {
        Artikel::create([
            'kode' => 'ART-001', 'nama' => 'Artikel Gejala TBC',
            'kategori' => 'Gejala', 'isi' => 'Isi gejala', 'gambar' => null,
        ]);
        Artikel::create([
            'kode' => 'ART-002', 'nama' => 'Artikel Pengobatan TBC',
            'kategori' => 'Pengobatan', 'isi' => 'Isi pengobatan', 'gambar' => null,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/artikel')
                    ->clickLink('Gejala')
                    ->waitForReload()
                    ->assertSee('Artikel Gejala TBC')
                    ->assertDontSee('Artikel Pengobatan TBC');
        });
    }

    public function testDetailArtikelPublik()
    {
        $artikel = Artikel::create([
            'kode'     => 'ART-001',
            'nama'     => 'Detail Artikel TBC',
            'kategori' => 'Umum',
            'isi'      => 'Ini adalah isi lengkap artikel TBC',
            'gambar'   => null,
        ]);

        $this->browse(function (Browser $browser) use ($artikel) {
            $browser->visit('/artikel')
                    ->clickLink('Baca Selengkapnya')
                    ->waitForLocation('/artikel/' . $artikel->id)
                    ->assertSee('Detail Artikel TBC')
                    ->assertSee('Ini adalah isi lengkap artikel TBC')
                    ->assertSee('Kembali');
        });
    }
}