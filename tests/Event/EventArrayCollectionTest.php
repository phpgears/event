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
use Gears\Event\Exception\EventException;
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

    public function testCollectionCountEmpty(): void
    {
        $collection = new EventArrayCollection([]);

        static::assertCount(0, $collection);
    }

    public function testNoSerialization(): void
    {
        $this->expectException(EventException::class);
        $this->expectExceptionMessage('Event collection "Gears\Event\EventArrayCollection" cannot be serialized');

        \serialize(new EventArrayCollection([]));
    }

    public function testNoDeserialization(): void
    {
        $this->expectException(EventException::class);
        $this->expectExceptionMessage('Event collection "Gears\Event\EventArrayCollection" cannot be unserialized');

        \unserialize('O:32:"Gears\Event\EventArrayCollection":0:{}');
    }
}
