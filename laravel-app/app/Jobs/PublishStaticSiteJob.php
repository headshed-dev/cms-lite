<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PublishStaticSiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->onQueue('default');
    }

    public function middleware()
    {
        return [(new \Illuminate\Queue\Middleware\WithoutOverlapping())];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('>>HERE>> Publish static site starting');
        Log::info('>>HERE>> Publish static site starting');
        Log::info('>>HERE>> Publish static site starting');


        $beanstalkdHost = env('BEANSTALKD_API');

        $response = Http::post($beanstalkdHost, [
            'name' => 'PostPublishJob',
            'payload' => 'PosPublishJob-cms-lite001',
        ]);

        // Get the response status code
        $status = $response->status();
        Log::Info('Beanstalkd response status: ' . $status);

        // Get the response body
        $body = $response->body();
        Log::Info('Beanstalkd response body: ' . $body);


    }
}
