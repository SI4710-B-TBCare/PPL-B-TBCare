<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\FasilitasKesehatan;
use Illuminate\Http\Request;
=======
use Illuminate\Http\Request;
use App\Models\FasilitasKesehatan;
>>>>>>> origin/testMonitoring

class FasilitasKesehatanController extends Controller
{
    function __construct()
    {
<<<<<<< HEAD
         $this->middleware('permission:fasilitasKesehatan-list', ['only' => ['index']]);
         $this->middleware('permission:fasilitasKesehatan-create', ['only' => ['store']]);
         $this->middleware('permission:fasilitasKesehatan-edit', ['only' => ['update', 'json']]);
         $this->middleware('permission:fasilitasKesehatan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $fasilitasKesehatan = FasilitasKesehatan::all();
=======
        $this->middleware('permission:fasilitasKesehatan-list', ['only' => ['index']]);
        $this->middleware('permission:fasilitasKesehatan-create', ['only' => ['store']]);
        $this->middleware('permission:fasilitasKesehatan-edit', ['only' => ['update', 'json']]);
        $this->middleware('permission:fasilitasKesehatan-delete', ['only' => ['destroy']]);
    }

    /**
     * PBI #19 - Menampilkan daftar fasilitas penanganan TBC
     */
    public function index()
    {
        $fasilitasKesehatan = FasilitasKesehatan::paginate(10);
>>>>>>> origin/testMonitoring

        return view('admin.fasilitasKesehatan.index', compact('fasilitasKesehatan'));
    }

<<<<<<< HEAD
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
=======
    /**
     * PBI #18 - Create fasilitas penanganan TBC
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode'     => 'required|string|max:255',
            'nama'     => 'required|string|max:255',
            'penyebab' => 'required|string',
        ]);

        FasilitasKesehatan::create($request->all());

        return back()->with('success', 'Fasilitas penanganan berhasil ditambahkan');
    }

    /**
     * Mengembalikan data JSON untuk modal edit (AJAX)
     */
    public function json(Request $request)
    {
        $fasilitas = FasilitasKesehatan::findOrFail($request->id);

        return response()->json($fasilitas);
    }

    /**
     * PBI #20 - Update fasilitas penanganan TBC
     */
    public function update(Request $request)
    {
        $request->validate([
            'id'       => 'required|exists:fasilitas_kesehatan,id',
            'kode'     => 'required|string|max:255',
            'nama'     => 'required|string|max:255',
            'penyebab' => 'required|string',
        ]);

        $fasilitas = FasilitasKesehatan::findOrFail($request->id);
        $fasilitas->update($request->all());

        return back()->with('success', 'Fasilitas penanganan berhasil diperbarui');
    }

    /**
     * PBI #21 - Delete fasilitas penanganan TBC
     */
    public function destroy(FasilitasKesehatan $fasilitasKesehatan)
    {
        $fasilitasKesehatan->delete();

        return back()->with('success', 'Fasilitas kesehatan berhasil dihapus');
>>>>>>> origin/testMonitoring
    }
}
