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

use Gears\Event\Tests\Stub\AbstractEventStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract event test.
 */
class AbstractEventTest extends TestCase
{
    public function testEventType(): void
    {
        $stub = AbstractEventStub::instance([]);

        static::assertEquals(AbstractEventStub::class, $stub->getEventType());
    }

    public function testNoPayload(): void
    {
        $stub = AbstractEventStub::instance([]);

        static::assertEquals(['parameter' => null], $stub->getPayload());
    }

    public function testPayload(): void
    {
        $stub = AbstractEventStub::instance(['parameter' => 'Value']);

        static::assertEquals(['parameter' => 'value'], $stub->getPayload());
    }

    public function testToArray(): void
    {
        $stub = AbstractEventStub::instance(['parameter' => 'Value']);

        static::assertEquals(['parameter' => 'Value'], $stub->toArray());
    }

    public function testReconstitute(): void
    {
        $metadata = ['userId' => '123456'];
        $createdAt = new \DateTimeImmutable('now');

        $event = AbstractEventStub::reconstitute(
            ['parameter' => 'Value'],
            $createdAt,
            ['metadata' => $metadata]
        );

        static::assertEquals(['parameter' => 'value'], $event->getPayload());
        static::assertEquals(['parameter' => 'Value'], $event->toArray());
        static::assertEquals($metadata, $event->getMetadata());
        static::assertEquals($createdAt, $event->getCreatedAt());
    }
}
