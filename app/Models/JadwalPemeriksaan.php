<?php

namespace App\Http\Controllers;

use App\Models\JadwalPemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPemeriksaanController extends Controller
{
    /**
     * Menampilkan daftar jadwal milik user
     */
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

    /**
     * Simpan jadwal baru
     */
    public function store(Request $request)
    {
        $request->validate([

            'jenis_pemeriksaan' => 'required|string|max:255',

            'tanggal_pemeriksaan' => 'required|date',

            'lokasi' => 'required|string|max:255',

            'catatan' => 'nullable|string'

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
                $request->catatan,

            'status' => 'menunggu'

        ]);

        return back()->with(
            'success',
            'Jadwal berhasil dibuat'
        );
    }

    /**
     * Ambil data untuk modal edit
     */
    public function json(Request $request)
    {
        $jadwal = JadwalPemeriksaan::where(
            'id',
            $request->id
        )
        ->where(
            'user_id',
            Auth::id()
        )
        ->firstOrFail();

        return response()->json($jadwal);
    }

    /**
     * Update jadwal
     */
    public function update(Request $request)
    {
        $request->validate([

            'jenis_pemeriksaan' => 'required|string|max:255',

            'tanggal_pemeriksaan' => 'required|date',

            'lokasi' => 'required|string|max:255',

            'catatan' => 'nullable|string'

        ]);

        $jadwal = JadwalPemeriksaan::where(
            'id',
            $request->id
        )
        ->where(
            'user_id',
            Auth::id()
        )
        ->firstOrFail();

        $jadwal->update([

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
            'Jadwal berhasil diperbarui'
        );
    }

    /**
     * Hapus jadwal
     */
    public function destroy($id)
    {
        $jadwal = JadwalPemeriksaan::where(
            'id',
            $id
        )
        ->where(
            'user_id',
            Auth::id()
        )
        ->firstOrFail();

        $jadwal->delete();

        return back()->with(
            'success',
            'Jadwal berhasil dihapus'
        );
    }
}