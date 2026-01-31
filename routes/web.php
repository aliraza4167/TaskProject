<?php

use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ThreadController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('tasks', TaskController::class);

    Route::resource('threads', ThreadController::class);

    Route::post('threads/{thread}/messages', [MessageController::class, 'store'])->name('threads.messages.store');

    Route::get('dashboard', function() {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Friendship routes
    Route::post('/friends/{user}/send', [FriendshipController::class, 'sendRequest']);
    Route::post('/friends/{friendship}/accept', [FriendshipController::class, 'acceptRequest']);
    Route::post('/friends/{friendship}/decline', [FriendshipController::class, 'declineRequest']);

});

require __DIR__.'/settings.php';
