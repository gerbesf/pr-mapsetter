<div>

    <h4>Votemap</h4>
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-4">
                <a  class="btn text-white btn-success btn-circle">1</a>
                <p><small>Config</small></p>
            </div>
            <div class="stepwizard-step col-xs-4">
                <a class="btn text-white @if($bread_nivel==2) btn-success @else  btn-default @endif btn-circle"  @if($bread_nivel<=2) disabled="disabled" @endif>2</a>
                <p><small>Votemap</small></p>
            </div>
            <div class="stepwizard-step col-xs-4">
                <a class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Confirmation</small></p>
            </div>
        </div>
    </div>

    <form>

        @if(!$sorteado)
        <div class="card">
            <div class="card-header">
                Votação de mapas {{ env('APP_NAME') }}
            </div>
            <div class="card-body">

                    <div class=" rounded p-2 py-3">
                        <div class="rounded px-2 text-uppercase text-muted border-bottom">Layout</div>
                        <div class="row pb-0 m-2">
                            <div class="col-md-2">
                                <label class="form-check pb-0 mb-0" wire:click="setMode('Aas')">
                                    <input class="form-check-input"  wire:model="gamemode" name="gamemode" type="radio" value="Aas">
                                    <span class="form-check-label"> AAS </span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check pb-0 mb-0" wire:click="setMode('Cnc')">
                                    <input class="form-check-input"  wire:model="gamemode" name="gamemode" type="radio" value="Cnc">
                                    <span class="form-check-label"> Cnc </span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check pb-0 mb-0" wire:click="setMode('Skirmish')">
                                    <input class="form-check-input"  wire:model="gamemode" name="gamemode" type="radio" value="Skirmish">
                                    <span class="form-check-label"> Skirmish </span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check pb-0 mb-0" wire:click="setMode('Vehicle')">
                                    <input class="form-check-input"  wire:model="gamemode" name="gamemode" type="radio" value="Vehicle">
                                    <span class="form-check-label"> Vehicle </span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="form-check pb-0 mb-0" wire:click="setMode('Insurgency')">
                                    <input class="form-check-input"  wire:model="gamemode" name="gamemode" type="radio" value="Insurgency">
                                    <span class="form-check-label"> Insurgency </span>
                                </label>
                            </div>
                        </div>


                        @if( in_array($gamemode,['Aas','Skirmish','Cnc']))
                            <div class="rounded px-2 text-uppercase text-muted border-bottom">Mods</div>
                            <div class="row pb-0 m-2">
                                <div class="col-md-2">
                                    <label class="form-check pb-0 mb-0" wire:click="setMapMode('All')">
                                        <input class="form-check-input" wire:model="gamemap" name="gamemap" type="radio" value="All">
                                        <span class="form-check-label"> All </span>
                                    </label>
                                </div>
                                @if($this->index_mode!='cnc')
                                    <div class="col-md-2">
                                        <label class="form-check pb-0 mb-0" wire:click="setMapMode('Ww2')">
                                            <input class="form-check-input" wire:model="gamemap" name="gamemap" type="radio" value="Ww2">
                                            <span class="form-check-label"> WW2 </span>
                                        </label>
                                    </div>
                                @endif
                                <div class="col-md-2">
                                    <label class="form-check pb-0 mb-0" wire:click="setMapMode('Vietnam')">
                                        <input class="form-check-input" wire:model="gamemap" name="gamemap" type="radio" value="Vietnam">
                                        <span class="form-check-label"> Vietnam </span>
                                    </label>
                                </div>
                            </div>
                        @endif

                        @if($this->index_mode != 'skirmish' &&  $this->index_mode != 'vehicles' && $this->index_mode != 'cnc' && ! in_array( $this->gamemap, ['Ww2','Vietnam']))
                            {{-- <div class="row no-gutters">
                                 <div class="col-md-6">

                                     <div class="rounded px-2 text-uppercase text-muted border-bottom">Map size</div>
                                     <div class="row pb-0 m-2">
                                         <div class="col-md-4">
                                             <label class="form-check pb-0 mb-0" wire:click="setMapSize('2')">
                                                 <input class="form-check-input" wire:model="mapsize" name="mapsize" type="radio" value="2">
                                                 <span class="form-check-label"> 2KM </span>
                                             </label>
                                         </div>
                                         <div class="col-md-4">
                                             <label class="form-check pb-0 mb-0" wire:click="setMapSize('4')">
                                                 <input class="form-check-input" wire:model="mapsize" name="mapsize" type="radio" value="4">
                                                 <span class="form-check-label"> 4KM </span>
                                             </label>
                                         </div>
                                         <div class="col-md-4">
                                             <label class="form-check pb-0 mb-0" wire:click="setMapSize('8')">
                                                 <input class="form-check-input" wire:model="mapsize" name="mapsize" type="radio" value="8">
                                                 <span class="form-check-label"> 8KM </span>
                                             </label>
                                         </div>
                                     </div>

                                 </div>
                                 <div class="col-md-6">--}}
                            <div class="rounded px-2 text-uppercase text-muted border-bottom">Players</div>

                            <div class="row pb-0 m-2">
                                <div class="col-md-4">
                                    <label class="form-check pb-0 mb-0" wire:click="setPlayerSize('low')">
                                        <input class="form-check-input" wire:model="players_size" name="players_size" type="radio" value="low">
                                        <span class="form-check-label"> Low </span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-check pb-0 mb-0" wire:click="setPlayerSize('medium')">
                                        <input class="form-check-input" wire:model="players_size" name="players_size" type="radio" value="medium">
                                        <span class="form-check-label"> Medium </span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-check pb-0 mb-0" wire:click="setPlayerSize('high')">
                                        <input class="form-check-input" wire:model="players_size" name="players_size" type="radio" value="high">
                                        <span class="form-check-label"> High </span>
                                    </label>
                                </div>
                            </div>
                            {{--   </div>
                           </div>--}}

                        @endif
                    </div>
            </div>
        </div>
        @endif

        @if($gamemode)
            @if($sorteado)

                <div class="row text-center pb-3">
                    <div class="col-4">
                        Layout: <br>
                        <b> {{ $gamemode }}</b>
                    </div>
                    <div class="col-4">
                        Mods: <br>
                        <b> {{ $gamemap }}</b>
                    </div>
                    <div class="col-4">
                        Players: <br>
                        <b> {{ ucfirst($players_size) }}</b>
                    </div>
                </div>


                    @livewire('counter',[$lock_id])

{{--
                <a href="#" class="float-righxt btn btn-sm btn-light" wire:click="setMode('{{ $gamemode }}', false)">  Back</a>--}}
                <div class="" >
                 {{--   <h4 class="font-weight-bold">Results with: </h4>
                    <p class="text-lg-center text-muted small"> Generated on {{ $timestamp }}</p>--}}

                    <div class="row no-gutter" >
                        @foreach($avaliable_maps as $item)
                            @foreach($sorteado as $mapa)
                                @if($mapa['Name']==$item['Name'])
                                    <div class="col-4">
                                        <div class="" style="@if($item['Avaliable']) @else opacity:0.4 @endif">
                                            <div class="text-center small"> {{ $item['Size'] }}KM</div>


                                            <div class=" d-md-none">
                                                <img src="https://www.realitymod.com/mapgallery/images/maps/{{ \App\Helper::getImageKeyName( $item['Slug'] ) }}/tile.jpg" class="mb-2 w-100 rounded">
                                            </div>

                                            <div class="d-none d-md-inline-block">
                                                <img src="https://www.realitymod.com/mapgallery/images/maps/{{ \App\Helper::getImageKeyName( $item['Slug'] ) }}/banner.jpg" class="mb-2  w-100 rounded">
                                            </div>

                                            <div style="min-height: 60px"><b>{{ $item['Name'] }}</b>  </div>
                                            <div class="small">
                                                @foreach($item['Layouts'][$index_mode] as $size=>$name)
                                                    <div class="text-muted "> - {{ $name  }}</div>
                                                @endforeach
                                            </div>
                                        </div>
{{--
                                        <div>{{ ($item['Avaliable']) }}</div>
--}}
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                    <div class="text-center">
                        <code>{{ $votemap_text }}</code>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-block btn-success mt-2 font-weight-bold" type="button" wire:click="confirmVotemap()">Confirm Vote</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-block btn-dark mt-2" type="button" wire:click="generateVotemap( true )">Try Again ({{ $this->totals }} maps avaliable)</button>
                    </div>
                </div>

            @else
                @if(is_array($avaliable_maps) && @count($avaliable_maps))


                    @if($locked)

                        <div class="alert alert-warning  text-center">
                          Votemap is locked  <abbr title="Admin Voting">{{$locked_user}}</abbr> - Expires in: {{ $locked_expires }}
                        </div>

                    @else

                    <div class="pb-2 col-lg-4 py-4 m-auto">
                        <button class="btn btn-block btn-success" type="button" wire:click="generateVotemap()"><h2 class="font-weight-bold m-0">GERADOR</h2> ({{ $this->totals }} maps avaliable)</button>
                    </div>

                    @endif
                @endif
                @if($unavaliable)
                    <div class="alert alert-danger">Não há mapas para votação</div>
                @endif


                <h4 class="pt-4 pb-2">Mapas disponíveis</h4>
                    <div class="row">
                        @if(is_array($avaliable_maps) && @count($avaliable_maps))
                        @foreach($avaliable_maps as $item)
                            @if($item['Avaliable'])
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="card card-body mb-2 @if($item['Avaliable']) border-success @endif" >
                                        <div style=""><b>{{ $item['Name'] }}</b> <span class="float-right small"> {{ $item['Size'] }}KM</span> </div>
                                        <div class="small">
                                            @foreach($item['Layouts'][$index_mode] as $size=>$name)
                                                <span class="badge badge-light">{{ $name  }}</span>
                                            @endforeach
                                        </div>
                                        <div>
                                            {{--{{ $item['Slug'] }}--}}

                                            @if( isset($item['motive']))
                                                <b class="text-danger">Unavaliable</b> <small>{{ $item['motive'] }}</small>
                                            @else
                                                @if(!$item['Avaliable'])
                                                    <b class="text-danger">Unavaliable</b> <small> played {{ $item['LatestGame'] }}</small>
                                                @else
                                                    <b class="text-success">Avaliable</b>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @endif
                    </div>
                <h4 class="pt-4 pb-2">Indisponíveis</h4>
                    <div class="row">
                        @if(is_array($avaliable_maps) && @count($avaliable_maps))
                        @foreach($avaliable_maps as $item)
                            @if(!$item['Avaliable'])
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="card card-body mb-2 @if($item['Avaliable']) border-success @endif" >
                                        <div style=""><b>{{ $item['Name'] }}</b> <span class="float-right small"> {{ $item['Size'] }}KM</span> </div>
                                        <div class="small">
                                            @foreach($item['Layouts'][$index_mode] as $size=>$name)
                                                <span class="badge badge-light">{{ $name  }}</span>
                                            @endforeach
                                        </div>
                                        <div>
                                            {{--{{ $item['Slug'] }}--}}

                                            @if( isset($item['motive']))
                                                <b class="text-danger">Unavaliable</b> <small>{{ $item['motive'] }}</small>
                                            @else
                                                @if(!$item['Avaliable'])
                                                    <b class="text-danger">Unavaliable</b> <small> played {{ $item['LatestGame'] }}</small>
                                                @else
                                                    <b class="text-success">Avaliable</b>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @endif
                    </div>


            @endif

        @endif

        {{--<div class="card card-body mb-2">
            @foreach($notIn as $game_mode=>$mapshistory)
                <pre>{{ print_r($notIn) }}</pre>
                <h4>{{ ucfirst($game_mode) }}</h4>
                @foreach($mapshistory as $map)
                    <div>{{ $map['key'] }} - {{ $map['timestamp'] }}</div>
                @endforeach
                <br>
            @endforeach
        </div>--}}
    </form>

    <span wire:loading> <div class="loading">Loading&#8230;</div></span>

</div>
