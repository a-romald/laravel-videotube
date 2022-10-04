<?php

namespace App\Http\Livewire\Video;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

use App\Models\Video;
use App\Models\Channel;


class AllVideo extends Component
{
    
    use WithPagination;
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';

    public $channel;


    public function mount(Channel $channel)
    {
        $this->channel = $channel;
    }


    public function render()
    {
        return view('livewire.video.all-video')
            ->with('videos', auth()->user()->channel->videos()->paginate(3))
            ->extends('layouts.app');
    }


    public function delete(Video $video)
    {
        //check if user is allowed to delete the video
        $this->authorize('delete', $video);

        //delete folder 
        $deleted = Storage::disk('videos')->deleteDirectory($video->uid);

        if ($deleted) {
            $video->delete();
        }

        return back();
    }

}
