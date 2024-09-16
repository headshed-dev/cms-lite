<?php

namespace App\Jobs;

use App\Models\MarkdownCard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpsertMarkdownCardJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;

    /**
     * Create a new job instance.
     */
    public function __construct(MarkdownCard $model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('>>HERE>> UpsertMarkdownCardJob');
        Log::info('Model Class: ' . get_class($this->model));
        Log::info('Model ID: ' . $this->model->id);

    }
}
