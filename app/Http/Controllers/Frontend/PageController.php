<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $view = 'frontend.pages.'.$slug;

        if (! view()->exists($view)) {
            abort(404, "Create blade file: resources/views/frontend/pages/{$slug}.blade.php");
        }

        return view($view, compact('page'));
    }
}
