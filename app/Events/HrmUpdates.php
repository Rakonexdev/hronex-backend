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
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Models\UserDeviceToken;

class HrmUpdates implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $title;
    public $body;
    public $deviceToken;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($title, $body, $deviceToken)
    {
        $this->title = $title;
        $this->body = $body;

        $firebaseToken = UserDeviceToken::whereNotNull('device_token')
                                              ->where('user_id', $deviceToken)
                                              ->where('device_type', '<>', 'admin')
                                              ->pluck('device_token')
                                              ->all();

        $this->deviceToken = $firebaseToken[0];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        /*return new PrivateChannel('hrm-notifs.'.$this->deviceToken);*/
        return ['hrm-notifs'];
    }

    public function broadcastAs()
    {
        return 'notification';
    }

    public function broadcastWith()
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
        ];
    }

    /*public function handle()
    {
        $factory = (new Factory)
            ->withServiceAccount(env('FIREBASE_CREDENTIALS'));

        $messaging = $factory->createMessaging();

        $message = CloudMessage::withTarget('token', $this->deviceToken)
            ->withNotification(Notification::create($this->title, $this->body));

        $messaging->send($message);
    }*/
}
