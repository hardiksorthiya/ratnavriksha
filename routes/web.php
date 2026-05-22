<?php

use App\Http\Controllers\Admin\ClarityController;
use App\Http\Controllers\Admin\CutController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ShapeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Frontend\EnquiryController;
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
});


// frontend routes
Route::get('/', function () {
    return view('frontend.pages.home');
})->name('home');

Route::get('/product/{slug}', [FrontendProductController::class, 'show'])->name('product.show');
Route::post('/product-enquiry', [EnquiryController::class, 'store'])->name('product.enquiry.store');



require __DIR__.'/auth.php';