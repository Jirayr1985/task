<?php

namespace App\Events\Messages;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return 'message_created';
    }

    public function broadcastAs()
    {

        $owner_id =  $this->retrieveConversationByID($this->message->conversation_id);

        return 'conversation_'.$owner_id;
    }

    public function broadcastWith()
    {
        return [
            'owner_id' => $this->retrieveConversationByID($this->message->conversation_id),
            'message' => $this->message,
        ];
    }

    public function retrieveConversationByID(int $conversation_id): int
    {
        return $conversation = Conversation::find($conversation_id)->owner_id;
    }
}
