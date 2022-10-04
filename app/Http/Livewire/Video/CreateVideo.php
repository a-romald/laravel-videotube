<?php

namespace App\Http\Livewire\Video;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Channel;
use App\Models\Video;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\CreateThumbnailFromVideo;


class CreateVideo extends Component
{
    
    use WithFileUploads;

    public Channel $channel;
    public Video $video;
    public $videoFile;
    protected $rules = [
        'videoFile' => 'required|mimes:mp4|max:1228800' // 1200 mb
        //'videoFile' => 'max:1000000|required|file|mimetypes:video/mp4,video/mpeg,video/x-matroska',
    ];


    public function mount(Channel $channel)
    {
        $this->channel = $channel;
    }


    public function render()
    {
        return view('livewire.video.create-video')->extends('layouts.app');
    }


    public function fileCompleted()
    {
        // validation
        $this->validate();
        //save the file
        $path = $this->videoFile->store('videos-temp');

        //create video record in sb
        $this->video = $this->channel->videos()->create([
            'title' => 'untitled',
            'description' => 'none',
            'uid' => uniqid(true),
            'visibility' => 'private',
            'path' => explode('/', $path)[1],
        ]);
        //disptach jobs
        ini_set('max_execution_time', 180); //3 minutes
        CreateThumbnailFromVideo::dispatch($this->video);
        ConvertVideoForStreaming::dispatch($this->video);
        //redirect to edit route
        return redirect()->route('video.edit', [
            'channel' => $this->channel,
            'video' => $this->video,
        ]);
    }


}

