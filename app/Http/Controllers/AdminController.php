<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\Prspy;
use App\Models\Administrators;
use App\Models\Levels;
use App\Models\Server;
use App\Models\ServerHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use Prspy;

    public function __construct()
    {

    }

    public function index(){
        return view('index');
    }


    public function history( Request $request ){

        if($request->has('cron')){
            $this->populateServers();
        }
        $this->configureServer();

        if($request->has('cron') && $this->mapname){

            $slug = strtolower(str_replace(['_','-',' '],'',$this->mapname));
            $getLast = ServerHistory::orderBy('id','desc')->first();
            if( !isset($getLast->id) ){

                $MapDB = Levels::where('Name',$this->mapname)->first();
                $payload = [
                    'name'=>$this->mapname,
                    'map_key'=>$slug,
                    'map_mode'=>str_replace('gpm_','',$this->gametype),
                    'map_size'=>$this->mapsize,
                    'timestamp'=>Carbon::now()
                ];
                ServerHistory::create($payload);
            }

            if( isset($getLast->id) ){

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
        return view('history',[
            'list'=>ServerHistory::limit(100)->orderBy('timestamp','desc')->get()
        ]);
    }
    public function login( Request $request ){
        return view('admin.login');
    }

    public function auth( Request $request ){

        $input_email = $request->email;
        $input_password = $request->password;

        try {
            $selectUser = Administrators::where('email',$input_email)->firstOrFail();
        }catch( \Exception $exception ){
            return redirect()->back()->withErrors('Auth Failed');
        }

        if( Hash::check( $input_password, $selectUser->password )){
            session()->put('logged',$selectUser->id);
            return redirect('/admin');
        }else{
            return redirect()->back()->withErrors('Auth Failed');
        }


        return redirect('/login');
    }

    public function logout(){
        session()->forget('logged');
        return redirect('/');
    }

    public function admin()
    {
        if( Server::count() == 0 ){
           # return redirect('/admin/configure');
        }
        $server = Server::first();
        $Maps = Levels::get();
        return view('admin.dashboard',[
            'server' => $server,
            'maps' => $Maps,
        ]);
    }

    public function configure( Request $request ){


        $this->populateServers();

        // Set a New Server
        if($request->ip){
            foreach($this->servers as $server){

                if( $server->serverIp==$request->ip){

                    if( Server::count() == 0 ) {
                        Server::create([
                            'ip' => $server->serverIp,
                            'name' => $this->getServerName( $server),
                            'status' => 'active'
                        ]);
                    }else{
                        $ServerEntity = Server::first();
                        Server::where('id',$ServerEntity->id)->update([
                            'ip' => $server->serverIp,
                            'name' => $this->getServerName( $server),
                            'status' => 'active'
                        ]);
                    }

                    return redirect('/admin');
                }
            }
        }

        return view('admin.select_server',[
            'servers' => $this->servers
        ]);
    }


    public function getServerName( $server ){
        $hostname = $server->properties->hostname;
        $_ihostname = explode(' ',$hostname);
        unset($_ihostname[0]);
        unset($_ihostname[1]);
        $name = implode(' ',$_ihostname);
        return $name;
    }

}
