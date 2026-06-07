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

        $riwayatList = Riwayat::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $grafik = Riwayat::where('user_id', $user->id)
            ->selectRaw('DATE(created_at) as tanggal, count(*) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $artikels = Artikel::take(5)->get();

        return view('users.Dashboard.dashboard', compact('user', 'riwayatList', 'grafik', 'artikels'));
    }
}