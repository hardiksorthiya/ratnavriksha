<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('name')->get();

        return view('backend.pages.pages.index', compact('pages'));
    }

    public function edit(string $id)
    {
        $page = Page::findOrFail($id);

        return view('backend.pages.pages.edit', compact('page'));
    }

    public function update(Request $request, string $id)
    {
        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'label' => 'nullable|string|max:255',
            'heading' => 'nullable|string',
            'description' => 'nullable|string',
            'bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_bg_image' => 'nullable|boolean',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($request->boolean('remove_bg_image')) {
            $this->deleteImage($page->bg_image);
            $validated['bg_image'] = null;
        }

        if ($request->hasFile('bg_image')) {
            $this->deleteImage($page->bg_image);
            $validated['bg_image'] = $request->file('bg_image')->store('pages', 'public');
        } else {
            unset($validated['bg_image']);
        }

        unset($validated['remove_bg_image']);

        $validated['status'] = $validated['status'] ?? 'active';

        $page->update($validated);

        return redirect()->route('pages.index')->with('success', 'Page updated successfully');
    }

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
