<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\group_user;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Pusher\Pusher;
use App\Notifications\InvoicePaid;

class GroupController extends Controller
{
    public function show($id)
    {
        return Inertia::render('group/GroupShow', ['group' => Group::find($id)]);
    }

    public function index()
    {
        $groups = auth()->user()->groups;
        return Inertia::render('group/GroupIndex', ['groups' => $groups]);
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

        group_user::create(
            [
                'user_id' => $offer->id,
                'group_id' => $gorup->id
            ]
        );

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
    public function userAdd(Request $request)
    {
        // $a = new group_user();
        // $a->user_id = auth()->user()->id;
        // $a->gruop_id = $request->groupId;
        // $a->save();
        group_user::create(
            [
                'user_id' => auth()->user()->id,
                'group_id' => $request->groupId
            ]
        );
    }
    public function notice()
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $notification = $user->notification;
        $user->Read();
        return Inertia::render('group/Notification', ['notices' => $notification]);
    }
}
