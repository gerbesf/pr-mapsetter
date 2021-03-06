@extends('template')
@section('main')

    <h4>Votemap</h4>
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-4">
                <a class="btn btn-success btn-circle text-white">1</a>
                <p><small>Config</small></p>
            </div>
            <div class="stepwizard-step col-xs-4">
                <a class="btn btn-success btn-circle text-white">2</a>
                <p><small>Votemap</small></p>
            </div>
            <div class="stepwizard-step col-xs-3">
                <a class="btn btn-success btn-circle text-white" >3</a>
                <p><small>Confirmation</small></p>
            </div>
        </div>
    </div>


    @livewire('counter',[request()->get('v')])

    <form action="{{ route('confirm') }}" method="post">
        <input type="hidden" value="{{ request()->get('v') }}" name="v">
        @csrf

        <div class="card ">
            <div class="card-body ">
                @foreach($lock->votemap as $map_name)
                    <div>
                        <label>
                            <input type="radio" required name="winner" value="{{ $map_name }}"> {{ $map_name }}
                        </label>
                    </div>
                @endforeach

                <div>
                </div>
            </div>
            <div class="card-footer">

                <button class="btn btn-primary" type="submit">Confirmar</button>
            </div>
        </div>

    </form>


@endsection
