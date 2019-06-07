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

        $this->assertEquals([], $event->getPayload());
    }

    public function testReconstitute(): void
    {
        $metadata = ['userId' => '123456'];
        $createdAt = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));

        $event = AbstractEmptyEventStub::reconstitute(
            [],
            [
                'metadata' => $metadata,
                'createdAt' => $createdAt,
            ]
        );

        $this->assertEquals($metadata, $event->getMetadata());
        $this->assertEquals($createdAt, $event->getCreatedAt());
    }
}
