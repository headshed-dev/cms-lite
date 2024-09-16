<?php

namespace App\Jobs;

use App\Models\Image;
use App\Models\ImageCategory;
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


    protected function upsertImageRecord($link, $altText)
    {
        Log::debug('Upserting Image Record');
        Log::debug('Link: ' . $link);
        Log::debug('Alt Text: ' . $altText);

        // Check if image record exists in images table
        $image = Image::where('image', $link)->first();

        if ($image) {

            Log::debug('Image record found: ' . $image->id);
            $image->description = $altText;
            $image->alt = $altText;
            $image->save();

        } else {

            $imageCategory = ImageCategory::where('name', 'Default')->first();
            if (!$imageCategory) {
                Log::debug('No image category found, creating new one.');
                $imageCategory = new ImageCategory();
                $imageCategory->name = 'Default';
                $imageCategory->save();
                Log::debug('New image category created: ' . $imageCategory->id);
            }


            Log::debug('No image record found, creating new one.');
            $image = new Image();
            $image->image = $link;
            $image->alt = $altText;
            $image->description = $altText;
            $image->category_id = $imageCategory->id;
            $image->save();
            Log::debug("message");('New image record created: ' . $image->id);
        }



    }


    protected function remediateMarkdownImageLinks(MarkdownCard $model)
    {
        Log::debug('Model ID in remediate function: ' . $this->model->id);
        $content = $model->content;
        Log::debug('Content: ' . $content);

        // ![hands over hands](/storage/images/01HV3G3GBHE9GGBNN6G3X54DXX.svg)

        preg_match_all('/!\[.*?\]\((.*?)\)/', $content, $matches);
        $links = $matches[0];
        // Log::debug('Extracted Links: ' . implode(', ', $links));
        Log::debug('found ' . count($links) . ' links');

        foreach ($links as $link) {
            Log::debug('Link: ' . $link);
            // ![your choice](/storage/images/01HTZHNTEF7NG3Z71J5CSZSMDZ.png)

            // /storage/
            // preg_match('/!\[(.*?)\]\((.*?)\)/', $link, $linkMatches);

            if (preg_match('/!\[(.*?)\]\(\/storage\/(.*?)\)/', $link, $linkMatches)) {
                $altText = $linkMatches[1];
                $imagePath = $linkMatches[2];
                Log::debug('Alt Text: ' . $altText);
                Log::debug('Image Path: ' . $imagePath);
                $this->upsertImageRecord($imagePath, $altText);
            } else {
                Log::error('HERE ... No match found for link: ' . $link);

                // [2024-09-16 12:19:50] local.ERROR: No match found for link: ![](http://laravel.test/storage/images/mCSGoU8Z216pU8deB7aTzhn7ISB0A1QGCcTkxhS9.png)

                // Strip out the hypertext link and keep the path
                if (preg_match('/!\[(.*?)\]\((https?:\/\/.*?\/storage\/.*?)\)/', $link, $httpMatches)) {
                    $remediatedUrl = parse_url($httpMatches[2], PHP_URL_PATH);
                    $fullRemediatedUrl = '![](' . $remediatedUrl . ')';
                    Log::debug('Remediated URL: ' . $fullRemediatedUrl);
                    // $this->upsertImageRecord($remediatedUrl, $altText);

                    $content = str_replace($link, $fullRemediatedUrl, $content);
                    $model->content = $content;
                    $model->save();




                } else {
                    Log::error('STILL no match found for link: ' . $link);
                }




            }
            // $altText = $linkMatches[1];
            // $imagePath = $linkMatches[2];
            // Log::debug('Alt Text: ' . $altText);
            // Log::debug('Image Path: ' . $imagePath);



        }


    }

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
        Log::debug('>>HERE>> UpsertMarkdownCardJob');
        Log::debug('Model Class: ' . get_class($this->model));

        $this->remediateMarkdownImageLinks($this->model);
    }
}
