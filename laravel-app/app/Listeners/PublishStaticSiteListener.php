<?php

namespace App\Listeners;

use App\Jobs\PublishStaticSiteJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PublishStaticSiteListener
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
    public function handle(object $event): void
    {
        PublishStaticSiteJob::dispatch()->onQueue('default');
    }
}
