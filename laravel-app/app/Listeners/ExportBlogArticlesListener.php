<?php

namespace App\Listeners;

use App\Events\ExportBlogArticles;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExportBlogArticlesListener implements ShouldQueue
{

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string
     */
    public $queue = 'export_blog_articles';


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
        Artisan::call('app:export-blog-articles');
    }
}
