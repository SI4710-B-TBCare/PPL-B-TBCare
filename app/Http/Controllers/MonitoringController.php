<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoring;

class MonitoringController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:monitoring-list', ['only' => ['index', 'history']]);
        $this->middleware('permission:monitoring-create', ['only' => ['store']]);
        $this->middleware('permission:monitoring-edit', ['only' => ['update', 'json']]);
        $this->middleware('permission:monitoring-delete', ['only' => ['destroy']]);
    }

    // PBI 9 - Menampilkan hasil lab
    public function index()
    {
        $monitoring = Monitoring::orderBy('tanggal', 'desc')->paginate(10);
        return view('admin.monitoring.index', compact('monitoring'));
    }

    // PBI 10 - Riwayat hasil lab
    public function history()
    {
        $monitoring = Monitoring::orderBy('tanggal', 'asc')->get();
        return view('admin.monitoring.history', compact('monitoring'));
    }

    // PBI 8 - Input data hasil lab
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'hasil_lab' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|string'
        ]);

        Monitoring::create($request->all());

        return back()->with('success', 'Data monitoring berhasil disimpan');
    }

    // Untuk ambil data (edit modal, dll)
    public function json()
    {
        $data = Monitoring::find(request('id'));
        return response()->json($data);
    }

    // Update data
    public function update(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'hasil_lab' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|string'
        ]);

        Monitoring::find($request->id)->update($request->all());

        return back()->with('success', 'Data monitoring berhasil diubah');
    }

    // Hapus data
    public function destroy(Monitoring $monitoring)
    {
        $monitoring->delete();
        return back()->with('success', 'Data monitoring berhasil dihapus');
    }
}