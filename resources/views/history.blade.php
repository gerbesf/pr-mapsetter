@extends('template')
@section('main')


    <div class="text-center">
        <a href="/" class="btn btn-sm btn-light">Back</a>
    </div>
    <h4 class="text-center font-weight-bold text-uppercase mb-0 py-2">{{ env('APP_NAME') }} - History</h4>


    <table class="table bg-white border table-sm" style="width: 100%">
        <thead  class="thead-light">
        <tr>
            <th>Nome</th>
            <th>Data</th>
            <th>Diff</th>
        </tr>
        </thead>
        @foreach($list as $item)
            <tr>
                <td class="align-middle">{{ $item->name }}
                    <span class="small  d-lg-inline-block float-md-right text-uppercase">{{ $item->map_mode }}{{--_{{ $item->map_size }}--}}</span>
                </td>
                <td class=" align-middle">{{ \Carbon\Carbon::parse($item->timestamp)->format('d/m H:i') }}</td>
                <td class="align-middle">{{ \Carbon\Carbon::parse($item->timestamp)->diffForHumans() }}</td>
            </tr>
        @endforeach
    </table>

@endsection
