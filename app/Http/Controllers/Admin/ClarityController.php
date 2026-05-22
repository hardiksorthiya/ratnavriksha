<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clarity;
use Illuminate\Http\Request;

class ClarityController extends Controller
{
    public function index()
    {
        $clarities = Clarity::latest()->get();
        return view('backend.pages.clarities.index', compact('clarities'));
    }

    public function create()
    {
        return view('backend.pages.clarities.create_edit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:50',
        ]);

        Clarity::create([
            'name' => $validated['name'] ?? '',
        ]);

        return redirect()->route('clarities.index')->with('success', 'Clarity created successfully');
    }

    public function edit(string $id)
    {
        $clarity = Clarity::findOrFail($id);
        return view('backend.pages.clarities.create_edit', compact('clarity'));
    }

    public function update(Request $request, string $id)
    {
        $clarity = Clarity::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:50',
        ]);

        $clarity->update([
            'name' => $validated['name'] ?? '',
        ]);

        return redirect()->route('clarities.index')->with('success', 'Clarity updated successfully');
    }

    public function destroy(string $id)
    {
        Clarity::findOrFail($id)->delete();

        return redirect()->route('clarities.index')->with('success', 'Clarity deleted successfully');
    }
}
