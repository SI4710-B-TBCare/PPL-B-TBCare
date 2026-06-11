<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::latest()->paginate(10);
        return view('admin.feedback.index', compact('feedback'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);

        Feedback::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
        ]);

        return back()->with('success', 'Data feedback berhasil ditambahkan');
    }

    public function json()
    {
        $data = Feedback::find(request('id'));
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);

        Feedback::where('id', $request->id)->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
        ]);

        return back()->with('success', 'Data feedback berhasil diubah');
    }

    public function destroy($id)
    {
        Feedback::find($id)->delete();
        return back()->with('success', 'Data feedback berhasil dihapus');
    }
}
