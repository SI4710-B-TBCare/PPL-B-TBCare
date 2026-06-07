<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::paginate(10);
        return view('admin.artikel.index', compact('artikel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string',
            'nama' => 'required|string',
        ]);

        Artikel::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        return back()->with('success', 'Data artikel berhasil ditambahkan');
    }

    public function json()
    {
        $data = Artikel::find(request('id'));
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'kode' => 'required|string',
            'nama' => 'required|string',
        ]);

        Artikel::where('id', $request->id)->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        return back()->with('success', 'Data artikel berhasil diubah');
    }

    public function destroy($id)
    {
        Artikel::find($id)->delete();
        return back()->with('success', 'Data artikel berhasil dihapus');
    }
}
