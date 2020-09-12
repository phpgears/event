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

    public function testSerialization(): void
    {
        $stub = AbstractEventStub::instance(['parameter' => 'value'])->withAddedMetadata(['meta' => 100]);

        $serialized = \version_compare(\PHP_VERSION, '7.4.0') >= 0
            ? 'O:40:"Gears\Event\Tests\Stub\AbstractEventStub":3:{'
                . 's:7:"payload";a:1:{s:9:"parameter";s:5:"value";}'
                . 's:8:"metadata";a:1:{s:4:"meta";i:100;}'
                . 's:9:"createdAt";s:32:"2020-01-01T00:00:00.000000+00:00";'
                . '}'
            : 'C:40:"Gears\Event\Tests\Stub\AbstractEventStub":148:{a:3:{'
                . 's:7:"payload";a:1:{s:9:"parameter";s:5:"value";}'
                . 's:8:"metadata";a:1:{s:4:"meta";i:100;}'
                . 's:9:"createdAt";s:32:"2020-01-01T00:00:00.000000+00:00";'
                . '}}';

        static::assertSame($serialized, \serialize($stub));

        /** @var AbstractEventStub $unserializedStub */
        $unserializedStub = \unserialize($serialized);
        static::assertSame($stub->getPayload(), $unserializedStub->getPayload());
        static::assertSame($stub->getMetadata(), $unserializedStub->getMetadata());
        static::assertSame($stub->getCreatedAt()->format('U'), $unserializedStub->getCreatedAt()->format('U'));
    }
}
