<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Notifications\InvoicePaid;

class NoticeController extends Controller
{
    public function index()
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $notification = $user->notification;
        $user->Read();
        return Inertia::render('group/Notification', ['notices' => $notification]);
    }
}
