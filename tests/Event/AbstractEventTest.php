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

        $this->assertEquals($payload, $event->getPayload());
        $this->assertEquals($payload['Parameter'], $event->get('Parameter'));
    }

    public function testReconstitute(): void
    {
        $metadata = ['userId' => '123456'];
        $createdAt = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));

        $event = AbstractEventStub::reconstitute(
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
