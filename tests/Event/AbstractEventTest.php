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
use Gears\Event\Tests\Stub\AbstractEventStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract event test.
 */
class AbstractEventTest extends TestCase
{
    public function testCommandType(): void
    {
        $stub = AbstractEventStub::instance([]);

        static::assertEquals(AbstractEventStub::class, $stub->getEventType());
    }

    public function testCreation(): void
    {
        $payload = ['Parameter' => 'value'];
        $event = AbstractEventStub::instance($payload);

        static::assertEquals($payload, $event->getPayload());
        static::assertEquals($payload['Parameter'], $event->get('Parameter'));
    }

    public function testReconstitute(): void
    {
        $metadata = ['userId' => '123456'];
        $createdAt = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));

        $event = AbstractEventStub::reconstitute(
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
        $this->expectExceptionMessage('Event "Gears\Event\Tests\Stub\AbstractEventStub" cannot be serialized.');

        \serialize(AbstractEventStub::instance([]));
    }

    public function testNoDeserialization(): void
    {
        $this->expectException(EventException::class);
        $this->expectExceptionMessage('Event "Gears\Event\Tests\Stub\AbstractEventStub" cannot be unserialized.');

        \unserialize('O:40:"Gears\Event\Tests\Stub\AbstractEventStub":0:{}');
    }
}
