## About Project

Creating Laravel Videotube project using Livewire and video encoding with FFMPEG and Laravel FFMpeg (https://github.com/protonemedia/laravel-ffmpeg).

This project allows to upload video files in mp4 format and encode them into HLS (HTTP Live Streaming). So content is divided into fragments, written in .ts files. An index file is also created containing links to fragments saved as an .m3u8 file. Then this project allows to view uploaded files with videojs video player, subscribe to channel with videos, also count views of video, vote with likes and comment video.

## Installation

- clone or download project
- cd laravel-videotube
- cp .env.example .env
- create mysql database and config DB_DATABASE, DB_USERNAME, DB_PASSWORD in .env file
- Install FFMpeg (https://ffmpeg.org/download.html)
- run `composer install`
- run `npm install`
- run `npm run build`
- run `php artisan migrate`
- run `php artisan key:generate`
- check if QUEUE_CONNECTION=database in .env file
- run `php artisan storage:link`
- run `php artisan serve`
- run `php artisan queue:work --tries=3` in other terminal
- run application http://127.0.0.1:8000
- register user account and channel, then upload and convert video from .mp4 to HLS .m3u8 format on '/videos/{channel}/create' page.
