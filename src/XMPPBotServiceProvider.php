<?php

namespace Xmppbot;

use Illuminate\Support\ServiceProvider;
use Xmppbot\Core\Client;
use Xmppbot\Core\Options;

class XMPPBotServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/xmppbot.php' => config_path('xmppbot.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind('xmppbot', function () {
            $options = new Options(config('xmppbot.host'));
            $options->setTo(config('xmppbot.send-alias'));
            $options->setUsername(config('xmppbot.username'))->setPassword(config('xmppbot.password'));

            $client = new Client($options);

            return new XmppBot($client);
        });
    }
}