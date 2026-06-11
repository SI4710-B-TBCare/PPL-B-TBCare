<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoring;
use App\Models\PerkembanganKesehatan;
use Illuminate\Support\Facades\Auth;

class PerkembanganKesehatanController extends Controller
{
    /**
     * Menampilkan daftar perkembangan kesehatan
     */
    public function index($monitoring_id)
    {
        $monitoring = Monitoring::findOrFail($monitoring_id);

        $perkembangan = PerkembanganKesehatan::where(
                'monitoring_id',
                $monitoring_id
            )
            ->orderBy('tanggal', 'desc')
            ->get();

        return view(
            'admin.monitoring.perkembangan',
            compact(
                'monitoring',
                'perkembangan'
            )
        );
    }

    /**
     * Simpan catatan perkembangan kesehatan
     */
    public function store(Request $request)
    {
        $request->validate([
            'monitoring_id' => 'required|exists:monitorings,id',
            'tanggal' => 'required|date',
            'catatan' => 'required|string'
        ]);

        $monitoring = Monitoring::findOrFail(
            $request->monitoring_id
        );

        /**
         * User hanya boleh menambah
         * perkembangan miliknya sendiri
         */
        if ($monitoring->user_id != Auth::id()) {

            abort(403);
        }

        PerkembanganKesehatan::create([
            'monitoring_id' => $request->monitoring_id,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan
        ]);

        return back()->with(
            'success',
            'Catatan perkembangan kesehatan berhasil ditambahkan'
        );
    }

    /**
     * Ambil data perkembangan untuk modal edit
     */
    public function json()
    {
        $data = PerkembanganKesehatan::find(
            request('id')
        );

        return response()->json($data);
    }

    /**
     * Update perkembangan kesehatan
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'tanggal' => 'required|date',
            'catatan' => 'required|string'
        ]);

        $perkembangan = PerkembanganKesehatan::findOrFail(
            $request->id
        );

        $monitoring = Monitoring::findOrFail(
            $perkembangan->monitoring_id
        );

        if ($monitoring->user_id != Auth::id()) {

            abort(403);
        }

        $perkembangan->update([
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan
        ]);

        return back()->with(
            'success',
            'Catatan perkembangan berhasil diperbarui'
        );
    }

    /**
     * Hapus perkembangan kesehatan
     */
    public function destroy(
        PerkembanganKesehatan $perkembangan
    )
    {
        $monitoring = Monitoring::findOrFail(
            $perkembangan->monitoring_id
        );

        if ($monitoring->user_id != Auth::id()) {

            abort(403);
        }

        $perkembangan->delete();

        return back()->with(
            'success',
            'Catatan perkembangan berhasil dihapus'
        );
    }
}