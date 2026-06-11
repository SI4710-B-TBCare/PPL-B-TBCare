<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $sebaranWilayah = User::select('provinsi', DB::raw('count(*) as total'))
            ->whereNotNull('provinsi')
            ->where('role', 'user')
            ->groupBy('provinsi')
            ->orderByDesc('total')
            ->get();

        $totalUser = User::where('role', 'user')->count();

        return view('admin.dashboard.index', compact('sebaranWilayah', 'totalUser'));
    }
}