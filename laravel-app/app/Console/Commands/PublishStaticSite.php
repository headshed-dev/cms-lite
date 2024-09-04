<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\PublishStaticSiteJob;

class PublishStaticSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-static-site';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        PublishStaticSiteJob::dispatch()->onQueue('default');
    }
}
