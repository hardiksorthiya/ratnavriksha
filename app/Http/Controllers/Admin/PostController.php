<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::with('category')->latest()->get();

        return view('backend.pages.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = PostCategory::orderBy('name')->get();

        return view('backend.pages.posts.create_edit', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePost($request);

        $data = $this->preparePostData($validated);
        if ($request->hasFile('feature_image')) {
            $data['feature_image'] = $request->file('feature_image')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(string $id): View
    {
        $post = Post::findOrFail($id);
        $categories = PostCategory::orderBy('name')->get();

        return view('backend.pages.posts.create_edit', compact('post', 'categories'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        $validated = $this->validatePost($request, $post->id);
        $data = $this->preparePostData($validated, $post);

        if ($request->boolean('remove_feature_image')) {
            $this->deleteStoredFile($post->feature_image);
            $data['feature_image'] = null;
        }

        if ($request->hasFile('feature_image')) {
            $this->deleteStoredFile($post->feature_image);
            $data['feature_image'] = $request->file('feature_image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        $this->deleteStoredFile($post->feature_image);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    private function validatePost(Request $request, ?int $postId = null): array
    {
        $slugRule = 'nullable|string|max:255|unique:posts,slug';
        if ($postId) {
            $slugRule .= ',' . $postId;
        }

        return $request->validate([
            'post_category_id' => 'nullable|exists:post_categories,id',
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'excerpt' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_feature_image' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
            'published_at' => 'nullable|date',
        ]);
    }

    private function preparePostData(array $validated, ?Post $post = null): array
    {
        $data = [
            'post_category_id' => $validated['post_category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => !empty($validated['slug'])
                ? Str::slug($validated['slug'])
                : Str::slug($validated['title'] ?? ($post?->title ?? 'post')),
            'excerpt' => $validated['excerpt'] ?? null,
            'description' => $validated['description'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'status' => $validated['status'] ?? 'active',
            'published_at' => $validated['published_at'] ?? now(),
        ];

        return $data;
    }

    private function deleteStoredFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

