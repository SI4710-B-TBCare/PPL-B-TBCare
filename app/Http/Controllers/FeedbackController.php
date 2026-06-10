<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    // Custom authorization logic is handled inside the methods


    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $feedback = Feedback::with('user')->paginate(10);
            return view('admin.feedback.index', compact('feedback'));
        }

        $feedback = Feedback::where('user_id', auth()->id())->paginate(10);
        return view('user.feedback.index', compact('feedback'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'pesan' => 'required'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        Feedback::create($data);

        return back()->with('success', 'Feedback berhasil disimpan');
    }
    public function json()
    {
        $data = Feedback::findOrFail(request('id'));
        
        if (!auth()->user()->hasRole('Admin') && $data->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'pesan' => 'required'
        ]);

        $feedback = Feedback::findOrFail($request->id);

        if (!auth()->user()->hasRole('Admin') && $feedback->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $feedback->update($request->all());

        return back()->with('success', 'Feedback berhasil diubah');
    }
    public function destroy(Feedback $feedback)
    {
        if (!auth()->user()->hasRole('Admin') && $feedback->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $feedback->delete();
        return back()->with('success', 'Feedback berhasil dihapus');
    }
}
