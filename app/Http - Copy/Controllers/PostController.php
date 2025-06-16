<?php
namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::with('user', 'comments')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'media_url' => 'nullable|string',
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'media_url' => $validated['media_url'],
        ]);

        return response()->json($post->load('user'), 201);
    }

    public function show($id)
    {
        return Post::with('user', 'comments')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'content' => 'required|string',
            'media_url' => 'nullable|string',
        ]);

        $post->update($validated);
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $post->delete();
        return response()->json(null, 204);
    }
}