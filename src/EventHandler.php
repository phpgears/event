<?php

/*
 * event (https://github.com/phpgears/event).
 * Event handling.
 *
 * @license MIT
 * @link https://github.com/phpgears/event
 * @author Julián Gutiérrez <juliangut@gmail.com>
 */

declare(strict_types=1);

namespace Gears\Event;

interface EventHandler
{
    /**
     * Handle event.
     *
     * @param Event $event
     */
    public function handle(Event $event): void;
}
