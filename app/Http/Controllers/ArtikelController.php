<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:artikel-list', ['only' => ['index']]);
         $this->middleware('permission:artikel-create', ['only' => ['store']]);
         $this->middleware('permission:artikel-edit', ['only' => ['update', 'json']]);
         $this->middleware('permission:artikel-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $artikel = Artikel::paginate(10);

        return view('admin.artikel.index', compact('artikel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required'
        ]);

        $data = $request->all();

        Artikel::create($data);

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
            'kode' => 'required',
            'nama' => 'required'
        ]);

        $data = $request->all();

        Artikel::find($request->id)->update($data);

        return back()->with('success', 'Data artikel berhasil diubah');
    }

    public function destroy(Artikel $artikel)
    {
        $artikel->delete();
        return back()->with('success', 'Data artikel berhasil dihapus');
    }
}
