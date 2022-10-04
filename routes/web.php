<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // if logged in - channels that user subscribed to
    if (Auth::check()) {
        $channels = Auth::user()->subscribedChannels()->with('videos')->get()->pluck('videos');
    } else {
        //else all vidoes
        $channels = App\Models\Channel::get()->pluck('videos');
    }

    return view('welcome', compact('channels'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/channel/{channel}/edit', [App\Http\Controllers\ChannelController::class, 'edit'])->name('channel.edit');

    Route::get('/videos/{channel}/create', 'App\Http\Livewire\Video\CreateVideo')->name('video.create');
    Route::get('/videos/{channel}/{video}/edit', 'App\Http\Livewire\Video\EditVideo')->name('video.edit');
    Route::get('/videos/{channel}', 'App\Http\Livewire\Video\AllVideo')->name('video.all');
});

Route::get('/watch/{video}', 'App\Http\Livewire\Video\WatchVideo')->name('video.watch');

Route::get('/channels/{channel}', [App\Http\Controllers\ChannelController::class, 'index'])->name('channel.index');

Route::get('/search/', [App\Http\Controllers\SearchController::class, 'search'])->name('search');
