<?php

namespace App\Listeners;

use App\Events\PublishStaticSite;
use App\Jobs\PublishStaticSiteJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;

class PublishStaticSiteListener implements ShouldQueue
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
    public function handle(PublishStaticSite $event): void
    {
        Log::info('PublishStaticSiteListener called');
        PublishStaticSiteJob::dispatch()->onQueue('default');
    }
}
