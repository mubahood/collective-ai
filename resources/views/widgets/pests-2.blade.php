<a class="card  mb-4 mb-md-5 border-0" href="{{ admin_url('pests-and-diseases') }}" title="View all reports"
    style="color: black;">
    <!--begin::Header-->
    <div class="d-flex justify-content-between px-3 pt-2 px-md-4 border-bottom">
        <h4 style="line-height: 1; margrin: 0; " class="fs-22 fw-800">
            Recently reported pest & diseases
        </h4>
    </div>
    <div class="card-body py-2 py-md-3">
        @if (count($data) == 0)
            <div class="text-center">
                <h5 class="text-dark">No pests & diseases reported yet.</h5>
                <hr>
                <p>Open the app and report any pests & diseases you see</p>
            </div>
        @else
            @foreach ($data as $item)
                <div class="row  pl-4 mt-3" style="line-height:16px;">
                    <img src="{{ url('storage/' . $item->photo) }}" width="50" height="50" class="rounded mr-3"
                        alt="">
                    <p>
                        <strong>{{ $item->name }}</strong>
                        @if ($item->user != null)
                            <br>
                            <small>Reported by: {{ $item->user->name }}</small>
                        @endif
                        <small class="d-block text-primary">{{ $item->created_at->diffForHumans() }}</small>
                    </p>
                </div>
                <hr style="margin: 0; ">
            @endforeach
        @endif
    </div>
</a>
