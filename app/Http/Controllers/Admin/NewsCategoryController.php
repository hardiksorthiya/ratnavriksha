<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsCategoryController extends Controller
{
    public function index(): View
    {
        $categories = NewsCategory::latest()->get();

        return view('backend.pages.news-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('backend.pages.news-categories.create_edit');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        NewsCategory::create([
            'name' => $validated['name'],
            'slug' => $this->uniqueSlug($validated['name']),
        ]);

        return redirect()->route('news-categories.index')->with('success', 'News/Event category created successfully.');
    }

    public function edit(string $id): View
    {
        $category = NewsCategory::findOrFail($id);

        return view('backend.pages.news-categories.create_edit', compact('category'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $category = NewsCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $nameChanged = $category->name !== $validated['name'];

        $category->update([
            'name' => $validated['name'],
            'slug' => $nameChanged ? $this->uniqueSlug($validated['name'], $category->id) : $category->slug,
        ]);

        return redirect()->route('news-categories.index')->with('success', 'News/Event category updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $category = NewsCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('news-categories.index')->with('success', 'News/Event category deleted successfully.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base !== '' ? $base : 'news-category';
        $counter = 1;

        while (
            NewsCategory::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}

