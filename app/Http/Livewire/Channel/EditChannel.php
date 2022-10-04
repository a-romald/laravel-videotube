<?php

namespace App\Http\Livewire\Channel;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Channel;
use Image;


class EditChannel extends Component
{
    
    use AuthorizesRequests;
    use WithFileUploads;

    public $channel;
    public $image;


    protected function rules()
    {
        return [
            'channel.name' => 'required|max:255|unique:channels,name,' . $this->channel->id,
            'channel.slug' => 'required|max:255|unique:channels,slug,' . $this->channel->id,
            'channel.description' => 'nullable|max:1000',
            'image' => 'nullable|image|max:1024',
        ];
    }


    public function mount(Channel $channel)
    {
        $this->channel = $channel;
    }


    public function render()
    {
        return view('livewire.channel.edit-channel');
    }


    public function update()
    {
        $this->authorize('update', $this->channel);
        $this->validate();

        $this->channel->update([
            'name' => $this->channel->name,
            'slug' => $this->channel->slug,
            'description' => $this->channel->description,
        ]);

        // file upload
        /*if ($this->image) {
            //save the image
            $image = $this->image->storeAs('public/images', $this->channel->uid . '.png');
            //update file path in the db
            $this->channel->update([
                'image' => $image
            ]);
        }*/

        // file upload anf resize
        if ($this->image) {
            //save the image
            $image = $this->image->storeAs('public/images', $this->channel->uid . '.png');
            //dd($image); // public/images/1632680aaaab88.png
            $imageImage = explode('/', $image)[2];
            //resize and convert to png
            $img = Image::make(storage_path() . '/app/'  . $image)
                ->encode('png')
                ->fit(80, 80, function ($constraint) {
                    $constraint->upsize();
                })->save();

            //update file path in the db
            $this->channel->update([
                'image' => $imageImage
            ]);
        }

        session()->flash('message', 'Channel updated');

        return redirect()->route('channel.edit', ['channel' => $this->channel->slug]);
    }

}


// https://dev.to/abrardev99/laravel-temporary-url-for-local-storage-driver-50of
// http://yt.loc/storage/images/1632680aaaab88.png
