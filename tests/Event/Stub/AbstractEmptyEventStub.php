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

namespace Gears\Event\Tests\Stub;

use Gears\Event\AbstractEmptyEvent;

/**
 * Abstract empty event stub class.
 */
class AbstractEmptyEventStub extends AbstractEmptyEvent
{
    /**
     * Instantiate event.
     *
     * @return self
     */
    public static function instance(): self
    {
        return self::occurred();
    }
}
