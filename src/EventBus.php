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

interface EventBus
{
    /**
     * Dispatch event.
     *
     * @param Event $event
     */
    public function dispatch(Event $event): void;
}
