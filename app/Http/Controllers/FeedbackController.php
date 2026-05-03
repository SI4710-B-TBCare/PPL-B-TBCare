<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:feedback-list', ['only' => ['index']]);
         $this->middleware('permission:feedback-create', ['only' => ['store']]);
         $this->middleware('permission:feedback-edit', ['only' => ['update', 'json']]);
         $this->middleware('permission:feedback-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $feedback = Feedback::paginate(10);

        return view('admin.feedback.index', compact('feedback'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'pesan' => 'required'
        ]);

        $data = $request->all();

        Feedback::create($data);

        return back()->with('success', 'Feedback berhasil disimpan');
    }
    public function json()
    {
        $data = Feedback::find(request('id'));

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'pesan' => 'required'
        ]);

        $data = $request->all();

        Feedback::find($request->id)->update($data);

        return back()->with('success', 'Feedback berhasil diubah');
    }
}
