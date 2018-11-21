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

use Gears\Event\AbstractEvent;

/**
 * Abstract event stub class.
 */
class AbstractEventStub extends AbstractEvent
{
    /**
     * Instantiate event.
     *
     * @return self
     */
    public static function instance(): self
    {
        return self::occurred([]);
    }
}
