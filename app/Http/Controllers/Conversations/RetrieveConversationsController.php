<?php

namespace App\Http\Controllers\Conversations;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;

class RetrieveConversationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request, User $user)
    {
        $conversation = Conversation::byOwner($request->user()->id)->with('messages')
            ->first();

        return view('conversation', [
            'conversation' => $conversation,
            'peer' => $user,
            'owner' => $request->user()
        ]);
    }
}
