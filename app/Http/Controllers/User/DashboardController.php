<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\TbPrediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');

        $riwayatList = TbPrediction::where('user_id', $user->id)
            ->when($search, function($query) use ($search) {
                $query->where('risk_level', 'like', '%'.$search.'%');
            })
            ->latest()
            ->take(5)
            ->get();

        $grafik = TbPrediction::where('user_id', $user->id)
            ->selectRaw('DATE(created_at) as tanggal, count(*) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $artikels = Artikel::when($search, function($query) use ($search) {
                $query->where('nama', 'like', '%'.$search.'%');
            })
            ->take(5)
            ->get();

        return view('users.Dashboard.dashboard', compact('user', 'riwayatList', 'grafik', 'artikels', 'search'));
    }
}