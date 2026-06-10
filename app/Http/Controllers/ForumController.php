<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Forum;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::with('user')->latest()->paginate(10);

        if (auth()->user()->hasRole('Admin')) {
            return view('admin.forum.index', compact('forums'));
        }

        return view('user.forum.index', compact('forums'));
    }

    public function show(Forum $forum)
    {
        $forum->load('comments.user', 'user');

        if (auth()->user()->hasRole('Admin')) {
            return view('admin.forum.show', compact('forum'));
        }

        return view('user.forum.show', compact('forum'));
    }

    public function store(Request $request)
    {
        // Admin should not be creating forums, but if they try, we block or allow based on concept. 
        // We block if Admin doesn't have the "Tambahkan" button anyway, but let's be safe.
        if (auth()->user()->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'judul' => 'required',
            'konten' => 'required'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        Forum::create($data);

        return back()->with('success', 'Forum berhasil dibuat');
    }

    public function json()
    {
        $data = Forum::findOrFail(request('id'));
        
        // Only allow if Admin, or if the user is the owner
        if (!auth()->user()->hasRole('Admin') && $data->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required'
        ]);

        $forum = Forum::findOrFail($request->id);

        if (!auth()->user()->hasRole('Admin') && $forum->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $forum->update($request->all());

        return back()->with('success', 'Forum berhasil diubah');
    }

    public function destroy(Forum $forum)
    {
        if (!auth()->user()->hasRole('Admin') && $forum->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $forum->delete();
        return back()->with('success', 'Forum berhasil dihapus');
    }
}
