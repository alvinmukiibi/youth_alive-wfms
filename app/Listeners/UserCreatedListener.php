<?php

namespace App\Listeners;

use App\Events\UserCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Crypt;

class UserCreatedListener implements ShouldQueue
{
    use Queueable;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreatedEvent  $event
     * @return void
     */
    public function handle(UserCreatedEvent $event)
    {
        $notification = new UserCreatedNotification;
        $notification->user = $event->user;
        $notification->link = Crypt::encrypt($event->user->email);
        Notification::send($event->user, $notification);
    }
}
