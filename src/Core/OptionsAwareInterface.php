<?php


namespace Xmppbot\Core;

/**
 * Classes that take options should implent this interface.
 *
 * @package Xmpp
 */
interface OptionsAwareInterface
{

    /**
     * Set options.
     *
     * @param Options $options
     * @return $this
     */
    public function setOptions(Options $options);

    /**
     * Get options.
     *
     * @return Options
     */
    public function getOptions();
}
