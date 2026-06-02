<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Shape;
use App\Models\Slider;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $sliders = Slider::query()
            ->active()
            ->orderBy('id')
            ->get();

        $homeShapes = Shape::query()
            ->where(function ($query) {
                $query->where('status', 'active')
                    ->orWhereNull('status');
            })
            ->orderBy('id')
            ->get();

        $homeShapes->transform(function (Shape $shape) {
            $shape->image_src = $this->resolveShapeImageSrc($shape);
            return $shape;
        });

        return view('frontend.pages.home', compact('sliders', 'homeShapes'));
    }

    private function srcFromStoragePath(string $path): string
    {
        $storagePath = '/storage/' . ltrim(str_replace('\\', '/', $path), '/');
        return rtrim(request()->getBaseUrl(), '/') . $storagePath;
    }

    private function resolveShapeImageSrc(Shape $shape): string
    {
        if (empty($shape->image)) {
            return asset('images/home/shapes/round.png');
        }

        $normalized = ltrim(str_replace('\\', '/', $shape->image), '/');

        if (str_starts_with($normalized, 'shapes/') || str_contains($normalized, '/')) {
            return $this->srcFromStoragePath($normalized);
        }

        return asset('images/home/shapes/' . $normalized);
    }
}
