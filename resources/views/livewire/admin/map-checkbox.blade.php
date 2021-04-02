<span>
{{--

    <div>
        MAPKEY: {{ $map_key }}
    </div>
    <div>
        SIZE: {{ $size }}
    </div>
    <div>
        GAME_MODE: {{ $game_mode }}
    </div>
    <div>
        LAYOUT: {{ $layout }}
    </div>
--}}

    <label class="d-inline-block text-center rounded  bg-dark   m-1 py-1 px-2 ">
        <input type="checkbox" wire:model="iai" value="1"> <span class="font-weight-bold @if($iai) text-success @else text-white-50 @endif">{{ $size  }}</span>
    </label>

</span>
