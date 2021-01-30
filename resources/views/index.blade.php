@extends('template')
@section('main')

    <div class="text-center">
        <a href="/" class=" btn btn-sm btn-primary">Generator</a>
        <a href="/history" class="  btn btn-sm btn-light">History</a>
    </div>
    <h4 class="text-center font-weight-bold text-uppercase mb-0 py-2">{{ env('APP_NAME') }} - Votemap Generator</h4>

    @livewire('setnexter')

@endsection
