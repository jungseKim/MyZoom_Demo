<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NoticeController extends Controller
{
    public function index()
    {
        $id = auth()->user()->id;
        $user = User::find($id);

        return Inertia::render('group/Notification', ['notices' => $user->notification]);
    }
}
