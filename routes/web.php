<?php

use App\Http\Controllers\Admin\ClarityController;
use App\Http\Controllers\Admin\CutController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImportController;
use App\Http\Controllers\Admin\ShapeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\EnquiryController;
use App\Http\Controllers\Frontend\DiamondController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('backend.pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('sliders', SliderController::class);
    Route::resource('shapes', ShapeController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('clarities', ClarityController::class);
    Route::resource('cuts', CutController::class);
    Route::resource('products', ProductController::class);
    Route::get('products-import', [ProductImportController::class, 'index'])->name('products.import.index');
    Route::get('products-import/template', [ProductImportController::class, 'downloadTemplate'])->name('products.import.template');
    Route::post('products-import', [ProductImportController::class, 'import'])->name('products.import.store');
    Route::resource('post-categories', PostCategoryController::class);
    Route::resource('posts', PostController::class);
    Route::resource('news-categories', NewsCategoryController::class);
    Route::resource('news', AdminNewsController::class)->except(['show']);
    Route::resource('pages', PageController::class)->only(['index', 'edit', 'update']);
    Route::get('enquiries/product', [AdminEnquiryController::class, 'productIndex'])->name('enquiries.product.index');
    Route::get('enquiries/contact', [AdminEnquiryController::class, 'contactIndex'])->name('enquiries.contact.index');
    Route::delete('enquiries/{enquiry}', [AdminEnquiryController::class, 'destroy'])->name('enquiries.destroy');
});


// frontend routes
Route::get('/', function () {
    return view('frontend.pages.home');
})->name('home');

Route::get('/product/{slug}', [FrontendProductController::class, 'show'])->name('product.show');
Route::post('/product-enquiry', [EnquiryController::class, 'store'])->name('product.enquiry.store');
Route::post('/contact', [EnquiryController::class, 'storeContact'])->name('contact.store');

Route::get('/about', fn () => app(FrontendPageController::class)->show('about'))->name('about');
Route::get('/contact', fn () => app(FrontendPageController::class)->show('contact'))->name('contact');
Route::get('/diamonds', [DiamondController::class, 'index'])->name('diamonds');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::post('/blogs/{slug}/comments', [BlogController::class, 'storeComment'])->name('blogs.comments.store');
Route::get('/news-events', [NewsController::class, 'index'])->name('news-events.index');
Route::get('/news-events/{slug}', [NewsController::class, 'show'])->name('news-events.show');
Route::post('/news-events/{slug}/comments', [NewsController::class, 'storeComment'])->name('news-events.comments.store');

require __DIR__.'/auth.php';

Route::get('/{slug}', [FrontendPageController::class, 'show'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('page.show');