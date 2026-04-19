<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\{FasilitasKesehatan, Artikel};
use Illuminate\Http\Request;

class RuleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:rules-list', ['only' => ['index']]);
         $this->middleware('permission:rules-edit', ['only' => ['update']]);
    }

    public function index($id)
    {
        $fasilitasKesehatan = FasilitasKesehatan::select('nama', 'id')->get();
        $artikel = Artikel::all();
        $data_fasilitasKesehatan = FasilitasKesehatan::find($id);
        $artikel_fasilitasKesehatan = $data_fasilitasKesehatan->artikels();
        $artikel_id = $artikel_fasilitasKesehatan->pluck('artikel_id')->toArray();

        return view('admin.rules.index', compact('data_fasilitasKesehatan', 'fasilitasKesehatan', 'artikel', 'artikel_fasilitasKesehatan', 'artikel_id'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $fasilitasKesehatan_list = DB::table('artikel_fasilitas_kesehatan')->where(['fasilitas_kesehatan_id' => $id])->get();

        $artikel_list = [];
        $enabled = 0;
        $disabled = 0;
        $changed = 0;

        foreach($input as $key => $value) {
            if(str_contains($key, 'artikel')) {
                $artikel_id = explode('-', $key)[1];

                $artikel_fasilitasKesehatan = DB::table('artikel_fasilitas_kesehatan')
                    ->where(['fasilitas_kesehatan_id' => $id, 'artikel_id' => $artikel_id]);

                if(count($artikel_fasilitasKesehatan->get()) == 0) {
                    DB::table('artikel_fasilitas_kesehatan')
                        ->insert([
                            'fasilitas_kesehatan_id' => $id, 
                            'artikel_id' => $artikel_id, 
                            'value_cf' => $value
                        ]);
                } else {
                    if($artikel_fasilitasKesehatan->first()->value_cf != $value) {
                        $artikel_fasilitasKesehatan->update(['value_cf' => $value]);
                        $changed++;
                    }
                }

                array_push($artikel_list, $artikel_id);
                $enabled++;
            }
        }


        foreach($fasilitasKesehatan_list as $fk) {
            if(!in_array($fk->artikel_id, $artikel_list)) {
                $data = DB::table('artikel_fasilitas_kesehatan')
                    ->where(['fasilitas_kesehatan_id' => $id, 'artikel_id' => $fk->artikel_id])
                    ->first();

                DB::table('artikel_fasilitas_kesehatan')->delete($data->id);
                $disabled++;
            }
        }


        activity()
           ->causedBy(auth()->user())
           ->withProperties([
                'fasilitasKesehatan' => FasilitasKesehatan::find($id)->nama,
                'enabled' => $enabled, 
                'disabled' => $disabled,
                'changed' => $changed
            ])
           ->log('Updated basis rules');

        return back()->with('success', 'Rules berhasil diubah');
    }
}
