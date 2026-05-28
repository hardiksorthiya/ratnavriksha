<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsComment;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $newsItems = News::with('category')
            ->where('status', 'active')
            ->latest('published_at')
            ->paginate(9);

        $page = Page::where('slug', 'news-events')->where('status', 'active')->firstOrFail();

        return view('frontend.pages.news-events.index', compact('newsItems', 'page'));
    }

    public function show(string $slug): View
    {
        $news = News::with(['category', 'comments'])->where('slug', $slug)->where('status', 'active')->firstOrFail();

        $latestNews = News::where('status', 'active')
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        $previousNews = News::where('status', 'active')
            ->where('published_at', '<', $news->published_at)
            ->latest('published_at')
            ->first();

        $nextNews = News::where('status', 'active')
            ->where('published_at', '>', $news->published_at)
            ->oldest('published_at')
            ->first();

        $relatedNews = News::where('status', 'active')
            ->where('id', '!=', $news->id)
            ->when($news->news_category_id, function ($q) use ($news) {
                $q->where('news_category_id', $news->news_category_id);
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedNews->count() < 3) {
            $needed = 3 - $relatedNews->count();
            $extra = News::where('status', 'active')
                ->where('id', '!=', $news->id)
                ->whereNotIn('id', $relatedNews->pluck('id'))
                ->latest('published_at')
                ->take($needed)
                ->get();

            $relatedNews = $relatedNews->concat($extra);
        }

        return view('frontend.pages.news-events.show', compact('news', 'latestNews', 'previousNews', 'nextNews', 'relatedNews'));
    }

    public function storeComment(Request $request, string $slug): RedirectResponse
    {
        $news = News::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'comment' => 'required|string|max:2000',
        ]);

        NewsComment::create([
            'news_id' => $news->id,
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('news-events.show', $news->slug)->with('news_comment_success', 'Comment submitted successfully.');
    }
}

