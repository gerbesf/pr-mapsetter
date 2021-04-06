<?php

namespace App\Jobs;

use App\Helper;
use App\Models\Levels;
use App\Models\SetLocker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Woeler\DiscordPhp\Message\DiscordEmbedMessage;
use Woeler\DiscordPhp\Webhook\DiscordWebhook;

class sendMessageConfirmation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $Entity;
    public $Level;
    public $image;
    public $winner;
    public $nickname;

    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $Entity, $winner)
    {
        $this->Entity = SetLocker::where('id',$Entity)->first();
        $this->Level = Levels::where('Name',$winner)->first();

        $this->winner = $winner;

        $this->image = Helper::getImageKeyName( $this->Level->Slug );
        $this->nickname = $this->Entity->user->nickname;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $message = (new DiscordEmbedMessage())
            #->setContent()
            ->setAvatar(env('BOT_AVATAR'))
            ->setUsername(env('BOT_NAME') )
            ->setImage('https://www.realitymod.com/mapgallery/images/maps/'.$this->image.'/banner.jpg')
            ->setTitle($this->winner)
            ->setDescription( '**'.ucfirst($this->nickname).'** confirmou o votemap!')
            ->setColor( 3066993);

        $webhook = new DiscordWebhook( env('DSC_MAP') );
        $webhook->send($message);

    }
}
