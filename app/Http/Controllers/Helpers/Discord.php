<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Woeler\DiscordPhp\Message\DiscordEmbedMessage;
use Woeler\DiscordPhp\Webhook\DiscordWebhook;

trait Discord
{

    protected $colors = [
        'primary' => 1127128,
        'warning' => 0x0099ff,
        'danger' => 15158332,
        'orange' => 15105570,
        'success' => 3066993,
        'gold' => 15844367,
    ];


    public function sendTestMaps( ){


        $url = env('DSC_MAP');

        $message = (new DiscordEmbedMessage())
            #   ->setContent('Hello World')
            ->setAvatar('https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/b4/b49d9078b553662cb1c432f9166dbc249bcc1296_full.jpg')
            ->setUsername(env('BOT_NAME') . ' - Em Treinamento')
            ->setTitle('Testando a picada')
            ->setDescription('Isto é somente um teste.')

            ->setColor($this->colors['gold'])
            ->addField('Endpoint', env('APP_URL'))
            ->addField('Env', env('APP_ENV'))
            ->addField('Debug', env('APP_DEBUG'))
            ->addField('Connection Type', env('DB_CONNECTION'))
            ->addField('Connection Host', env('DB_HOST', 'Undefined'));

         #   ->setImage('https://memegenerator.net/img/instances/67261462/hang-on-a-sec.jpg');


        $webhook = new DiscordWebhook($url);
        $webhook->send($message);



    }
}
