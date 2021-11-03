<?php

use App\Http\Controllers\VideoChatController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::prefix('chat/')->group(function () {
    Route::get('create', [VideoChatController::class, 'make'])
        ->name('chat.create');

    Route::post('store', [VideoChatController::class, 'store']);

    Route::get('list', [VideoChatController::class, 'index'])
        ->name('chatRoom.list');

    Route::delete('{roomId}/room', [VideoChatController::class, 'roomOut']);

    Route::get('{roomId}/room', [VideoChatController::class, 'room'])
        ->name('chat.room');
});
