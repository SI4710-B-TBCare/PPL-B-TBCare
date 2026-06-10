<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:monitoring-list', ['only' => ['index', 'history']]);
        $this->middleware('permission:monitoring-create', ['only' => ['store']]);
        $this->middleware('permission:monitoring-edit', ['only' => ['update', 'json']]);
        $this->middleware('permission:monitoring-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        $monitoring = Monitoring::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('admin.monitoring.index', compact('monitoring'));
    }


    public function history()
    {
        $monitoring = Monitoring::where('user_id', Auth::id())
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('admin.monitoring.history', compact('monitoring'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'tanggal' => 'required|date',
            'hasil_lab' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|string'
        ]);

        Monitoring::create([
            'user_id' => auth()->id(),
            'nama' => $request->nama, 
            'tanggal' => $request->tanggal,
            'hasil_lab' => $request->hasil_lab,
            'keterangan' => $request->keterangan,
            'status' => $request->status
        ]);

        return back()->with('success', 'Data monitoring berhasil disimpan');
    }
    

    public function json()
    {
        $data = Monitoring::where('id', request('id'))
            ->where('user_id', Auth::id())
            ->first();

        return response()->json($data);
    }


    public function update(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'hasil_lab' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|string'
        ]);

        Monitoring::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->update([
                'tanggal' => $request->tanggal,
                'hasil_lab' => $request->hasil_lab,
                'keterangan' => $request->keterangan,
                'status' => $request->status
            ]);

        return back()->with('success', 'Data monitoring berhasil diubah');
    }


    public function destroy(Monitoring $monitoring)
    {
        if ($monitoring->user_id == Auth::id()) {
            $monitoring->delete();
        }

        return back()->with('success', 'Data monitoring berhasil dihapus');
    }
}