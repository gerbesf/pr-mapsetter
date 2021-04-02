@extends('admin.template')
@section('main')

    <div class="card ">

        <div class="card-header">Map list</div>

        <div class=" ">
            <table class="table shadow-sm mb-0 bg-white table-hover " >
                <thead class="thead-light">
                <tr>
                    <th>TILE</th>
                    <th>MAP</th>
                    <th>MODS</th>
                    <th>SIZE</th>
                    <th>SETTINGS</th>
               {{--     <th>SKIR</th>
                    <th>AAS</th>
                    <th>INS</th>
                    <th>CNC</th>
                    <th>VH</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($maps as $map)
                    <tr  >
                        {{--<a href="{{ route('map_configure',[$map->id]) }}">  </a>--}}
                        <td  class="align-middle">
                            <img style="max-height: 260px; width: auto!important;" src="https://www.realitymod.com/mapgallery/images/maps/{{ \App\Helper::getImageKeyName( $map->Slug ) }}/tile.jpg" class=" rounded">
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold ">{{ $map->Name }}</div>
                        </td>
                        <td>
                            @if($map->Ww2) <span class="badge badge-dark">WW2</span> @endif
                            @if($map->Vietnam) <span class="badge badge-danger">Vietnam</span> @endif
                        </td>
                        <td class="align-middle">{{ substr($map->Resolution,0,1) }}KM</td>
                        <td>

                            <div class="bg-dark p-3 rounded text-white text-uppercase" style=" max-height: 800px; overflow-y: scroll">

                               {{-- @if($map->Skirmish)
                                    <div class="border-bottom py-3">
                                        @if( isset($map->Layouts['skirmish']))
                                                <div title="Skirmish" class=" text-nowrap">
                                                    <div class=" t"> Skirmish </div>
                                                    @foreach($filters[0]->settings as $sett)
                                                        @livewire('admin.map-checkbox',[$map->Key,$sett['code'],'Skirmish' ])
                                                    @endforeach
                                                </div>

                                        @endif
                                    </div>
                                @endif--}}
                                @if($map->Aas)
                                        <div class="border-bottom py-3">
                                        @if( isset($map->Layouts['cq']))
                                                <div title="AAS" class=" text-nowrap">
                                                    <div class=" "> AAS </div>
                                                    @foreach($filters[0]->settings as $sett)
                                                        @livewire('admin.map-checkbox',[$map->Key,$sett['code'],'Aas' ])
                                                    @endforeach
                                                </div>


                                        @endif
                                    </div>
                                @endif
                                @if($map->Insurgency)
                                    <div class="border-bottom py-3">
                                        @if( isset($map->Layouts['insurgency']))
                                                <div title="AAS" class=" text-nowrap">
                                                    <div class=" "> Insurgency </div>
                                                    @foreach($filters[0]->settings as $sett)
                                                        @livewire('admin.map-checkbox',[$map->Key,$sett['code'],'Insurgency' ])
                                                    @endforeach
                                                </div>

                                        @endif
                                    </div>
                                @endif

                                @if($map->Cnc)
                                    <div class="border-bottom py-3">
                                        @if( isset($map->Layouts['cnc']))
                                                <div title="AAS" class=" text-nowrap">
                                                    <div class=" "> CNC </div>
                                                    @foreach($filters[0]->settings as $sett)
                                                        @livewire('admin.map-checkbox',[$map->Key,$sett['code'],'Cnc' ])
                                                    @endforeach
                                                </div>

                                        @endif
                                    </div>
                                @endif

                                @if($map->Vehicle)
                                    <div class="border-bottom py-3">
                                        @if( isset($map->Layouts['vehicles']))
                                                <div title="AAS" class=" text-nowrap">
                                                    <div class=" "> Vehicle</div>
                                                    @foreach($filters[0]->settings as $sett)
                                                        @livewire('admin.map-checkbox',[$map->Key,$sett['code'],'Vehicle' ])
                                                    @endforeach
                                                </div>

                                        @endif
                                    </div>
                                @endif
                            </div>

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

                    {{--   <tr>
                           <td colspan="8">
                               @foreach($filters[0]->settings as $sett)
                                   <div>{{ print_r($sett) }}</div>
                               @endforeach

                           </td>
                       --}}{{--    <td></td>
                           <td colspan="2">

                           </td>
                           <td colspan="">s</td>
                           <td colspan="5">s</td>--}}{{--
                       </tr>--}}
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
