<?php

namespace App\Listeners;

use App\Events\RequestCreatedEvent;
use App\Notifications\RequestCreatedNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Bus\Queueable;
use App\Notifications\RequestUpdatedNotification;
class RequestCreatedListener implements ShouldQueue
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
     * @param  RequestCreatedEvent  $event
     * @return void
     */
    public function handle(RequestCreatedEvent $event)
    {
        // $notification = new RequestCreatedNotification;
        // $notification2 = new RequestUpdatedNotification;
        // $notification->user = $event->user;
        // $notification2->user = $event->requestor;
        // Notification::send($event->user, $notification);
        // Notification::send($event->requestor, $notification2);
    }
}
