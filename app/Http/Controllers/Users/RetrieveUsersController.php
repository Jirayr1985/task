<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RetrieveUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        $users = User::withoutMe($request->user()->id)->get();

        return view('users', [
            'users' => $users
        ]);
    }
}
