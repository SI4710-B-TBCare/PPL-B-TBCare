<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MonitoringController extends Controller
{
    public function __construct()
    {
        $this->middleware(
        'permission:monitoring-list',
        ['only' => ['index']]
    );

        $this->middleware(
        'permission:monitoring-edit',
        ['only' => ['update', 'json']]
    );
    }

    /**
     * Admin melihat seluruh monitoring user
     */
    public function index()
    {
        $monitoring = Monitoring::with('user')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('admin.monitoring.index', compact('monitoring'));
    }

    /**
     * User melihat riwayat monitoring miliknya
     */
    public function history()
    {
        $monitoring = Monitoring::where('user_id', Auth::id())
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('admin.monitoring.history', compact('monitoring'));
    }
    /**
     * Simpan monitoring baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'hasil_lab' => 'required|string|max:255',
            'file_hasil_lab' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
            'status' => 'required|string'
        ]);

        $filePath = null;

        if ($request->hasFile('file_hasil_lab')) {

            $filePath = $request->file('file_hasil_lab')
                ->store('hasil_lab', 'public');
        }

        Monitoring::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'hasil_lab' => $request->hasil_lab,
            'file_hasil_lab' => $filePath,
            'keterangan' => $request->keterangan,
            'status' => $request->status
        ]);

        return back()->with(
            'success',
            'Data monitoring berhasil disimpan'
        );
    }

    /**
     * Ambil data monitoring untuk modal edit
     */
    public function json()
    {
        $data = Monitoring::find(request('id'));

        return response()->json($data);
    }

    /**
     * Update monitoring
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'hasil_lab' => 'required|string|max:255',
            'file_hasil_lab' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
            'status' => 'required|string'
        ]);

        $monitoring = Monitoring::findOrFail($request->id);

        $data = [
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'hasil_lab' => $request->hasil_lab,
            'keterangan' => $request->keterangan,
            'status' => $request->status
        ];

        if ($request->hasFile('file_hasil_lab')) {

            if ($monitoring->file_hasil_lab) {

                Storage::disk('public')
                    ->delete($monitoring->file_hasil_lab);
            }

            $data['file_hasil_lab'] = $request->file('file_hasil_lab')
                ->store('hasil_lab', 'public');
        }

        $monitoring->update($data);

        return back()->with(
            'success',
            'Data monitoring berhasil diubah'
        );
    }

    public function download($id)
{
    $monitoring = Monitoring::findOrFail($id);

    if (!$monitoring->file_hasil_lab) {
        return back()->with('error', 'File tidak ditemukan');
    }

    return Storage::disk('public')
        ->download($monitoring->file_hasil_lab);
}

    /**
     * Hapus monitoring
     */
    public function destroy(Monitoring $monitoring)
    {
        if ($monitoring->file_hasil_lab) {

            Storage::disk('public')
                ->delete($monitoring->file_hasil_lab);
        }

        $monitoring->delete();

        return back()->with(
            'success',
            'Data monitoring berhasil dihapus'
        );
    }
}