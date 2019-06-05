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
use Gears\Event\Tests\Stub\AbstractEmptyEventStub;
use PHPUnit\Framework\TestCase;

/**
 * Event array collection test.
 */
class EventArrayCollectionTest extends TestCase
{
    /**
     * @expectedException \Gears\Event\Exception\InvalidEventException
     * @expectedExceptionMessageRegExp /Event collection only accepts .+, string given/
     */
    public function testInvalidTypeCollection(): void
    {
        new EventArrayCollection(['event']);
    }

    public function testCollection(): void
    {
        $events = [
            AbstractEmptyEventStub::instance(),
            AbstractEmptyEventStub::instance(),
        ];
        $collection = new EventArrayCollection($events);

        $this->assertCount(2, $collection);

        foreach ($collection as $event) {
            $this->assertInstanceOf(Event::class, $event);
        }

        $this->assertNull($collection->key());
    }
}
