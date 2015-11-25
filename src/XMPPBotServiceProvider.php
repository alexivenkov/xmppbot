<?php

namespace Xmppbot;

use Illuminate\Support\ServiceProvider;

class XMPPBotServiceProvider extends ServiceProvider {
    public function boot() {
        $this->publishes([
            __DIR__.'/../../config/xmppbot.php' => config_path('xmppbot.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind('xmppbot', function ($app) {
            return new XmppBot();
        });
    }
}