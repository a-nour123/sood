<div class="sidebar-menu-list">
    <div class="list-group list-group-filters">
        <div class="tab CategoryList" id="tabs">
            @foreach ($assessments as $assessment)
                <button class="list-group-item list-group-item-action tablinks sideNavBtn {{$loop->first ?'active':''}}"
                        data-name="{{$assessment->name}}" id="{{ $assessment ->id }}">
                    {{ $assessment->name }}
                </button>
            @endforeach
        </div>
    </div>


    <div class="customPgination" style="width: 100px;margin: auto">
        {!! $assessments->links('vendor.pagination.simple-default') !!}
        {{--        <input type="hidden" value="1" id="currentPage">--}}
        {{--        <input type="hidden" value="10" id="lastPage">--}}
        {{--        <button id="PrevDocPage" class="btn btn-primary " style="width: 30px;height: 25px;text-align: center;padding: 5px">&#8249;</button>--}}
        {{--        <button id="NexDocPage" class="btn btn-primary " style="width: 30px;height: 25px;text-align: center;padding: 5px;">&#8250;</button>--}}
    </div>


</div>
