<?php

namespace App\Listeners;

use App\Events\PendingLeaveEvent;
use App\Notifications\PendingLeaveNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class PendingLeaveListener
{
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
     * @param  PendingLeaveEvent  $event
     * @return void
     */
    public function handle(PendingLeaveEvent $event)
    {
        $notification = new PendingLeaveNotification;
        $notification->user = $event->user;
        // Notification::send($event->user, $notification);
    }
}
