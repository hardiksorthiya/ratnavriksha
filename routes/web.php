<?php

use App\Http\Controllers\Admin\ClarityController;
use App\Http\Controllers\Admin\CutController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ShapeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Frontend\EnquiryController;
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
    Route::resource('pages', PageController::class)->only(['index', 'edit', 'update']);
});


// frontend routes
Route::get('/', function () {
    return view('frontend.pages.home');
})->name('home');

Route::get('/product/{slug}', [FrontendProductController::class, 'show'])->name('product.show');
Route::post('/product-enquiry', [EnquiryController::class, 'store'])->name('product.enquiry.store');

Route::get('/about', fn () => app(FrontendPageController::class)->show('about'))->name('about');
Route::get('/contact', fn () => app(FrontendPageController::class)->show('contact'))->name('contact');

require __DIR__.'/auth.php';

Route::get('/{slug}', [FrontendPageController::class, 'show'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('page.show');