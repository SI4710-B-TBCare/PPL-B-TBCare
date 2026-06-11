<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FasilitasKesehatan;

class FasilitasKesehatanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:fasilitasKesehatan-list', ['only' => ['index']]);
        $this->middleware('permission:fasilitasKesehatan-create', ['only' => ['store']]);
        $this->middleware('permission:fasilitasKesehatan-edit', ['only' => ['update', 'json']]);
        $this->middleware('permission:fasilitasKesehatan-delete', ['only' => ['destroy']]);
    }

    /**
     * PBI #19 - Menampilkan daftar fasilitas penanganan TBC
     */
    public function index(Request $request)
    {
        $query = FasilitasKesehatan::query();

        // Filter pencarian nama / kode
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan jenis fasilitas (kategori)
        if ($request->filled('jenis_fasilitas')) {
            $query->where('jenis_fasilitas', $request->jenis_fasilitas);
        }

        // Filter berdasarkan kota
        if ($request->filled('kota')) {
            $query->where('kota', 'like', "%{$request->kota}%");
        }

        $fasilitasKesehatan = $query->paginate(10)->withQueryString();

        // Data untuk dropdown filter
        $daftarJenis = FasilitasKesehatan::select('jenis_fasilitas')
            ->whereNotNull('jenis_fasilitas')
            ->distinct()
            ->orderBy('jenis_fasilitas')
            ->pluck('jenis_fasilitas');

        $daftarKota = FasilitasKesehatan::select('kota')
            ->whereNotNull('kota')
            ->distinct()
            ->orderBy('kota')
            ->pluck('kota');

        return view('admin.fasilitasKesehatan.index', compact('fasilitasKesehatan', 'daftarJenis', 'daftarKota'));
    }

    /**
     * PBI #18 - Create fasilitas penanganan TBC
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode'             => 'required|string|max:255',
            'nama'             => 'required|string|max:255',
            'penyebab'         => 'required|string',
            'jenis_fasilitas'  => 'nullable|string|max:255',
            'alamat'           => 'nullable|string',
            'kota'             => 'nullable|string|max:255',
            'no_telepon'       => 'nullable|string|max:50',
            'jam_operasional'  => 'nullable|string|max:255',
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
            'id'               => 'required|exists:fasilitas_kesehatan,id',
            'kode'             => 'required|string|max:255',
            'nama'             => 'required|string|max:255',
            'penyebab'         => 'required|string',
            'jenis_fasilitas'  => 'nullable|string|max:255',
            'alamat'           => 'nullable|string',
            'kota'             => 'nullable|string|max:255',
            'no_telepon'       => 'nullable|string|max:50',
            'jam_operasional'  => 'nullable|string|max:255',
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
    }
}
