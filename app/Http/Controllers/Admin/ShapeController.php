<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shape;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ShapeController extends Controller
{
    public function index()
    {
        $shapes = Shape::all();
        return view('backend.pages.shapes.index', compact('shapes'));
    }

    public function create()
    {
        return view('backend.pages.shapes.create_edit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:shapes,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'nullable|in:active,inactive',
        ]);

        $validated = $this->prepareShapeData($request, $validated);

        Shape::create($validated);

        return redirect()->route('shapes.index')->with('success', 'Shape created successfully');
    }

    public function edit(string $id)
    {
        $shape = Shape::findOrFail($id);
        return view('backend.pages.shapes.create_edit', compact('shape'));
    }

    public function update(Request $request, string $id)
    {
        $shape = Shape::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:shapes,slug,'.$id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_image' => 'nullable|boolean',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($request->boolean('remove_image')) {
            $this->deleteStoredImage($shape->image);
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            $this->deleteStoredImage($shape->image);
            $validated['image'] = $request->file('image')->store('shapes', 'public');
        } else {
            unset($validated['image']);
        }

        unset($validated['remove_image']);

        if (empty($validated['slug']) && ! empty($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if (! isset($validated['status']) || $validated['status'] === '') {
            unset($validated['status']);
        }

        $shape->update($validated);

        return redirect()->route('shapes.index')->with('success', 'Shape updated successfully');
    }

    public function destroy(string $id)
    {
        $shape = Shape::findOrFail($id);
        $this->deleteStoredImage($shape->image);
        $shape->delete();

        return redirect()->route('shapes.index')->with('success', 'Shape deleted successfully');
    }

    private function prepareShapeData(Request $request, array $validated): array
    {
        $validated['slug'] = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name'] ?? 'shape-'.time());

        $validated['name'] = $validated['name'] ?? 'Untitled';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('shapes', 'public');
        } else {
            $validated['image'] = '';
        }

        if (! isset($validated['status']) || $validated['status'] === '') {
            $validated['status'] = 'active';
        }

        return $validated;
    }

    private function deleteStoredImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
