<div style="position: relative;">

    <img class="card-img-top" src="{{asset( $video->thumbnail)}}" alt="Card image cap"
        style="height: 170px; width:300px">

    <div class="badge badge-dark" style="position: absolute; bottom:8px; right:16px;">
        {{ $video->duration }}
    </div>

</div>