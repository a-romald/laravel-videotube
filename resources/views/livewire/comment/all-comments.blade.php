<div>
    <!-- not recursive comments -->
    <!--@foreach ($video->comments as $comment)
        <div class="media my-3">
            <img class="mr-3 rounded-circle" src="{{ asset('/images/' . $comment->user->channel->image)}}"
                alt="Generic placeholder image">
            <div class="media-body">
                <h5 class="mt-0">
                    {{$comment->user->name}}
                    <small class="text-muted">{{$comment->created_at->diffForHumans()}} </small>
                </h5>
                {{$comment->body}}
            </div>
        </div>
    @endforeach-->

    @include('includes.recursive', [ 'comments' => $video->comments()->latestFirst()->get() ])
</div>
