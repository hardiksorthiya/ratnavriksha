<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->get();
        return view('backend.pages.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('backend.pages.colors.create_edit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:50',
        ]);

        Color::create([
            'name' => $validated['name'] ?? '',
        ]);

        return redirect()->route('colors.index')->with('success', 'Color created successfully');
    }

    public function edit(string $id)
    {
        $color = Color::findOrFail($id);
        return view('backend.pages.colors.create_edit', compact('color'));
    }

    public function update(Request $request, string $id)
    {
        $color = Color::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:50',
        ]);

        $color->update([
            'name' => $validated['name'] ?? '',
        ]);

        return redirect()->route('colors.index')->with('success', 'Color updated successfully');
    }

    public function destroy(string $id)
    {
        Color::findOrFail($id)->delete();

        return redirect()->route('colors.index')->with('success', 'Color deleted successfully');
    }
}
