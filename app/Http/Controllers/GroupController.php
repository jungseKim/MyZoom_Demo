<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Pusher\Pusher;
use App\Notifications\InvoicePaid;

class GroupController extends Controller
{
    public function index()
    {
        return Inertia::render('group/GroupIndex');
    }

    public function create()
    {

        return Inertia::render('group/GroupMake');
    }
    public function search(Request $request)
    {
        $user = User::where('name', $request->name)->first();

        if (!$user) {
            return 404;
        }
        return $user;
        // return view('posts.search', compact('posts', 'name'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2',
            'introduction' => 'required',

        ]);

        $offer = auth()->user();
        $gorup = new Group();
        $gorup->user_id = $offer->id;
        $gorup->title = $request->title;
        $gorup->introduction = $request->introduction;
        $gorup->save();
        if ($request->users) {
            $users = $request->users;

            foreach ($users as $user) {
                $this->send($gorup->id, $user['id'], $offer->id);
            }
        }
        return redirect()->route('group.index');
    }

    public function send($groupId, $userId, $offerId)
    {

        $datas = [
            'offerUser' => $offerId,
            'offerGroup' => $groupId
        ];
        $user = User::find($userId);
        $user->notify(new InvoicePaid($datas));
    }
}
