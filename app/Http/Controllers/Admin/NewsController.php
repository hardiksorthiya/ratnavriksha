<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $newsItems = News::with('category')->latest()->get();

        return view('backend.pages.news.index', compact('newsItems'));
    }

    public function create(): View
    {
        $categories = NewsCategory::orderBy('name')->get();

        return view('backend.pages.news.create_edit', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateNews($request);

        $data = $this->prepareNewsData($validated);
        if ($request->hasFile('feature_image')) {
            $data['feature_image'] = $request->file('feature_image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('news.index')->with('success', 'News/Event created successfully.');
    }

    public function edit(string $id): View
    {
        $news = News::findOrFail($id);
        $categories = NewsCategory::orderBy('name')->get();

        return view('backend.pages.news.create_edit', compact('news', 'categories'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $news = News::findOrFail($id);
        $validated = $this->validateNews($request, $news->id);
        $data = $this->prepareNewsData($validated, $news);

        if ($request->boolean('remove_feature_image')) {
            $this->deleteStoredFile($news->feature_image);
            $data['feature_image'] = null;
        }

        if ($request->hasFile('feature_image')) {
            $this->deleteStoredFile($news->feature_image);
            $data['feature_image'] = $request->file('feature_image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('news.index')->with('success', 'News/Event updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $news = News::findOrFail($id);
        $this->deleteStoredFile($news->feature_image);
        $news->delete();

        return redirect()->route('news.index')->with('success', 'News/Event deleted successfully.');
    }

    private function validateNews(Request $request, ?int $newsId = null): array
    {
        $slugRule = 'nullable|string|max:255|unique:news,slug';
        if ($newsId) {
            $slugRule .= ',' . $newsId;
        }

        return $request->validate([
            'news_category_id' => 'nullable|exists:news_categories,id',
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

    private function prepareNewsData(array $validated, ?News $news = null): array
    {
        return [
            'news_category_id' => $validated['news_category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => !empty($validated['slug'])
                ? Str::slug($validated['slug'])
                : Str::slug($validated['title'] ?? ($news?->title ?? 'news')),
            'excerpt' => $validated['excerpt'] ?? null,
            'description' => $validated['description'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'status' => $validated['status'] ?? 'active',
            'published_at' => $validated['published_at'] ?? now(),
        ];
    }

    private function deleteStoredFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

