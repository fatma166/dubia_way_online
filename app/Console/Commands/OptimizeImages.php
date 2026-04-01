<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class OptimizeImages extends Command
{
    protected $signature = 'images:optimize';

    protected $description = 'Optimize and compress all images';

    public function handle()
    {
        ini_set('memory_limit', '512M');
        $manager = new ImageManager(new Driver());

        $files = glob(public_path('images/banner/*.{jpg,jpeg,png,webp}'), GLOB_BRACE);

        foreach ($files as $file) {

            $this->info("Optimizing: " . $file);

            $image = $manager->read($file);

            $image->scale(width:1200);

            $image->save($file, quality:80);
             unset($image); // مهم لتحرير الذاكرة
             gc_collect_cycles();

        }

        $this->info("Images optimized successfully.");

        return Command::SUCCESS;
    }
}