<?php

namespace App\Listeners;

use App\Events\UpsertMarkdownCard;
use App\Jobs\UpsertMarkdownCardJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpsertMarkdownCardListener
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
    public function handle(UpsertMarkdownCard $event): void
    {
        $model = $event->model;
        UpsertMarkdownCardJob::dispatch($model)->onQueue('default');
    }
}
