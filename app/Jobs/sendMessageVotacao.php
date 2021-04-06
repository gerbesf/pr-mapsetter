<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Woeler\DiscordPhp\Message\DiscordEmbedMessage;
use Woeler\DiscordPhp\Webhook\DiscordWebhook;

class sendMessageVotacao implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lock;
    public $gamemode;
    public $gamemap;
    public $players_size;
    public $historyRotation;
    public $text_votado;
    public $nickname;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $gamemode ,$gamemap ,$players_size,$historyRotation,$text_votado, $nickname)
    {
        $this->gamemode = $gamemode;
        $this->gamemap = $gamemap;
        $this->players_size = $players_size;
        $this->historyRotation = $historyRotation;
        $this->text_votado = $text_votado;
        $this->nickname = $nickname;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = (new DiscordEmbedMessage())
            ->setContent('**'.ucfirst($this->nickname).'** está realizando um votemap **'.strtoupper($this->gamemode).'**')
            ->setAvatar(env('BOT_AVATAR'))
            ->setUsername(env('BOT_NAME') )
            ->setTitle($this->text_votado)
            #   ->setDescription( $text_votado)
            ->setColor( 15844367);


        if(count($this->historyRotation)==2){
            $message->addField('Tentativa anterior', implode(' - ',$this->historyRotation[0]));
        }
        if(count($this->historyRotation)>=3){
            $copy = ($this->historyRotation);
            unset($copy[ count($copy) -1 ]);
            $i=1;
            foreach($copy as $line){
                $message->addField('Tentativa #'.$i, implode(' - ',$line));
                $i++;
            }
        }

        $sizeDesc = strtolower(str_replace('_',' até ' ,$this->players_size));

        if($this->gamemap){
            $message->addField('Config ', '**'.$this->gamemode.'** | '. $this->gamemap. " | __".$sizeDesc.'__');
        }else{
            $message->addField('Config ', '**'.$this->gamemode."** | __".$sizeDesc.'__');
        }

        #dd($message,$sizeDesc);
        $webhook = new DiscordWebhook( env('DSC_MAP') );
        $webhook->send($message);

    }
}
