<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\GroupNotice;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    public function index()
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $notification = $user->notification;

        for ($i = 10; $i < sizeof($notification); $i++) {
            $no = $notification[$i];
            DB::table('notifications')->where('id', $no['id'])->delete();
        }

        $user->Read();
        return Inertia::render('group/Notification', ['notices' => $notification]);
    }

    public function destroy($id)
    {
        DB::table('notifications')->where('id', $id)->delete();
    }

    public function Reservation(Request $request, $id)
    {
        $offer = auth()->user();
        $gorup = Group::find($id);

        if (Reservation::where('group_id', $gorup->id)->exists()) {
            return 302;
        }
        // $timestamp = strtotime("2020-11-02 13:03:09 +" . $request->delay . " minute");
        $timestamp = strtotime(date("Y-m-d H:i:s") . ' +' . $request->delay . " minute");
        $newDateTime = date("Y-m-d H:i:s", $timestamp);

        $Re = new Reservation();
        $Re->group_id = $gorup->id;
        $Re->Time = $newDateTime;
        $Re->save();

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
