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

    public function testSerialization(): void
    {
        $stub = AbstractEmptyEventStub::fixedInstance()->withAddedMetadata(['meta' => 100]);

        $serialized = \version_compare(\PHP_VERSION, '7.4.0') >= 0
            ? 'O:45:"Gears\Event\Tests\Stub\AbstractEmptyEventStub":2:{'
                . 's:8:"metadata";a:1:{s:4:"meta";i:100;}'
                . 's:9:"createdAt";s:32:"2020-01-01T00:00:00.000000+00:00";'
                . '}'
            : 'C:45:"Gears\Event\Tests\Stub\AbstractEmptyEventStub":100:{a:2:{'
                . 's:8:"metadata";a:1:{s:4:"meta";i:100;}'
                . 's:9:"createdAt";s:32:"2020-01-01T00:00:00.000000+00:00";'
                . '}}';

        static::assertSame($serialized, \serialize($stub));

        /** @var AbstractEmptyEventStub $unserializedStub */
        $unserializedStub = \unserialize($serialized);
        static::assertSame($stub->getPayload(), $unserializedStub->getPayload());
        static::assertSame($stub->getMetadata(), $unserializedStub->getMetadata());
        static::assertSame($stub->getCreatedAt()->format('U'), $unserializedStub->getCreatedAt()->format('U'));
    }
}
