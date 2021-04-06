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

class sendMessageExpirado implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lock;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $Lock )
    {
        $this->lock = $Lock;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = (new DiscordEmbedMessage())
            ->setContent('Sessão expirada')
            ->setAvatar(env('BOT_AVATAR'))
            ->setUsername(env('BOT_NAME') )
            ->setTitle(ucfirst($this->lock->user->nickname).'')
            ->setDescription('Iniciou uma votação, mas abandonou pelo caminho :(' )
            ->setColor( 10682368);

        $i=1;
        foreach($this->lock->rotations_history as $line){
            $message->addField('Tentativa #'.$i, implode(', ',$line));
            $i++;
        }
        $webhook = new DiscordWebhook( env('DSC_MAP') );
        $webhook->send($message);
    }
}
