<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('presence-video-chat.{roomId}', function ($user, $roomId) {
    if (Auth::check()) {
        return ['id' => $user->id, 'name' => $user->name, 'image' => $user->profile_photo_path];
    }
});

// Broadcast::channel('App.User.{id}', function ($user, $roomId) {
//     return true;
// });
