<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Riwayat;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // PBI #3 - Riwayat Kuesioner
        $riwayatList = Riwayat::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // PBI #1 - Data Grafik Perkembangan TBC
        $grafik = Riwayat::where('user_id', $user->id)
            ->selectRaw('DATE(created_at) as tanggal, count(*) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // PBI #2 - Artikel Terbaru
        $artikels = Artikel::latest()->take(5)->get();

        return view('user.dashboard', compact('user', 'riwayatList', 'grafik', 'artikels'));
    }
}