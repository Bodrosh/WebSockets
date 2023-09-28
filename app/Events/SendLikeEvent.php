<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// или implements ShouldBroadcastNow - для sync, вместо default queue driver (без очередей)
class SendLikeEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $like_str;
    private int $user_id;

    /**
     * Create a new event instance.
     */
    public function __construct(string $like_str, int $user_id)
    {
        $this->like_str = $like_str;
        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('send_like_' . $this->user_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'send_like';
    }

    public function broadcastWith(): array
    {
        return [
            'like_str' => $this->like_str
        ];
    }
}
