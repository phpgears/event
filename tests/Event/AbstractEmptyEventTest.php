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
}
