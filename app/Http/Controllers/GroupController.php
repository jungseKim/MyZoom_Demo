<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\group_user;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Notifications\GroupNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Pusher\Pusher;
use App\Notifications\InvoicePaid;

class GroupController extends Controller
{
    public function __construct()
    {                                  //예외
        $this->middleware(['auth']);
    }

    public function info($id)
    {

        $gorup = Group::find($id);
        $userIn = true;
        foreach ($gorup->users as $user) {
            if ($user['id'] == auth()->user()->id) {
                $userIn = false;
                break;
            }
        }
        return ['group' => Group::find($id)->load('user'), 'userIn' => $userIn];
    }

    public function show($id)
    {
        return Inertia::render('group/GroupShow', ['group' => Group::find($id), 'reservations' => Group::find($id)->reservations]);
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
                $this->send($gorup->id, $user['id'], $offer);
            }
        }
        return redirect()->route('group.index');
    }

    public function send($groupId, $userId, $offer)
    {

        $datas = [
            'type' => 'invitation',
            'offerUser_Id' => $offer->id,
            'offerUser_Image' => $offer->image,
            'offerUser_name' => $offer->name,
            'offerGroup' => $groupId
        ];
        $user = User::find($userId);
        $user->notify(new InvoicePaid($datas));
    }

    public function eazyAdd(Request $request, $group_Id)
    {
        // $user = User::find($request->user_id);
        $users = Group::find($group_Id)->users;
        foreach ($users as $user) {
            if ($user->id == $request->user_id) {
                return 300;
            }
        }
        $offer = auth()->user();
        $this->send($group_Id, $request->user_id, $offer);
        return 201;
    }


    public function userAdd(Request $request)
    {


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
    public function destroy(Request $request, $id)
    {
        $group = Group::find($id);
        $user = $request->user();

        if ($user->cannot('delete', $group)) {
            group_user::where('user_id', $user->id)->where('group_id', $group->id)->delete();
        } else {
            $group->delete();
        }

        return redirect()->route('group.index');
    }

    public function video($id)
    {
        $user = auth()->user();
        $gorup = Group::find($id);

        $users = $gorup->users;
        $datas = [
            'offerGroupId' => $gorup->id,
            'offerGroupTitle' => $gorup->title
        ];

        if ($user->id == $gorup->user_id) {
            foreach ($users as $us) {
                if ($user->id != $us['id']) {
                    $user1 = User::find($us['id']);
                    $user1->notify(new GroupNotice($datas));
                }
            }

            $Re = new Reservation();
            $Re->group_id = $gorup->id;
            $Re->Time = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")));
            $Re->save();
        }

        //방장이 시작한 이후 1번만 실행되야 됨 



        return Inertia::render('chat/VideoChat')->with([
            // 'user' => collect($request->user()->only(['id', 'name'])),
            'roomId' => $id,
            'isManager' => $user->id == $gorup->user_id ? true : false

        ]);
    }
    public function Reservation(Request $request, $id)
    {
        $offer = auth()->user();
        $gorup = Group::find($id);

        $users = $gorup->users;
        $datas = [
            'type' => 'videoStrat',
            'offerGroupId' => $gorup->id,
            'offerGroupTitle' => $gorup->title
        ];
        $this->groupSend($users, $offer, $datas, $request->delay);
    }

    public function groupSend($users, $offer, $datas, $delay)
    {
        foreach ($users as $user) {
            if ($offer->id != $user->id) {
                $user = User::find($user['id']);
                $when = now()->addMinutes($delay);
                $user->notify((new GroupNotice($datas))->delay($when));
            }
        }
    }
}
