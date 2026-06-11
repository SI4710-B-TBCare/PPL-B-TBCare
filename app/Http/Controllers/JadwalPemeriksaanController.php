<?php

namespace App\Http\Controllers;

use App\Models\JadwalPemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPemeriksaanController extends Controller
{
    public function index()
    {
        $jadwal = JadwalPemeriksaan::where(
            'user_id',
            Auth::id()
        )
        ->latest()
        ->paginate(10);

        return view(
            'admin.jadwal.index',
            compact('jadwal')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'jenis_pemeriksaan' => 'required',

            'tanggal_pemeriksaan' => 'required|date',

            'lokasi' => 'required'

        ]);

        JadwalPemeriksaan::create([

            'user_id' => Auth::id(),

            'jenis_pemeriksaan' =>
                $request->jenis_pemeriksaan,

            'tanggal_pemeriksaan' =>
                $request->tanggal_pemeriksaan,

            'lokasi' =>
                $request->lokasi,

            'catatan' =>
                $request->catatan

        ]);

        return back()->with(
            'success',
            'Jadwal berhasil dibuat'
        );
    }

    public function update(Request $request)
    {
        $jadwal = JadwalPemeriksaan::findOrFail(
            $request->id
        );

        $jadwal->update([

            'status' => $request->status

        ]);

        return back()->with(
            'success',
            'Status jadwal berhasil diubah'
        );
    }

    public function destroy($id)
    {
        JadwalPemeriksaan::findOrFail($id)
            ->delete();

        return back()->with(
            'success',
            'Jadwal berhasil dihapus'
        );
    }
}