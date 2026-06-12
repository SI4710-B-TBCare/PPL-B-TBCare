<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::latest()->paginate(10);
        
        if (auth()->user()->hasRole('Admin')) {
            return view('admin.feedback.index', compact('feedback'));
        }

        return view('user.feedback.index', compact('feedback'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);

        Feedback::create([
            'user_id' => auth()->id(),
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

        $feedback = Feedback::findOrFail($request->id);

        if (!auth()->user()->hasRole('Admin') && $feedback->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $feedback->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
        ]);

        return back()->with('success', 'Data feedback berhasil diubah');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);

        if (!auth()->user()->hasRole('Admin') && $feedback->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $feedback->delete();
        return back()->with('success', 'Data feedback berhasil dihapus');
    }
}
