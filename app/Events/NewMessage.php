<?php

namespace App\Events;

use App\Models\Msg;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Msg $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('launchpad.' . $this->message->launchpad_id),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'user_id' => $this->message->user_id,
                'uuid' => $this->message->uuid,
                'message' => $this->message->message,
                'image' => $this->message->image,
                'user' => [
                    'id' => $this->message->user->id,
                    'name' => $this->message->user->name,
                    'address' => $this->message->user->address,
                    'profile_photo_url' => $this->message->user->profile_photo_url,
                ],
                'created_at' => $this->message->created_at,
            ],
        ];
    }
}
