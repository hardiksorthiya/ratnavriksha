<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = Post::with('category')
            ->where('status', 'active')
            ->latest('published_at')
            ->paginate(9);

        $page = Page::where('slug', 'blogs')->where('status', 'active')->firstOrFail();

        return view('frontend.pages.blogs.index', compact('posts', 'page'));
    }

    public function show(string $slug): View
    {
        $post = Post::with(['category', 'comments'])->where('slug', $slug)->where('status', 'active')->firstOrFail();

        $latestPosts = Post::where('status', 'active')
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        $previousPost = Post::where('status', 'active')
            ->where('published_at', '<', $post->published_at)
            ->latest('published_at')
            ->first();

        $nextPost = Post::where('status', 'active')
            ->where('published_at', '>', $post->published_at)
            ->oldest('published_at')
            ->first();

        $relatedPosts = Post::where('status', 'active')
            ->where('id', '!=', $post->id)
            ->when($post->post_category_id, function ($q) use ($post) {
                $q->where('post_category_id', $post->post_category_id);
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedPosts->count() < 3) {
            $needed = 3 - $relatedPosts->count();
            $extra = Post::where('status', 'active')
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->latest('published_at')
                ->take($needed)
                ->get();

            $relatedPosts = $relatedPosts->concat($extra);
        }

        return view('frontend.pages.blogs.show', compact('post', 'latestPosts', 'previousPost', 'nextPost', 'relatedPosts'));
    }

    public function storeComment(Request $request, string $slug): RedirectResponse
    {
        $post = Post::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'comment' => 'required|string|max:2000',
        ]);

        PostComment::create([
            'post_id' => $post->id,
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('blogs.show', $post->slug)->with('blog_comment_success', 'Comment submitted successfully.');
    }
}

