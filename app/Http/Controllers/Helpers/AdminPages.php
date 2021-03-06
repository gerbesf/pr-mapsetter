<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Admin;
use App\Models\AdminMaster;
use App\Models\Levels;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Ixudra\Curl\Facades\Curl;
use Woeler\DiscordPhp\Message\DiscordEmbedMessage;
use Woeler\DiscordPhp\Message\DiscordTextMessage;
use Woeler\DiscordPhp\Webhook\DiscordWebhook;

trait AdminPages
{

    // Admin Dashboard
    public function admin()
    {

      //  $this->sendTestMaps();

        // Server Active
        $server = Server::first();

        // All Maps
        $Maps = Levels::where('Status','online')->get();

        // Render
        return view('admin.dashboard',[
            'server' => $server,
            'maps' => $Maps,
        ]);
    }

    // Configure a new Server
    public function configure( Request $request ){

        if(!session()->has('master_logged')){
            return redirect('/ops');
        }

        // PySpy
        $this->populateServers();

        // Set a New Server
        if($request->id){
            foreach($this->servers as $server){

                Server::where([])->delete();
                // Server Selected
                if( $server->serverId==$request->get('id')){
                   # dd($server);

                    // Check is new
                    if( Server::count() == 0 ) {

                        Server::create([
                            'server_id' => $server->serverId,
                            'name' => $this->getServerName( $server),
                            'status' => 'active'
                        ]);

                    }else{

                        // Update current entity
                        $ServerEntity = Server::first();
                        Server::where('server_id',$ServerEntity->serverId)->update([
                            'server_id' => $server->serverId,
                            'name' => $this->getServerName( $server),
                            'status' => 'active'
                        ]);
                    }

                    // return
                    return redirect('/admin');
                }
            }
        }

        // Render
        return view('admin.select_server',[
            'servers' => $this->servers
        ]);
    }


    /**
     * Get Server Name
     * Remover server settings from name
     *
     * @param $server
     * @return string
     */
    protected function getServerName( $server ){
        $hostname = $server->properties->hostname;
        $_ihostname = explode(' ',$hostname);
        unset($_ihostname[0]);
        unset($_ihostname[1]);
        return implode(' ',$_ihostname);
    }


    public function admin_users() {

        if(!session()->has('master_logged')){
            return redirect('/ops');
        }

        return view('admin.users');
    }

}
