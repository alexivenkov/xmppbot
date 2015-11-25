<?php

namespace Xmppbot;

use Xmppbot\Core\Client;
use Xmppbot\Core\Protocol\Message;

class XmppBot
{
    /** @var Client $client */
    protected $client;

    /**
     * Connect into xmpp network
     *
     * XmppBot constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->client->connect();
    }

    public function __destruct()
    {
        $this->client->disconnect();
    }

    /**
     * Send message to user (jid = jabber id (user@jabberhost.net))
     *
     * @param string $messageText
     * @param string $jid
     */
    public function sendMessage($messageText, $jid)
    {
        $message = new Message();
        $message->setMessage($messageText)->setTo($jid);
        $this->client->send($message);
    }
}