<?php

namespace App\Listeners;

use App\Events\CustomerGitAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PullUpdateRepository
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CustomerGitAction $event): void
    {
        //
    }
}
