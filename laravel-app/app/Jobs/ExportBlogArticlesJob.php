<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class ExportBlogArticlesJob implements ShouldQueue
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

        // TODO : remove sleep - DEBUG ONLY
        // Log::debug('sleeping for 3 seconds');
        // sleep(3);
        Log::info('Exporting blog articles starting');

        $blogs = \App\Models\Blog::all();


        $directoryPath = storage_path('app/exports/blogs');

        if (!File::isDirectory($directoryPath)) {
            File::makeDirectory($directoryPath, 0775, true);
        } else {
            Log::info('Cleaning directory: ' . $directoryPath);
            File::cleanDirectory($directoryPath);
        }


        $blogs->each(function ($blog) {

            $blog_category = \App\Models\BlogCategory::find($blog->category_id);

            $blogData = [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'description' => $blog->description,
                'keywords' => $blog->keywords,
                'tags' => $blog->tags,
                'image' => $blog->image,
                'updated_at' => $blog->updated_at,
                'created_at' => $blog->created_at,
                'category' => $blog_category ? $blog_category->name : null,
                'blog_date' => $blog->blog_date,
                'is_featured' => $blog->is_featured,
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



        $cards = \App\Models\Card::all();

        $cardsData = [];

        $cards->each(function ($card) use (&$cardsData) {

            $card_category = \App\Models\CardCategory::find($card->category_id);

            $cardData = [
                'id' => $card->id,
                'title' => $card->title,
                'content' => $card->content,
                'link' => $card->link,
                'updated_at' => $card->updated_at,
                'created_at' => $card->created_at,
                'category' => $card_category ? $card_category->name : null,
                'is_featured' => $card->is_featured ? $card->is_featured : false,
            ];

            Log::info('Exporting card title: ' . $card->title);
            Log::info('Exporting card featured: ' . $card->is_featured);

            $cardsData[] = $cardData;
        });

        $cardsJson = json_encode($cardsData);

        $cardsDirectoryPath = storage_path('app/exports/cards');

        if (!file_exists($cardsDirectoryPath)) {
            mkdir($cardsDirectoryPath, 0775, true);
        }

        file_put_contents($cardsDirectoryPath . '/cards.json', $cardsJson);



        $textWidgets = \App\Models\TextWidget::all();

        $textWidgetsData = [];

        $textWidgets->each(function ($textWidget) use (&$textWidgetsData) {
            $category = \App\Models\TextWidgetCategory::find($textWidget->category_id);

            $textWidgetData = [
                'id' => $textWidget->id,
                'description' => $textWidget->description ? $textWidget->description : null,
                'content' => $textWidget->content,
                'category' => $category ? $category->name : null,
                'category_id' => $textWidget->category_id,
                'updated_at' => $textWidget->updated_at,
                'created_at' => $textWidget->created_at,
            ];

            $textWidgetsData[] = $textWidgetData;
        });

        $textWidgetsJson = json_encode($textWidgetsData);

        $textWidgetsDirectoryPath = storage_path('app/exports/text_widgets');

        if (!file_exists($textWidgetsDirectoryPath)) {
            mkdir($textWidgetsDirectoryPath, 0775, true);
        }

        file_put_contents($textWidgetsDirectoryPath . '/text_widgets.json', $textWidgetsJson);

        $images = \App\Models\Image::all();

        $imageData = [];

        $images->each(function ($image) use (&$imageData) {

            $category = \App\Models\ImageCategory::find($image->category_id);

            $imageData[] = [
                'id' => $image->id,
                'description' => $image->description,
                'alt' => $image->alt,
                'category' => $category ? $category->name : null,
                'category_id' => $image->category_id,
                'updated_at' => $image->updated_at,
                'created_at' => $image->created_at,
                'image' => $image->image,
            ];
        });

        $imagesJson = json_encode($imageData);

        $imagesDirectoryPath = storage_path('app/exports/images');

        if (!file_exists($imagesDirectoryPath)) {
            mkdir($imagesDirectoryPath, 0775, true);
        }

        file_put_contents($imagesDirectoryPath . '/images.json', $imagesJson);


        Log::info('Blog articles and settings export completed');

        $beanstalkdHost = env('BEANSTALKD_API');

        $response = Http::post($beanstalkdHost, [
            'name' => 'PostExportJob',
            'payload' => 'PostExportJob-cms-lite001',
        ]);

        // Get the response status code
        $status = $response->status();
        Log::Info('Beanstalkd response status: ' . $status);

        // Get the response body
        $body = $response->body();
        Log::Info('Beanstalkd response body: ' . $body);
    }
}
