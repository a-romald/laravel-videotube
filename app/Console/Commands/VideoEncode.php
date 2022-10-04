<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;


class VideoEncode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video-encode:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Video Encosing...';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $low = (new X264('aac'))->setKiloBitrate(500);
        $high = (new X264('aac'))->setKiloBitrate(1000);

        FFMpeg::fromDisk('videos-temp')
            ->open('story_teller.mp4')
            ->exportForHLS()
            ->addFormat($low, function ($filters) {
                $filters->resize(640, 480);
            })
            ->addFormat($high, function ($filters) {
                $filters->resize(1280, 720);
            })
            ->onProgress(function ($progress) {
                $this->info("Progress= {$progress}%");
            })
            ->toDisk('videos-temp')
            ->save('/test/file.m3u8');
    }

}


// php artisan make:command VideoEncode --command=video-encode:start

// php artisan video-encode:start

/*
Progress= 2%  
Progress= 10% 
Progress= 12% 
Progress= 14% 
Progress= 15% 
...
Progress= 96% 
Progress= 98% 
Progress= 99% 
Progress= 100%
*/

// Result: file.m3u8