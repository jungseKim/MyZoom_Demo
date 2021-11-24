<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\room_user;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VideoChatController extends Controller
{
    public function roomOut(Request $request, $roomId)
    {
        $user = $request->user();
        if (Room::where('user_id', $user->id)->exists()) {
            // Room::where('user_id', $user->id)->delete();
        } else {
            room_user::where('user_id', $user->id)->delete();
        }
        return response(201);
    }

    public function make()
    {

        $user = auth()->user();

        if (Room::where('user_id', $user->id)->exists()) {
            return back();
        }

        return Inertia::render('chat/RoomMake');
    }
    public function  store(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'title' => 'required|max:10'
        ]);

        $room = new Room();
        $room->user_id = $user->id;

        $room->title = $request->title;
        $room->peoples = $request->peoples;
        $room->save();

        room_user::create(
            [
                'user_id' => $user->id,
                'room_id' => $room->id
            ]
        );
        return redirect()->route('chat.room', ['roomId' => $room->id]);
    }

    public function index()
    {
        $room = Room::find(5);
        // dd($room);
        return Inertia::render('chat/RoomList')->with([
            'list' => Room::with('users')->get(),
            // 'list' => $room->load('users'),
        ]);
    }

    public function room(Request $request, $roomId)
    {
        $user = $request->user();
        $room = Room::find($roomId);
        return Inertia::render('chat/VideoChat')->with([
            // 'user' => collect($request->user()->only(['id', 'name'])),
            'roomId' => $roomId,
            'isManager' => $user->id == $room->user_id ? true : false

        ]);
    }
}
