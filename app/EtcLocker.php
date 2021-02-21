<?php

namespace App;

use App\Models\SetLocker;
use Carbon\Carbon;
use Woeler\DiscordPhp\Message\DiscordEmbedMessage;
use Woeler\DiscordPhp\Webhook\DiscordWebhook;

class EtcLocker {

    public $user_id;
    public $lock_id;

    public function __construct( $user_id = false )
    {
        if($user_id)
            $this->user_id = $user_id;
    }

    public function discordAbandouVote( $Lock ){

        $message = (new DiscordEmbedMessage())
            ->setContent('Sessão expirada')
            ->setAvatar(env('BOT_AVATAR'))
            ->setUsername(env('BOT_NAME') )
            ->setTitle(ucfirst($Lock->user->nickname).'')
            ->setDescription('Iniciou uma votação, mas abandou pelo caminho :(' )
            ->setColor( 0x0099ff);

        $i=1;
        foreach($Lock->rotations_history as $line){
            $message->addField('Tentativa #'.$i, implode(', ',$line));
            $i++;
        }
        $webhook = new DiscordWebhook( env('DSC_MAP') );
        $webhook->send($message);

    }

    public function checkHasLocked(){
        $Lock = SetLocker::where('status','locked')->first();
        if( isset($Lock->id)){

            if(Carbon::parse($Lock->created_at)->addMinutes( 5 )->isPast()){

                SetLocker::where('id',$Lock->id)->update([
                    'status' => 'expired'
                ]);

                $this->discordAbandouVote($Lock);

                return true;
            }

            if($this->user_id!=$Lock->user_id){
                dd('diff user, please reload this page. =)');
            }

        }
        return false;
    }

    public function  indexLocker(){

        if( SetLocker::where([
            'user_id' => $this->user_id,
            'status' => 'locked',
        ])->count() == 0){
            $entity = SetLocker::create([
                'user_id' => $this->user_id,
                'status' => 'locked',
            ]);
        }

        $entity = SetLocker::where([
            'user_id' => $this->user_id,
            'status' => 'locked',
        ])->first();

        $this->lock_id = $entity->id;
        return $entity;
    }

}
