<?php

namespace App\Listeners;

use App\Events\RequestUpdateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestUpdateListener
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
     * @param  RequestUpdateEvent  $event
     * @return void
     */
    public function handle(RequestUpdateEvent $event)
    {
        //
    }
}
