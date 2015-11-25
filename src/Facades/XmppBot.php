<?php

namespace Xmppbot\Facades;

use Illuminate\Support\Facades\Facade;

class XmppBot extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xmppbot';
    }
}