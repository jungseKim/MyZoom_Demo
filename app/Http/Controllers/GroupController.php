<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

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
        // $user = DB::table('users')->where('name', $request->searchName)->first();

        // if (!$user) {
        //     return 404;
        // }
        return $request->searchName;
        // return view('posts.search', compact('posts', 'name'));
    }
}
