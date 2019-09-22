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

namespace Gears\Event\Tests;

use Gears\Event\Event;
use Gears\Event\EventArrayCollection;
use Gears\Event\Exception\InvalidEventException;
use Gears\Event\Tests\Stub\AbstractEmptyEventStub;
use PHPUnit\Framework\TestCase;

/**
 * Event array collection test.
 */
class EventArrayCollectionTest extends TestCase
{
    public function testInvalidTypeCollection(): void
    {
        $this->expectException(InvalidEventException::class);
        $this->expectExceptionMessageRegExp('/^Event collection only accepts ".+", "string" given$/');

        new EventArrayCollection(['event']);
    }

    public function testCollection(): void
    {
        $events = [
            AbstractEmptyEventStub::instance(),
            AbstractEmptyEventStub::instance(),
        ];
        $collection = new EventArrayCollection($events);

        static::assertCount(2, $collection);

        foreach ($collection as $event) {
            static::assertInstanceOf(Event::class, $event);
        }

        static::assertNull($collection->key());
    }
}
