<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Category;

class GenerateCategoryPlaceholders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:category-placeholders {--force : Overwrite existing images}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate simple placeholder images for categories and save them to storage/app/public/categories';

    public function handle()
    {
        if (!extension_loaded('gd')) {
            $this->error('GD extension is required to generate images.');
            return 1;
        }

        $disk = Storage::disk('public');
        $dir = 'categories';
        if (! $disk->exists($dir)) {
            $disk->makeDirectory($dir);
            $this->info("Created storage disk directory: {$dir}");
        }

        $categories = Category::all();
        if ($categories->isEmpty()) {
            $this->info('No categories found.');
            return 0;
        }

        foreach ($categories as $category) {
            $filename = $dir.'/' . Str::slug($category->slug ?: $category->name) . '.jpg';

            if ($disk->exists($filename) && ! $this->option('force')) {
                $this->line("Skipping {$category->name} (image exists). Use --force to overwrite.");
                continue;
            }

            $width = 800;
            $height = 450;
            $img = imagecreatetruecolor($width, $height);
            // background color
            $bg = imagecolorallocate($img, rand(230, 255), rand(230, 255), rand(230, 255));
            imagefilledrectangle($img, 0, 0, $width, $height, $bg);
            // title text
            $textColor = imagecolorallocate($img, 40, 40, 40);
            $fontSize = 5; // built-in font
            $text = strtoupper($category->name ?: 'Category');
            $textBoxWidth = imagefontwidth($fontSize) * strlen($text);
            $x = (int)(($width - $textBoxWidth) / 2);
            $y = (int)($height / 2) - 8;
            imagestring($img, $fontSize, $x, $y, $text, $textColor);

            $tmp = sys_get_temp_dir().'/'.Str::random(10).'.jpg';
            imagejpeg($img, $tmp, 85);
            imagedestroy($img);

            $contents = file_get_contents($tmp);
            if ($contents === false) {
                $this->error("Failed to read temporary image for category {$category->name}");
                @unlink($tmp);
                continue;
            }

            $disk->put($filename, $contents);
            @unlink($tmp);

            // update model image field
            $category->image = $filename;
            $category->save();

            $this->info("Generated image for: {$category->name} -> {$filename}");
        }

        $this->info('Done. Use `php artisan storage:link` if public/storage is not linked.');
        return 0;
    }
}
