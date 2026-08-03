<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CrewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MyListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::controller(MovieController::class)->middleware(['auth', 'verified'])
    ->group(function(){
    Route::get('/movies', 'index')->name('movies.index');
    Route::get('/movies/{movie:slug}', 'show')->name('movies.show');
    Route::get('/movies/{movie:slug}/watch', 'watch')->name('movies.watch')->middleware(['subscribed']);
});

Route::controller(SubscriptionController::class)->middleware(['auth', 'verified'])
    ->group(function(){
    Route::get('/subscriptions', 'index')->name('subscriptions.index');
    Route::get('/subscriptions/success', 'success' )->name('subscriptions.success')->middleware(['subscribed']);
    Route::get('/subscriptions/{plan}', 'show')->name('subscriptions.show');
    Route::post('subscriptions/{plan}/purchase', 'purchase')->name('subscriptions.purchase');
});

Route::controller(RatingController::class)->middleware(['auth', 'verified', 'subscribed'])
    ->group(function(){
    Route::post('ratings/{movie}', 'store')->name('ratings.store');
});

Route::controller(CrewController::class)->middleware(['auth', 'verified'])
    ->group(function(){
        Route::get('/crews', 'index')->name('crews.index');
        Route::get('/crews/{crew}', 'show')->name('crews.show');
});

Route::controller(MyListController::class)->middleware(['auth', 'verified'])
    ->group(function(){
        Route::get('/my-lists', 'index')->name('mylists.index');
        Route::post('/my-lists/{movie}', 'store')->name('mylists.store');
        Route::delete('my-lists/{myList}', 'destroy')->name('mylists.destroy');
});

Route::controller(CategoryController::class)->middleware(['auth', 'verified'])
    ->group(function(){
        Route::get('/categories/{category}', 'show')->name('categories.show');
    });




Route::fallback(function(){
    return view('errors.fallback');
});
