<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('backend.pages.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('backend.pages.sliders.create_edit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'desktop_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'nullable|in:active,inactive',
        ]);

        $validated = $this->prepareSliderData($request, $validated);

        Slider::create($validated);

        return redirect()->route('sliders.index')->with('success', 'Slider created successfully');
    }

    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('backend.pages.sliders.create_edit', compact('slider'));
    }

    public function update(Request $request, string $id)
    {
        $slider = Slider::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'desktop_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_main_image' => 'nullable|boolean',
            'remove_desktop_image' => 'nullable|boolean',
            'remove_mobile_image' => 'nullable|boolean',
            'status' => 'nullable|in:active,inactive',
        ]);

        $this->handleImageUpdate($request, $slider, $validated, 'main_image', 'remove_main_image');
        $this->handleImageUpdate($request, $slider, $validated, 'desktop_image', 'remove_desktop_image');
        $this->handleImageUpdate($request, $slider, $validated, 'mobile_image', 'remove_mobile_image');

        if (! array_key_exists('status', $validated) || $validated['status'] === null || $validated['status'] === '') {
            unset($validated['status']);
        }

        $slider->update($validated);

        return redirect()->route('sliders.index')->with('success', 'Slider updated successfully');
    }

    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);

        $this->deleteStoredImage($slider->main_image);
        $this->deleteStoredImage($slider->desktop_image);
        $this->deleteStoredImage($slider->mobile_image);

        $slider->delete();

        return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully');
    }

    private function prepareSliderData(Request $request, array $validated): array
    {
        foreach (['main_image', 'desktop_image', 'mobile_image'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('sliders', 'public');
            } else {
                unset($validated[$field]);
            }
        }

        if (! isset($validated['status']) || $validated['status'] === '') {
            $validated['status'] = 'active';
        }

        return $validated;
    }

    private function handleImageUpdate(Request $request, Slider $slider, array &$validated, string $field, string $removeField): void
    {
        if ($request->boolean($removeField)) {
            $this->deleteStoredImage($slider->{$field});
            $validated[$field] = null;
        }

        if ($request->hasFile($field)) {
            $this->deleteStoredImage($slider->{$field});
            $validated[$field] = $request->file($field)->store('sliders', 'public');
        } else {
            unset($validated[$field]);
        }

        unset($validated[$removeField]);
    }

    private function deleteStoredImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
