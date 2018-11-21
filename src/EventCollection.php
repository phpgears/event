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

/**
 * Event collection.
 */
interface EventCollection extends \Iterator
{
    /**
     * {@inheritdoc}
     *
     * @return Event
     */
    public function current(): Event;
}
