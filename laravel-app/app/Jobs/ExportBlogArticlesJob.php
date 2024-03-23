<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ExportBlogArticlesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->onQueue('export_blog_articles');
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

        Log::info('Exporting blog articles starting');

        // TODO : remove this - DEBUG ONLY
        sleep(3);

        $blogs = \App\Models\Blog::all();


        $directoryPath = storage_path('app/exports/blogs');

        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0775, true);
        }

        $blogs->each(function ($blog) {

            $blogData = [
                'title' => $blog->title,
                'slug' => $blog->slug,
                'description' => $blog->description,
                'keywords' => $blog->keywords,
                'tags' => $blog->tags,
            ];

            $blogHeadMatter = \Symfony\Component\Yaml\Yaml::dump($blogData);

            $blog_file_path = storage_path('app/exports/blogs/' . $blog->slug . '.md');

            Log::info('Exporting blog article: ' . $blog_file_path);

            Log::info('Exporting blog article: ' . $blog_file_path);

            $blog_markdown = "---\n" . $blogHeadMatter . "---\n\n" . $blog->content;

            file_put_contents($blog_file_path, $blog_markdown);
        });



        $settings = \App\Models\Setting::all();

        $settingsData = [];
        $settings->each(function ($setting) use (&$settingsData) {

            if ($setting->value) {
                $settingsData[$setting->label] = $setting->value;
            }
        });

        $settingsJson = json_encode($settingsData);

        $settingsDirectoryPath = storage_path('app/exports/settings');

        if (!file_exists($settingsDirectoryPath)) {
            mkdir($settingsDirectoryPath, 0775, true);
        }
        file_put_contents($settingsDirectoryPath . '/settings.json', $settingsJson);

        Log::info('Settings exported to ' . $settingsDirectoryPath . '/settings.json');

        Log::info('Blog articles and settings export completed');
    }
}
