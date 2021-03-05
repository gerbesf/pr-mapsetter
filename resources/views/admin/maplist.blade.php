@extends('admin.template')
@section('main')

    <div class="card ">

        <div class="card-header">Map list</div>

        <div class="">
            <table class="table shadow-sm mb-0 bg-white  table-hover" >
                <thead class="thead-light">
                <tr>
                    <th>MAP</th>
                    <th>MODS</th>
                    <th>SIZE</th>
                    <th>SKIR</th>
                    <th>AAS</th>
                    <th>INS</th>
                    <th>CNC</th>
                    <th>VH</th>
                </tr>
                </thead>
                @foreach($maps as $map)
                    <tr  >
                        <td class="align-middle">
                            <h5 class="font-weight-bold "> <a href="{{ route('map_configure',[$map->id]) }}"> {{ $map->Name }} </a></h5>
                        </td>
                        <td>
                            @if($map->Ww2) <span class="badge badge-dark">WW2</span> @endif
                            @if($map->Vietnam) <span class="badge badge-danger">Vietnam</span> @endif
                        </td>
                        <td class="align-middle">{{ substr($map->Resolution,0,1) }}KM</td>
                        <td>
                            @if($map->Skirmish)
                                <div>
                                    @if( isset($map->Layouts['skirmish']))
                                        @foreach($map->Layouts['skirmish'] as $tag)
                                            <div title="Skirmish" class=" border rounded bg-white px-1 text-nowrap">
                                                <span class="small text-muted"><b>{{ $tag }}</b></span></div>
                                        @endforeach
                                    @endif
                                </div>
                            @else
                                --
                            @endif
                        </td>
                        <td>
                            @if($map->Aas)
                            <div>
                                @if( isset($map->Layouts['cq']))
                                    @foreach($map->Layouts['cq'] as $tag)
                                        <div title="AAS" class=" border rounded bg-white px-1 text-nowrap">
                                            <span class="small text-muted">AAS-<b>{{ $tag }}</b></span></div>
                                    @endforeach
                                @endif
                            </div>
                            @else
                                --
                            @endif
                        </td>
                        <td>
                            @if($map->Insurgency)
                           {{-- <b>Insurgency</b>--}}
                            <div>
                                    @if( isset($map->Layouts['insurgency']))
                                        @foreach($map->Layouts['insurgency'] as $tag)
                                            <div title="Insurgency" class=" border rounded bg-white px-1 text-nowrap">
                                                <span class="small text-muted">INS-<b>{{ $tag }}</b></span></div>
                                        @endforeach
                                    @endif
                            </div>
                            @else
                                --
                            @endif
                        </td>
                        <td>
                            @if($map->Cnc)
                            <div>
                                    @if( isset($map->Layouts['cnc']))
                                        @foreach($map->Layouts['cnc'] as $tag)
                                            <div title="CNC" class=" border rounded bg-white px-1 text-nowrap">
                                                <span class="small text-muted">CNC-<b>{{ $tag }}</b></span></div>
                                        @endforeach
                                    @endif
                            </div>
                            @else
                                --
                            @endif
                        </td>
                        <td>
                            @if($map->Vehicle)
                            {{--<b>VH</b>--}}
                            <div>
                                <small>
                                    @if( isset($map->Layouts['vehicles']))
                                        @foreach($map->Layouts['vehicles'] as $tag)
                                            <div title="VH" class=" border rounded bg-white px-1 text-nowrap">
                                                <span class="small text-muted">VH-<b>{{ $tag }}</b></span></div>
                                        @endforeach
                                    @endif
                                </small>
                            </div>
                            @else
                                --
                            @endif
                        </td>
                        {{--
                        <td class=">

                        </td>
                        <td class="@if($map->) bg-warning text-dark @else bg-white text-white @endif">

                        </td>
                        --}}{{--  <td class="@if($map->Ww2) bg-success text-white @else bg-white text-white @endif">WW2</td>--}}{{--
                        <td class="@if($map->Cnc) bg-danger text-white @else text-light @endif">

                        </td>
                        <td class="@if($map->Skirmish) bg-info text-white @else  text-light @endif">

                        </td>
                        <td class="@if($map->Vehicle) bg-dark text-white @else text-light @endif">

                        </td>
--}}


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
                       </td>--}}
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
