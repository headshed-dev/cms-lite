<?php

namespace App\Services\Publish;

use App\Models\Image;

// these models are used to create default categories
// and are referred to and used in the
// getOrCreateCategory function

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\CardCategory;
use App\Models\ImageCategory;
use App\Models\MarkdownCard;
use App\Models\MarkdownCardCategory;
use App\Models\Metadata;
use App\Models\MetadataCategory;
use App\Models\TextWidget;
use App\Models\TextWidgetCategory;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class MarkdownFileService
{

    /**
     * This function takes a string and finds all the markdown images
     * in the string
     *
     * it returns an array of markdown image links
     */
    public function findMarkdownImages($text)
    {
        preg_match_all('/!\[[^\]]+\]\([^)]+\)/', $text, $matches);
        if (!empty($matches[0])) {
            return $matches[0];
        }
        return [];
    }

    /**
     * This function takes a string and splits it into an array of
     * records based on the delimiter for example
     * 3 or more dahses '---'
     *
     * it returns an array of records
     */
    public function extractCards($body, $delimiter) {

        $records = preg_split($delimiter, $body);
        return $records;

    }


    /**
     * This function takes a filename and its diretory path and
     * parses out the front matter and the body of the
     * markdown file
     *
     * it returns the front matter and the
     * body of the markdown file as
     * an array
     */
    public function parseMarkdownFile($fileName, $filesDirectory) {

        $file_data = file_get_contents($filesDirectory . "/" . $fileName);
        if ($file_data === false) {
            echo "Error: Unable to read the file.";
        } else {
            $document = YamlFrontMatter::parse($file_data);
            $matter = $document->matter();
            $body = $document->body();

            return [$matter, $body];
        }
    }










    // public function storeMarkdownCardContent($images, $files_directory, $text, $name) {}


    /**
     * This function takes a model class and a property name and checks if a
     * default category exists for the model if it does it returns the
     * id of the default category if it does not it creates a
     * default category and returns the id of the
     * default category
     */
    public function getOrCreateCategory($modelClass, $propertyName) {
        $defaultCategory = $modelClass::where('name', 'Default')->first();
        if ($defaultCategory) {
            return $defaultCategory->id;
        } else {
            $category = new $modelClass();
            $category->name = 'Default';
            $category->save();
            return $category->id;
        }
    }

    /**
     * This function takes a filename path and the category id of the image and
     * stores the image in storage and the image details into Image model
     *
     * it returns the markdown image link to the stored image
     */
    public function storeImageFile($filePath, $imageCategoryId)
    {
        $fileNameWithExtension = pathinfo($filePath, PATHINFO_BASENAME);

        try {
            $fileContent = file_get_contents($filePath);
            if ($fileContent === false) {
                throw new \Exception("Failed to read the file.");
            }

            $randomString = strtoupper(Str::random(26));
            $fileName = $randomString . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
            $stored = Storage::put("public/images/{$fileName}", $fileContent);
            if ($stored === false) {
                throw new \Exception("Failed to store the file.");
            }
        } catch (\Exception $e) {
            throw new \Exception("An error occurred while storing the file: " . $e->getMessage());
        }

        $image_filename = 'images/' . $fileName;
        $image = new Image();
        $image->image = $image_filename;
        $image->alt = $fileNameWithExtension;
        $image->description = $fileNameWithExtension;
        $image->category_id = $imageCategoryId;
        $image->save();

        // the actual path to the file in the web app
        return ("![](/storage/images/{$fileName})");
    }

    /**
     * This function accepts description, keywords, name and metadata category
     * id and stores the metadata content into Metadata model
     */
    public function storeMetadataContent($description, $keywords, $name, $metadataCategoryId)
    {

        $existingMetadata = Metadata::where('name', $name)->first();
        if ($existingMetadata) {
            $existingMetadata->description = $description;
            $existingMetadata->keywords = $keywords;
            $existingMetadata->metadata_category_id = $metadataCategoryId;
            $existingMetadata->save();
            print "\nUpdated metadata [$name]\n";
            return;
        }

        print "\nSaving new metadata [$name]\n";
        //save content to database
        $metadata = new Metadata();
        $metadata->name = $name;
        $metadata->description = $description;
        $metadata->keywords = $keywords;
        $metadata->metadata_category_id = $metadataCategoryId;
        $metadata->save();
    }

    /**
     * This function accepts content, name and text widget category id
     * and stores the text widget content into TextWidget model
     */
    public function storeTextWidgetContent($text, $name, $textWidgetCategoryId)
    {
        $existingTextWidget = TextWidget::where('description', $name)->first();
        if ($existingTextWidget) {
            $existingTextWidget->content = $text;
            $existingTextWidget->category_id = $textWidgetCategoryId;
            $existingTextWidget->save();
            print "\nUpdated text widget [$name]\n";
            return;
        }

        print "\nSaving new text widget [$name]\n";
        //save content to database
        $textWidget = new TextWidget();
        $textWidget->content = $text;
        $textWidget->description = $name;
        $textWidget->category_id = $textWidgetCategoryId;
        $textWidget->save();
    }



}
