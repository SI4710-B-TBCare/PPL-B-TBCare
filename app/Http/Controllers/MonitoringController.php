<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{

    public function index()
    {
        $monitoring = Monitoring::where('user_id', Auth::id())
                        ->orderBy('tanggal', 'desc')
                        ->get();

        return view('monitoring.index', compact('monitoring'));
    }

    // Form input
    public function create()
    {
        return view('monitoring.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'hasil_lab' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|string'
        ]);

        Monitoring::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'hasil_lab' => $request->hasil_lab,
            'keterangan' => $request->keterangan,
            'status' => $request->status
        ]);

        return redirect('/monitoring')->with('success', 'Data berhasil disimpan');
    }

    // detail (opsional)
    public function show($id)
    {
        $data = Monitoring::where('user_id', Auth::id())
                    ->findOrFail($id);

        return view('monitoring.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Monitoring::findOrFail($id);
        return view('monitoring.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Monitoring::findOrFail($id);

        $data->update($request->all());

        return redirect('/monitoring')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = Monitoring::findOrFail($id);
        $data->delete();

        return redirect('/monitoring')->with('success', 'Data berhasil dihapus');
    }
}