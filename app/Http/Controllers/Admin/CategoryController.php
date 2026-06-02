<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();

        return view('backend.pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.pages.categories.create_edit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        Category::create([
            'name' => $validated['name'] ?? '',
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        return view('backend.pages.categories.create_edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        $category->update([
            'name' => $validated['name'] ?? '',
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(string $id)
    {
        Category::findOrFail($id)->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
