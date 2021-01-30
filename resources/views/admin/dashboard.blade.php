@extends('admin.template')
@section('main')

    @if( !$server )
        <div class="card card-body m-4 border-danger">
            <span class="text-uppercase small text-muted mb-2">server</span>
            <h6 class="font-weight-bold m-0">
                <div class="fa fa-server text-danger"></div>
                <span class="px-1">Select an server</span>
            </h6>

        </div>
    @else
        <div class="card card-body m-4 border-success">
            <span class="text-uppercase small text-muted mb-2">server</span>
            <h6 class="font-weight-bold m-0">
                <div class="fa fa-server text-success"></div>
                <span class="px-1">{{ $server->name }}</span>
            </h6>
            IP: {{ $server->ip }}
        </div>
    @endif


    @if( count($maps) == 0)
        <div class="card card-body m-4 border-danger">
            <span class="text-uppercase small text-muted mb-2">maps</span>
            <h6 class="font-weight-bold m-0">
                <div class="fa fa-map text-danger"></div>
                <span class="px-1">Sync Map database</span>
            </h6>

        </div>
    @else
        <div class="card card-body m-4 border-danger">
            <span class="text-uppercase small text-muted mb-2">maps</span>
            <h6 class="font-weight-bold m-0">
                <div class="fa fa-map text-success"></div>
                <span class="px-1">
                    {{ count($maps) }} Maps on Database
                </span>
            </h6>

        </div>
    @endif



@endsection
