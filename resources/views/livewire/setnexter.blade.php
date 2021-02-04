<div>
    <form>
        {{--<h4 class="font-weight-light"><span @if($gamemode) class="bg-dark" @else class="text-success" @endif></span> {{$gamemode ?: 'Select Layout'}}</h4>
--}}


        @if(!$sorteado)
        <div class="bg-white rounded p-2 py-3">
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

                <div class=" bg-white  p-4 rounded" >
                    <a href="#" class="float-right btn btn-sm btn-light" wire:click="setMode('{{ $gamemode }}', false)">  Back</a>
                    <h4 class="font-weight-bold">Results</h4>
                    <p class="text-lg-center text-muted small"> Generated on {{ $timestamp }}</p>
                    <div class="row" >
                        @foreach($avaliable_maps as $item)
                            @foreach($sorteado as $mapa)
                                @if($mapa['Name']==$item['Name'])
                                    <div class="col-md-4">
                                        <div class="card card-body mb-2" style="@if($item['Avaliable']) @else opacity:0.4 @endif">
                                            <h5 style=""><b>{{ $item['Name'] }}</b></h5>
                                            <div class="small">
                                                @foreach($item['Layouts'][$index_mode] as $size=>$name)
                                                    <span class="badge badge-light">{{ $name  }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                    <div class="text-center">
                        <code>{{ $votemap_text }}</code>
                    </div>
                </div>
                <button class="btn btn-block btn-success mt-2" type="button" wire:click="generateVotemap()">Try Again</button>
            @else
                @if(count($avaliable_maps))
                    <div class="pb-2">
                        <button class="btn btn-block btn-success" type="button" wire:click="generateVotemap()"><b>Generate</b> ({{ $this->totals }} maps avaliable)</button>
                    </div>
                @endif
                @if($unavaliable)
                    <div class="alert alert-danger">No have maps to generate</div>
                @endif
                <div class="row">
                    @foreach($avaliable_maps as $item)
                        <div class="col-md-3">
                            <div class="card card-body mb-2 @if($item['Avaliable']) border-success @endif" >
                                <div style=""><b>{{ $item['Name'] }}</b> - {{ $item['Size'] }}KM</div>
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
                                <div class="small">
                                    @foreach($item['Layouts'][$index_mode] as $size=>$name)
                                        <span class="badge badge-light">{{ $name  }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @if($item['Avaliable'])
                        @endif
                    @endforeach
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
