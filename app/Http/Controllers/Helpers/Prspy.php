<?php

namespace App\Http\Controllers\Helpers;

use App\Models\DiscrodHooks;
use App\Models\Server;
use Carbon\Carbon;
use Woeler\DiscordPhp\Message\DiscordEmbedMessage;
use Woeler\DiscordPhp\Webhook\DiscordWebhook;

trait Prspy{

    // Api Data
    private $uri = 'https://servers.realitymod.com';
    protected $servers = [];

    // Server Data
    protected $hostname = '';
    protected $gamever = '';
    protected $mapname = '';
    protected $gametype = '';
    protected $mapsize = '';
    protected $numplayers = '';
    protected $maxplayers = '';
    protected $flag_county = '';

    /**
     * Populate Servers
     */
    protected function populateServers() {
        $response = \Cache::remember('prspy',60,function (){
            return \Ixudra\Curl\Facades\Curl::to($this->uri . '/api/ServerInfo')
                ->asJson()
                ->get();
        });

        if( isset($response->servers)){

            $this->servers = $response->servers;
            sort($this->servers);

        }else{
            throw new \Exception('Erro na consulta prspy');
        }
    }

    /**
     * Configure Server
     */
    protected function configureServer(){

        $activeServer = Server::first();
        foreach($this->servers as $server){

            if($server->serverIp==$activeServer->ip){
                $gVer = explode('-',$server->properties->gamever);
                $this->hostname = substr($server->properties->hostname,14,99999);
                $this->gamever = $gVer[0];
                $this->mapname = $server->properties->mapname;
                $this->gametype = $server->properties->gametype;
                $this->mapsize = $server->properties->bf2_mapsize;
                $this->numplayers = $server->properties->numplayers;
                $this->maxplayers = $server->properties->maxplayers;
                $this->flag_county = $server->config->countryFlag;

            }
        }

    }

    public function dispatchHook(){

        $hasHook = DiscrodHooks::first();

        dd('oi');

        if( isset($hasHook->id)){

            if( $hasHook->actual_map==null or  $hasHook->actual_map!=$this->mapname){

                DiscrodHooks::where('id',$hasHook->id)->update([
                    'actual_map'=>$this->mapname,
                    'timestamp'=>Carbon::now()
                ]);
                $message = $this->mapname. ' - '.Carbon::now()->format('d/m/Y H:i');

                $url = $hasHook['endpoint'];
                $POST = [ 'username' => env('APP_NAME'), 'content' => $message ];

                dd($message);

             #   $this->sendMessage($url,$POST);

            }
        }

    }

    public function sendMessage( $url ,$POST){

        $headers = [ 'Content-Type: application/json; charset=utf-8' ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
        $response   = curl_exec($ch);

    }
}
