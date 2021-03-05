<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\Admins;
use App\Http\Controllers\Helpers\AdminPages;
use App\Http\Controllers\Helpers\Discord;
use App\Http\Controllers\Helpers\Prspy;
use App\Models\Levels;
use App\Models\ServerHistory;
use App\Models\SetLocker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Woeler\DiscordPhp\Message\DiscordEmbedMessage;
use Woeler\DiscordPhp\Webhook\DiscordWebhook;

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

                $message = (new DiscordEmbedMessage())
                    #    ->setContent('PYSPY - '.$this->mapname)
                    ->setAvatar(env('BOT_AVATAR'))
                    ->setUsername(env('BOT_NAME') )
                    ->setImage('https://www.realitymod.com/mapgallery/images/maps/'.\App\Helper::getImageKeyName( $slug ).'/tile.jpg')
                    ->setTitle($this->mapname)
                    ->setDescription( 'Players: '.$this->numplayers.'/100')
                    ->setColor( 3066993);
                $webhook = new DiscordWebhook( env('DSC_MAP') );
                $webhook->send($message);

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

                    $message = (new DiscordEmbedMessage())
                        #    ->setContent('PYSPY - '.$this->mapname)
                        ->setAvatar(env('BOT_AVATAR'))
                        ->setUsername(env('BOT_NAME') )
                        ->setImage('https://www.realitymod.com/mapgallery/images/maps/'.\App\Helper::getImageKeyName( $slug ).'/tile.jpg')
                        ->setTitle($this->mapname)
                        ->setDescription( 'Players: '.$this->numplayers.'/100')
                        ->setColor( 3066993);
                    $webhook = new DiscordWebhook( env('DSC_MAP') );
                    $webhook->send($message);

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

    public function confirmation( Request $request ){

        $lock =SetLocker::where('id',$request->get('v'))->first();


        $minuted = Carbon::parse($lock->created_at)->addMinutes(  env('VOTE_TIME') )->diffInMinutes();
        $secondd = Carbon::parse($lock->created_at)->addMinutes( env('VOTE_TIME') )->subMinutes( $minuted )->diffInSeconds();


        return view('confirmation',[
            'lock' => $lock,
            'minuted'=>$minuted,
            'secondd'=>$secondd,
        ]);

    }

    public function confirmMap( Request $request ){
        $Entity = SetLocker::where('id',$request->get('v'))->first();

        SetLocker::where('id',$request->get('v'))->update([
            'winner' => $request->get('winner'),
            'status'=>'complete'
        ]);

        $nick = $Entity->user->nickname;
        $message = (new DiscordEmbedMessage())
            ->setContent('**'.ucfirst($nick).'** confirmou o votemap como: '.$request->get('winner'))
            ->setAvatar(env('BOT_AVATAR'))
            ->setUsername(env('BOT_NAME') )

            ->setTitle($request->get('winner'))
            #   ->setDescription( $text_votado)
            ->setColor( 3066993);


        $webhook = new DiscordWebhook( env('DSC_MAP') );
        $webhook->send($message);


        return redirect('/');
    }

}
