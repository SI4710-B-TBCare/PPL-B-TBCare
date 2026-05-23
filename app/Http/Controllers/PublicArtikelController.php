<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class PublicArtikelController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $kategori = $request->input('kategori');

        $artikel = Artikel::when($kategori, function ($query, $kategori) {
                $query->where('kategori', $kategori);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('kode', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10);

        $artikel->appends(['search' => $search, 'kategori' => $kategori]);

        return view('artikel.index', compact('artikel', 'search', 'kategori'));
    }

    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('artikel.show', compact('artikel'));
    }
}