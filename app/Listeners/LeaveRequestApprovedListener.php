<?php

namespace App\Listeners;

use App\Events\LeaveRequestApprovedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LeaveRequestApprovedNotification;

class LeaveRequestApprovedListener
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
     * @param  LeaveRequestApprovedEvent  $event
     * @return void
     */
    public function handle(LeaveRequestApprovedEvent $event)
    {
        $notification = new LeaveRequestApprovedNotification;
        $notification->user = $event->leave->user;
        $notification->leave = $event->leave;
        Notification::send($event->leave->user, $notification);
    }
}
