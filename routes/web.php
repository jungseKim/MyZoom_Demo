<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\VideoChatController;
use App\Models\Group;
use Illuminate\Foundation\Application;
use Illuminate\Notifications\Notification;
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

Route::prefix('group/')->group(function () {
    Route::get('index', [GroupController::class, 'index'])
        ->name('group.index');

    Route::get('create', [GroupController::class, 'create'])
        ->name('group.create');

    Route::get('search', [GroupController::class, 'search'])
        ->name('group.search');

    Route::post('store', [GroupController::class, 'store']);

    Route::post('userAdd', [GroupController::class, 'userAdd']);

    Route::get('notice', [GroupController::class, 'notice'])
        ->name('group.notice');

    Route::get('show/{id}', [GroupController::class, 'show'])
        ->name('group.show');

    Route::get('video/{id}', [GroupController::class, 'video'])
        ->name('group.video');

    Route::get('info/{id}', [GroupController::class, 'info'])
        ->name('group.info');

    Route::post('Reservation/{id}', [GroupController::class, 'Reservation'])
        ->name('group.Reservation');

    Route::delete('destroy/{id}', [GroupController::class, 'destroy']);

    Route::post('eazyAdd/{group_id}', [GroupController::class, 'eazyAdd'])
        ->name('group.eazyAdd');
});

Route::prefix('notice/')->group(function () {

    Route::get('index', [NoticeController::class, 'index'])
        ->name('notice.index');

    Route::delete('destroy/{id}', [NoticeController::class, 'destroy']);


    Route::post('Reservation/{id}', [NoticeController::class, 'Reservation'])
        ->name('notice.Reservation');

    Route::delete('cancle/{id}', [NoticeController::class, 'cancle']);
});
