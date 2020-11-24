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
use Gears\Event\EventIteratorCollection;
use Gears\Event\Exception\EventException;
use Gears\Event\Exception\InvalidEventException;
use Gears\Event\Tests\Stub\AbstractEmptyEventStub;
use PHPUnit\Framework\TestCase;

/**
 * Event iterator collection test.
 */
class EventIteratorCollectionTest extends TestCase
{
    public function testInvalidTypeCollection(): void
    {
        $this->expectException(InvalidEventException::class);
        $this->expectExceptionMessageRegExp('/^Event collection only accepts ".+", "string" given\.$/');

        (new EventIteratorCollection(new \ArrayIterator(['event'])))->current();
    }

    public function testCollection(): void
    {
        $events = [
            AbstractEmptyEventStub::instance(),
            AbstractEmptyEventStub::instance(),
        ];
        $collection = new EventIteratorCollection(new \ArrayIterator($events));

        static::assertCount(2, $collection);

        foreach ($collection as $event) {
            static::assertInstanceOf(Event::class, $event);
        }

        static::assertNull($collection->key());
    }

    public function testCollectionCountEmpty(): void
    {
        $collection = new EventIteratorCollection(new \EmptyIterator());

        static::assertCount(0, $collection);
    }

    public function testCollectionCountNonCountable(): void
    {
        $events = [
            AbstractEmptyEventStub::instance(),
            AbstractEmptyEventStub::instance(),
        ];
        $collection = new EventIteratorCollection(new \IteratorIterator(new \ArrayIterator($events)));

        $collection->next();
        $currentKey = $collection->key();
        static::assertCount(2, $collection);
        static::assertEquals($currentKey, $collection->key());
    }

    public function testNoSerialization(): void
    {
        $this->expectException(EventException::class);
        $this->expectExceptionMessage('Event collection "Gears\Event\EventIteratorCollection" cannot be serialized.');

        \serialize(new EventIteratorCollection(new \EmptyIterator()));
    }

    public function testNoDeserialization(): void
    {
        $this->expectException(EventException::class);
        $this->expectExceptionMessage('Event collection "Gears\Event\EventIteratorCollection" cannot be unserialized.');

        \unserialize('O:35:"Gears\Event\EventIteratorCollection":0:{}');
    }
}
