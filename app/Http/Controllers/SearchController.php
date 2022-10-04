<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Video;


class SearchController extends Controller
{

    public function search(Request $request)
    {
        if ($request->input('query')) 
        {
            $q = $request->input('query');

            $videos = Video::query()
                ->where('title', 'LIKE', "%{$q}%")
                ->orWhere('description', 'LIKE', "%{$q}%")
                ->get();
        } 
        else 
        {
            $videos = [];
        }

        return view('search', compact('videos'));
    }

}
