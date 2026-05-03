
<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function index()
    {
        $monitoring = Monitoring::where('user_id', Auth::id())->paginate(10);
        return view('monitoring.index', compact('monitoring'));
    }

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

        return redirect()->back()->with('success', 'Data hasil lab berhasil disimpan');
    }

    public function show($id)
    {
        $data = Monitoring::findOrFail($id);
        return view('monitoring.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Monitoring::findOrFail($id);
        return view('monitoring.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'hasil_lab' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|string'
        ]);

        $data = Monitoring::findOrFail($id);

        $data->update([
            'tanggal' => $request->tanggal,
            'hasil_lab' => $request->hasil_lab,
            'keterangan' => $request->keterangan,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = Monitoring::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}