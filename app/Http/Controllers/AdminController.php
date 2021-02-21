<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\Admins;
use App\Http\Controllers\Helpers\AdminPages;
use App\Http\Controllers\Helpers\Discord;
use App\Http\Controllers\Helpers\Prspy;
use App\Models\Levels;
use App\Models\ServerHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use Prspy;
    use Admins;
    use AdminPages;
    use Discord;

    public function __construct() {
       # $this->middleware('admin')->only('rotation');
    }

    // Degustation
    public function index(){
        return view('welcome');
    }

    // Degustation
    public function rotation(){
        return view('rotation');
    }


    // History of Maps
    public function history( Request $request ){

        // Is a cron request ?
        if($request->has('cron'))
            $this->populateServers();

        // Configure PrSpy Server
        $this->configureServer();

        // If is a "cron request", with results
        if($request->has('cron') && $this->mapname){

            // slug mapname
            $slug = strtolower(str_replace(['_','-',' '],'',$this->mapname));
            $getLast = ServerHistory::orderBy('id','desc')->first();

            // Create if first entity on database
            if( !isset($getLast->id) ){
                $payload = [
                    'name'=>$this->mapname,
                    'map_key'=>$slug,
                    'map_mode'=>str_replace('gpm_','',$this->gametype),
                    'map_size'=>$this->mapsize,
                    'timestamp'=>Carbon::now()
                ];
                ServerHistory::create($payload);
            }

            // Normal Rotine
            if( isset($getLast->id) ){

                // Map diff from Last Entity
                if($getLast->map_key != $slug ){
                    $MapDB = Levels::where('Name',$this->mapname)->first();
                    $payload = [
                        'name'=>$this->mapname,
                        'map_key'=>$slug,
                     #   'map_key'=>$MapDB->Key,
                        'map_mode'=>str_replace('gpm_','',$this->gametype),
                        'map_size'=>$this->mapsize,
                        'timestamp'=>Carbon::now()
                    ];
                    ServerHistory::create($payload);
                }
            }
        }

        // View History
        return view('history',[
            'list'=>ServerHistory::limit(100)->orderBy('timestamp','desc')->get()
        ]);
    }

    // Generic Logout
    public function logout(){
        session()->forget('admin_logged');
        session()->forget('master_logged');
        return redirect('/');
    }

}
