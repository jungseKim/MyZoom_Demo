<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use function PHPSTORM_META\type;

class GestController extends Controller
{
    public function video(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
        ]);

        if (Group::find($request->id)->key->value == $request->thiskey) {
            $user = User::factory()->make();
            $user->name = $request->name;
            $user->save();
            Auth::login($user);
            return redirect('/gest/start/' . $request->id);
        }
    }
    public function start($id)
    {
        // dd($request);
        if (!Auth::check()) {
            return Inertia::render('group/GestVarifiy')
                ->with(['thiskey' => Group::find($id)->key->value, 'id' => $id]);
        }

        // Auth::login($user);
        return Inertia::render('chat/VideoChat')->with([
            // 'user' => $gest,
            'roomId' => $id,
            'isManager' => false,
            'isGest' => true

        ]);
    }

    public function out($id)
    {
        if (Auth::check()) {
            $user = auth()->user();
            Auth::logout($user);
            User::find($user->id)->delete();
        }

        $group = Group::find($id);

        return Inertia::render('group/GestVarifiy')->with(['thiskey' => $group->key->value, 'id' => $id]);
        // dd($id);
        // 그룹 아이디랑 받아와야함 key 값 그룹 아이디로 

        // $request = request('thiskey', $group->key);

        // return redirect('/group/video/' . $id)->with('thiskey', $group->key);
        // return redirect()->action('GroupController@video', [$request]);
        // return Inertia::render('group/GestVarifiy')->with(['thiskey' => $group->key, 'id' => $id]);
    }
}
