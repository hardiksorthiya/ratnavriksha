<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostCategoryController extends Controller
{
    public function index(): View
    {
        $categories = PostCategory::latest()->get();

        return view('backend.pages.post-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('backend.pages.post-categories.create_edit');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        PostCategory::create([
            'name' => $validated['name'],
            'slug' => $this->uniqueSlug($validated['name']),
        ]);

        return redirect()->route('post-categories.index')->with('success', 'Post category created successfully.');
    }

    public function edit(string $id): View
    {
        $category = PostCategory::findOrFail($id);

        return view('backend.pages.post-categories.create_edit', compact('category'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $category = PostCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $nameChanged = $category->name !== $validated['name'];

        $category->update([
            'name' => $validated['name'],
            'slug' => $nameChanged ? $this->uniqueSlug($validated['name'], $category->id) : $category->slug,
        ]);

        return redirect()->route('post-categories.index')->with('success', 'Post category updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $category = PostCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('post-categories.index')->with('success', 'Post category deleted successfully.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base !== '' ? $base : 'post-category';
        $counter = 1;

        while (
            PostCategory::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}

