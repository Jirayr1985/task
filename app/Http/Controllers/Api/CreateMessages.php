<?php

namespace App\Http\Controllers\Api;

use App\Email\EmailMessageCreated;
use App\Events\Messages\MessageCreatedEvent;
use App\Exceptions\Api\ResourceNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CreateMessages extends Controller
{
    public function __invoke(Request $request, User $user)
    {
        $author = User::find($request->author_id);

        $data = $request->only([
            'text',
            'author_id'
        ]);

        $data['peer_id'] = $user->id;

        $message = $this->createMessageForAuthor($data, $author->email);

        $this->createMessageForPeer($data, $user->email);

        return $message;
    }

    public function createMessageForAuthor(array $data, string $email): Message
    {
        $conversation = $this->retrieveConversation($data['author_id'], $data['peer_id']);

        $message = Message::create($data + ['conversation_id' => $conversation->id]);

        event(new MessageCreatedEvent($message));

        Mail::to($email)->send(new EmailMessageCreated('Mail create for author'));

        return $message;
    }

    public function createMessageForPeer(array $data, string $email): void
    {
        $conversation = $this->retrieveConversation($data['peer_id'], $data['author_id']);

        $message = Message::create($data + ['conversation_id' => $conversation->id]);

        event(new MessageCreatedEvent($message));

        Mail::to($email)->send(new EmailMessageCreated('Mail create for peer'));
    }

    public function retrieveConversation(int $owner_id, int $peer_id): Conversation
    {
        try {
            $conversation = Conversation::byOwnerAndPeer($owner_id, $peer_id)->first();

            throw_if(is_null($conversation), ResourceNotFoundException::class);

        } catch (ResourceNotFoundException $exception) {

            $conversation = Conversation::create([
                'owner_id' => $owner_id,
                'peer_id' => $peer_id,
            ]);
        }

        return $conversation;
    }
}
