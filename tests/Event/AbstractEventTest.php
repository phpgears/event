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
}
