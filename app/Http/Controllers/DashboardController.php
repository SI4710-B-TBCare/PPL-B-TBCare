<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\TbPrediction;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\SettingRequest;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $logs = Activity::where('causer_id', auth()->id())->latest()->paginate(5);
        $riwayat = TbPrediction::select(
            DB::raw("COUNT(id) as total"),
            DB::raw("DATE_FORMAT(created_at, '%d %M') as days"),
            DB::raw("MIN(created_at) as min_date")
        )
        ->where('created_at', '>=', Carbon::now()->subDays(7))
        ->groupBy('days')->orderBy('min_date', 'asc')->get();

        $riwayatList = TbPrediction::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $sebaranWilayah = User::select('provinsi', DB::raw('count(*) as total'))
            ->whereNotNull('provinsi')
            ->where('role', 'user')
            ->groupBy('provinsi')
            ->orderByDesc('total')
            ->get();

        $totalUser = User::where('role', 'user')->count();

        return view('admin.dashboard', compact('logs', 'riwayat', 'riwayatList', 'sebaranWilayah', 'totalUser'));
    }

    public function activity_logs()
    {
        $logs = Activity::where('causer_id', auth()->id())->latest()->paginate(10);
        return view('admin.logs', compact('logs'));
    }

    public function delete_logs()
    {
        $logs = Activity::where('created_at', '<=', Carbon::now()->subWeeks())->delete();
        return back()->with('success', $logs.' Logs successfully deleted!');
    }

    public function settings_store(SettingRequest $request)
    {
        if($request->file('logo')) {
            $filename = $request->file('logo')->getClientOriginalName();
            $filePath = $request->file('logo')->storeAs('uploads', $filename, 'public');
            setting()->set('logo', $filePath);
        }

        setting()->set('site_name', $request->site_name);
        setting()->set('keyword', $request->keyword);
        setting()->set('description', $request->description);
        setting()->set('url', $request->url);
        setting()->save();

        return redirect()->back()->with('success', 'Settings has been successfully saved');
    }

    public function profile_update(Request $request)
    {
        $data = ['name' => $request->name];

        if($request->old_password && $request->new_password) {
            if(!Hash::check($request->old_password, auth()->user()->password)) {
                session()->flash('failed', 'Password is wrong!');
                return redirect()->back();
            }
            $data['password'] = Hash::make($request->new_password);
        }

        if($request->avatar) {
            $data['avatar'] = $request->avatar;
            if(auth()->user()->avatar) {
                unlink(storage_path('app/public/'.auth()->user()->avatar));
            }
        }

        auth()->user()->update($data);
        return redirect()->back()->with('success', 'Profile updated!');
    }

    public function upload_avatar(Request $request)
    {
        $request->validate(['avatar' => 'file|image|mimes:jpg,png,svg|max:1024']);

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $fileName = $file->getClientOriginalName();
            $folder = 'user-'.auth()->id();
            $file->storeAs('avatars/'.$folder, $fileName, 'public');
            return 'avatars/'.$folder.'/'.$fileName;
        }

        return '';
    }
}