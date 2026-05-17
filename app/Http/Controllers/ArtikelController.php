<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:artikel-list',   ['only' => ['index']]);
        $this->middleware('permission:artikel-create', ['only' => ['store', 'generateKodeJson']]);
        $this->middleware('permission:artikel-edit',   ['only' => ['update', 'json']]);
        $this->middleware('permission:artikel-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $artikel = Artikel::paginate(10);

        return view('admin.artikel.index', compact('artikel'));
    }

    /**
     * Generate kode otomatis: ART-001, ART-002, dst
     */
    private function generateKode(): string
    {
        $last = Artikel::orderBy('id', 'desc')->first();

        if (!$last) {
            return 'ART-001';
        }

        // Ambil angka dari kode terakhir, misal "ART-023" => 23
        $lastNumber = (int) substr($last->kode, 4);
        $newNumber  = $lastNumber + 1;

        return 'ART-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Endpoint untuk generate kode via AJAX
     */
    public function generateKodeJson()
    {
        return response()->json(['kode' => $this->generateKode()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'isi'    => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('artikel', 'public');
        }

        Artikel::withoutEvents(function () use ($request, $gambarPath) {
            $artikel = new Artikel();
            $artikel->kode   = $this->generateKode();
            $artikel->nama   = $request->nama;
            $artikel->isi    = $request->isi;
            $artikel->gambar = $gambarPath;
            $artikel->save();
        });
        
        return back()->with('success', 'Data artikel berhasil disimpan');
    }

    public function json()
    {
        $data = Artikel::find(request('id'));

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'     => 'required|exists:artikels,id',
            'kode'   => 'required|string|max:50',
            'nama'   => 'required|string|max:255',
            'isi'    => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $artikel = Artikel::findOrFail($request->id);

        $gambarPath = $artikel->gambar; // pakai gambar lama jika tidak upload baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage
            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $gambarPath = $request->file('gambar')->store('artikel', 'public');
        }

        Artikel::withoutEvents(function () use ($artikel, $request, $gambarPath) {
            $artikel->kode   = $request->kode;
            $artikel->nama   = $request->nama;
            $artikel->isi    = $request->isi;
            $artikel->gambar = $gambarPath;
            $artikel->save();
        });

        return back()->with('success', 'Data artikel berhasil diubah');
    }

    public function destroy(Artikel $artikel)
    {
        // Hapus gambar dari storage jika ada
        if ($artikel->gambar) {
            Storage::disk('public')->delete($artikel->gambar);
        }

        $artikel->delete();

        return back()->with('success', 'Data artikel berhasil dihapus');
    }

    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('artikel.show', compact('artikel'));
    }
}