<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Forum;
use App\Models\ForumComment;

class ForumCommentController extends Controller
{
    public function store(Request $request, Forum $forum)
    {
        if (auth()->user()->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'konten' => 'required'
        ]);

        ForumComment::create([
            'forum_id' => $forum->id,
            'user_id' => auth()->id(),
            'konten' => $request->konten
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }

    public function destroy(ForumComment $comment)
    {
        if (!auth()->user()->hasRole('Admin') && $comment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus');
    }
}
