@extends('admin.template')
@section('main')
    {{--@livewire('setnexter')--}}
    <table class="table bg-white table-sm table-hover" style="font-size: 12px">
        <thead>
        <tr>
            <th>MAP</th>
            <th>SIZE</th>
            <th>AAS</th>
            <th>INS</th>
            <th>CNC</th>
            <th>SKIR</th>
            <th>VH</th>
        </tr>
        </thead>
        @foreach($maps as $map)
            <tr  >
                <td>{{ $map->Name }}
                    @if($map->Ww2) <span class="badge badge-dark">WW2</span> @endif
                    @if($map->Vietnam) <span class="badge badge-danger">Vietnam</span> @endif
                </td>
                <td>{{ substr($map->Resolution,0,1) }} KM</td>
                <td class="@if($map->Aas) bg-primary text-white @else bg-white text-white @endif">
                    <b>AAS</b>
                    <div>
                        <small>
                            @if( isset($map->Layouts['cq']))
                                @foreach($map->Layouts['cq'] as $sizze)
                                    {{ $sizze }}
                                @endforeach
                            @endif
                        </small>
                    </div>
                </td>
                <td class="@if($map->Insurgency) bg-warning text-dark @else bg-white text-white @endif">
                    <b>Insurgency</b>
                    <div>
                        <small>
                            @if( isset($map->Layouts['insurgency']))
                                @foreach($map->Layouts['insurgency'] as $sizze)
                                    {{ $sizze }}
                                @endforeach
                            @endif
                        </small>
                    </div>
                </td>
              {{--  <td class="@if($map->Ww2) bg-success text-white @else bg-white text-white @endif">WW2</td>--}}
                <td class="@if($map->Cnc) bg-danger text-white @else text-light @endif">
                    <b>Cnc</b>
                    <div>
                        <small>
                            @if( isset($map->Layouts['cnc']))
                                @foreach($map->Layouts['cnc'] as $sizze)
                                    {{ $sizze }}
                                @endforeach
                            @endif
                        </small>
                    </div>
                </td>
                <td class="@if($map->Skirmish) bg-info text-white @else  text-light @endif">
                    <b>Skirmish</b>
                    <div>
                        <small>
                            @if( isset($map->Layouts['skirmish']))
                                @foreach($map->Layouts['skirmish'] as $sizze)
                                    {{ $sizze }}
                                @endforeach
                            @endif
                        </small>
                    </div>
                </td>
                <td class="@if($map->Vehicle) bg-dark text-white @else text-light @endif">
                    <b>Vehicles Warface</b>
                    <div>
                        <small>
                            @if( isset($map->Layouts['vehicles']))
                                @foreach($map->Layouts['vehicles'] as $sizze)
                                    {{ $sizze }}
                                @endforeach
                            @endif
                        </small>
                    </div>
                </td>



             {{--  --}}{{-- <td>
                    <img src="https://www.realitymod.com/mapgallery/images/maps/{{ $map->Image }}/tile.jpg" class="rounded" width="128">
                </td>--}}{{--
                <td>
                    <h5 class="font-weight-bold m-0">{{ $map->Name }}</h5>
                    <div class="badge badge-info"  style="background-color: {{ $map->Color }}">Color </div>
                    <div class="badge badge-warning" > {{ $map->Key }}</div>
                    <div><div class="small" > Map Size:  {{ $map->Size }}--}}{{-- | {{ substr($map->Resolution,0,1) }}--}}{{-- KM</div> </div>
                </td>
                <td>
                    @foreach($map->Layouts as $gamemode=>$layout)
                        <div><b>{{ __('app.'.$gamemode) }}</b></div>
                        @foreach($layout as $size)
                            <small class="text-muted"> <span class="fa fa-circle"></span> {{ $size }}</small>
                        @endforeach
                    @endforeach
                </td>
            </tr>--}}
        @endforeach
    </table>
@endsection
