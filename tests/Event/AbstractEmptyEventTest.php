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

use Gears\Event\Tests\Stub\AbstractEmptyEventStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract empty event test.
 */
class AbstractEmptyEventTest extends TestCase
{
    public function testEventType(): void
    {
        $stub = AbstractEmptyEventStub::instance();

        static::assertEquals(AbstractEmptyEventStub::class, $stub->getEventType());
    }

    public function testNoPayload(): void
    {
        $stub = AbstractEmptyEventStub::instance();

        static::assertEquals([], $stub->getPayload());
    }

    public function testToArray(): void
    {
        $stub = AbstractEmptyEventStub::instance();

        static::assertEquals([], $stub->toArray());
    }

    public function testReconstitute(): void
    {
        $metadata = ['userId' => '123456'];
        $createdAt = new \DateTimeImmutable('now');

        $event = AbstractEmptyEventStub::reconstitute(
            ['parameter' => 'Value'],
            $createdAt,
            ['metadata' => $metadata]
        );

        static::assertEquals([], $event->getPayload());
        static::assertEquals([], $event->toArray());
        static::assertEquals($metadata, $event->getMetadata());
        static::assertEquals($createdAt, $event->getCreatedAt());
    }
}
