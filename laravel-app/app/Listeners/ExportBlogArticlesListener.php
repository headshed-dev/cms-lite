<?php

namespace App\Listeners;

use App\Events\ExportBlogArticles;
use App\Jobs\ExportBlogArticlesJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExportBlogArticlesListener implements ShouldQueue
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
    public function handle(ExportBlogArticles $event): void
    {
        ExportBlogArticlesJob::dispatch()->onQueue('export_blog_articles');
    }
}
