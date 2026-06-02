<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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

        return view('frontend.pages.home', compact('sliders'));
    }
}
