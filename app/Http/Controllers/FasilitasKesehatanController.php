<?php

namespace App\Http\Controllers;

use App\Models\FasilitasKesehatan;
use Illuminate\Http\Request;

class FasilitasKesehatanController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:fasilitasKesehatan-list', ['only' => ['index']]);
         $this->middleware('permission:fasilitasKesehatan-create', ['only' => ['store']]);
         $this->middleware('permission:fasilitasKesehatan-edit', ['only' => ['update', 'json']]);
         $this->middleware('permission:fasilitasKesehatan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $fasilitasKesehatan = FasilitasKesehatan::all();

        return view('admin.fasilitasKesehatan.index', compact('fasilitasKesehatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'penyebab' => 'required'
        ]);

        $data = $request->all();

        FasilitasKesehatan::create($data);

        return back()->with('success', 'Data fasilitas kesehatan berhasil disimpan');
    }

    public function json()
    {
        $data = FasilitasKesehatan::find(request('id'));

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'penyebab' => 'required'
        ]);

        $data = $request->all();

        FasilitasKesehatan::find($request->id)->update($data);

        return back()->with('success', 'Data fasilitas kesehatan berhasil diubah');
    }

    public function destroy(FasilitasKesehatan $fasilitasKesehatan)
    {
        $fasilitasKesehatan->delete();
        return back()->with('success', 'Data fasilitas kesehatan berhasil dihapus');
    }
}
