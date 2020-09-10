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
use Gears\Event\Time\FixedTimeProvider;

/**
 * Abstract empty event stub class.
 */
class AbstractEmptyEventStub extends AbstractEmptyEvent
{
    public static function fixedInstance()
    {
        return static::occurred(
            new FixedTimeProvider(\DateTimeImmutable::createFromFormat(\DateTime::ATOM, '2020-01-01T00:00:00Z'))
        );
    }
}
