<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $blogs = \App\Models\Blog::all();

        $this->info('Exporting blog articles...');


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

            $this->info('Exporting blog article: ' . $blog_file_path);

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

        $this->info('Settings exported to ' . $settingsDirectoryPath . '/settings.json successfully!');

        $this->info('Blog articles and settings export completed');
    }
}
