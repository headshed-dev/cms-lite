<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ExportBlogArticlesJob;

class ExportBlogArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-blog-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to export blog articles to markdown files.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ExportBlogArticlesJob::dispatch()->onQueue('export_blog_articles');
    }
}
