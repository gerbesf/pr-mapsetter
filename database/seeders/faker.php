<?php

namespace Database\Seeders;

use App\Models\Levels;
use App\Models\ServerHistory;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class faker extends Seeder
{
    public $indexDates = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $date = [];
        $maps = Levels::select('Name','Image','Slug','Layouts')->inRandomOrder()->get();
        foreach($maps as $item){
            $randomIndex = rand(0,count($item->Layouts)-1);
            $keysAvaliable = array_keys($item->Layouts);
            $gamesAvaliable = $item->Layouts[$keysAvaliable[$randomIndex]];
            $randomGamesIndex = rand(0,count($gamesAvaliable)-1);
            $keysGamesAvaliable = array_keys($gamesAvaliable);
            $payload[] = [
                'name' => $item['Name'],
                'map_key' => $item['Slug'],
                'map_mode' => $keysAvaliable[$randomIndex],
                'map_size' => $keysGamesAvaliable[ $randomGamesIndex ],
            ];
        }


        $final = [];

        $data = new CarbonPeriod('2021-01-28', '1 hours', '2021-01-30');
        $i=0;
        foreach($data as $dataaa){
            $final[$i] = $payload[rand(0,count($payload)-1)];
            $final[$i]['timestamp'] = $dataaa->format('Y-m-d H:i:s');
            $i++;
        }

        foreach($final as $item){
            ServerHistory::firstOrCreate($item);
        }


    }
}
