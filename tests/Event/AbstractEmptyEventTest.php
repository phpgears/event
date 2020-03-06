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

use Gears\Event\Exception\EventException;
use Gears\Event\Tests\Stub\AbstractEmptyEventStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract empty event test.
 */
class AbstractEmptyEventTest extends TestCase
{
    public function testCommandType(): void
    {
        $stub = AbstractEmptyEventStub::instance();

        static::assertEquals(AbstractEmptyEventStub::class, $stub->getEventType());
    }

    public function testCreation(): void
    {
        $event = AbstractEmptyEventStub::instance();

        static::assertEquals([], $event->getPayload());
    }

    public function testReconstitute(): void
    {
        $metadata = ['userId' => '123456'];
        $createdAt = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));

        $event = AbstractEmptyEventStub::reconstitute(
            [],
            $createdAt,
            [
                'metadata' => $metadata,
            ]
        );

        static::assertEquals($createdAt, $event->getCreatedAt());
        static::assertEquals($metadata, $event->getMetadata());
    }

    public function testNoSerialization(): void
    {
        $this->expectException(EventException::class);
        $this->expectExceptionMessage('Event "Gears\Event\Tests\Stub\AbstractEmptyEventStub" cannot be serialized');

        \serialize(AbstractEmptyEventStub::instance());
    }

    public function testNoDeserialization(): void
    {
        $this->expectException(EventException::class);
        $this->expectExceptionMessage('Event "Gears\Event\Tests\Stub\AbstractEmptyEventStub" cannot be unserialized');

        \unserialize('O:45:"Gears\Event\Tests\Stub\AbstractEmptyEventStub":0:{}');
    }
}
