@extends('admin.template')
@section('main')

    <div class="card card-body ">
        <dl class="row">
           <dt class="col-md-5 text-lg-right">Name</dt>
           <dd class="col-md-7">{{ $level->Name }}</dd>
        </dl>

    <pre>{{ print_r($level->toArray()) }}</pre>
    </div>
@endsection
