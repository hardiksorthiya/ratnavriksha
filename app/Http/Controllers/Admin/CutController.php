<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cut;
use Illuminate\Http\Request;

class CutController extends Controller
{
    public function index()
    {
        $cuts = Cut::latest()->get();
        return view('backend.pages.cuts.index', compact('cuts'));
    }

    public function create()
    {
        return view('backend.pages.cuts.create_edit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:50',
        ]);

        Cut::create([
            'name' => $validated['name'] ?? '',
        ]);

        return redirect()->route('cuts.index')->with('success', 'Cut created successfully');
    }

    public function edit(string $id)
    {
        $cut = Cut::findOrFail($id);
        return view('backend.pages.cuts.create_edit', compact('cut'));
    }

    public function update(Request $request, string $id)
    {
        $cut = Cut::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:50',
        ]);

        $cut->update([
            'name' => $validated['name'] ?? '',
        ]);

        return redirect()->route('cuts.index')->with('success', 'Cut updated successfully');
    }

    public function destroy(string $id)
    {
        Cut::findOrFail($id)->delete();

        return redirect()->route('cuts.index')->with('success', 'Cut deleted successfully');
    }
}
