## About Project

Creating Laravel Videotube using Livewire and video encoding with FFMPEG and Laravel FFMpeg (https://github.com/protonemedia/laravel-ffmpeg).

## Installation

- run `git clone git@github.com:a-romald/laravel-videotube.git && cd laravel-videotube`
- cp .env.example .env
- create mysql database
- Install FFMpeg (https://ffmpeg.org/download.html)
- run `composer install`
- run `npm install`
- run `npm run build`
- run `php artisan migrate`
- run `php artisan artisan key:generate`
- run `php artisan serve`
- run `php artisan queue:work --tries=3` in other terminal
- run application http://127.0.0.1:8000
- register user account and channel, then upload and convert video from .mp4 to HLS .m3u8 format.
