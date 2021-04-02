@extends('admin.template')
@section('main')

    <h4 class="py-4"> <span class="fa fa-cog"></span> Maintence</h4>


    <div class="card">
        <div class="card-header">Project Reality Server</div>

            @if( !$server )

            <div class="card-body">
                <div class="lead"> No have server</div>
            </div>
            <div class="card-footer">

                <div><a href="/admin/configure" class="btn btn-success btn-sm">Click here</a> to select a <b>ProjectReality Server</b></div>
            </div>
            @else

            <div class="card-body">
                <h5 class="font-weight-bold m-0"> <span class="fa fa-server "></span> {{ $server->name }}</h5>
            </div>
            <div class="card-footer">
                <div><a href="/admin/configure" class="btn btn-dark btn-sm">Change Server</a></div>
            </div>
            @endif

    </div>

    <br>

    <div class="card">
        <div class="card-header">Maplist</div>

        @if( count($maps) == 0)

            <div class="card-body">
                <div class="lead"> No have maps on database</div>
            </div>
            <div class="card-footer">

                <div><a href="{{ route('update_levels') }}" class="btn btn-success btn-sm">Click here</a> to update maplist from <b>ProjectReality / Maps</b></div>
            </div>
        @else

            <div class="card-body">
                <h5 class="font-weight-bold m-0"> <span class="fa fa-server "></span>  {{ count($maps) }} Maps on Database </h5>
            </div>
            <div class="card-footer">
                <div><a href="{{ route('update_levels') }}" class="btn btn-dark btn-sm">Update Maps</a></div>
            </div>
        @endif

    </div>








@endsection
