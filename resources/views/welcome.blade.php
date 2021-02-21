@extends('template')
@section('main')
    {{--
        <div class="text-center">
            <a href="/" class=" btn btn-sm btn-primary">Generator</a>
            <a href="/history" class="  btn btn-sm btn-light">History</a>
        </div>--}}

    <div class="text-center">
        <a href="/history" class="  btn btn-sm btn-light">History</a>
    </div>

    @livewire('setnexter')

@endsection
