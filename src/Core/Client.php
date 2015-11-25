<?php

namespace Xmppbot\Core;

use Xmppbot\Core\Connection\ConnectionInterface;
use Xmppbot\Core\Connection\Socket;
use Xmppbot\Core\Protocol\ProtocolImplementationInterface;
use Xmppbot\Core\Event\EventManagerAwareInterface;
use Xmppbot\Core\Event\EventManagerInterface;
use Xmppbot\Core\Event\EventManager;
use Xmppbot\Core\EventListener\Logger;

/**
 * Xmpp connection client.
 *
 * @package Xmpp
 */
class Client implements EventManagerAwareInterface
{

    /**
     * Eventmanager.
     *
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * Options.
     *
     * @var Options
     */
    protected $options;

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * Constructor.
     *
     * @param Options               $options      Client options
     * @param EventManagerInterface $eventManager Event manager
     */
    public function __construct(Options $options, EventManagerInterface $eventManager = null)
    {
        // create default connection
        if (null !== $options->getConnection()) {
            $connection = $options->getConnection();
        } else {
            $connection = Socket::factory($options);
            $options->setConnection($connection);
        }
        $this->options    = $options;
        $this->connection = $connection;

        if (null === $eventManager) {
            $eventManager = new EventManager();
        }
        $this->eventManager = $eventManager;

        $this->setupImplementation();
    }

    /**
     * Setup implementation.
     *
     * @return void
     */
    protected function setupImplementation()
    {
        $this->connection->setEventManager($this->eventManager);
        $this->connection->setOptions($this->options);

        $implementation = $this->options->getImplementation();
        $implementation->setEventManager($this->eventManager);
        $implementation->setOptions($this->options);
        $implementation->register();

        $implementation->registerListener(new Logger());
    }

    /**
     * Connect to server.
     *
     * @return void
     */
    public function connect()
    {
        $this->connection->connect();
    }

    /**
     * Disconnect from server.
     *
     * @return void
     */
    public function disconnect()
    {
        $this->connection->disconnect();
    }

    /**
     * Send data to server.
     *
     * @param ProtocolImplementationInterface $interface Interface
     * @return void
     */
    public function send(ProtocolImplementationInterface $interface)
    {
        $data = $interface->toString();
        $this->connection->send($data);
    }

    /**
     * {@inheritDoc}
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * {@inheritDoc}
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
        return $this;
    }

    /**
     * Get options.
     *
     * @return Options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
