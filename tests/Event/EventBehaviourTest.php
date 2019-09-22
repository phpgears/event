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

use Gears\DTO\Exception\InvalidScalarParameterException;
use Gears\Event\Tests\Stub\EventBehaviourStub;
use PHPUnit\Framework\TestCase;

/**
 * EventBehaviour trait test.
 */
class EventBehaviourTest extends TestCase
{
    public function testInvalidMetadata(): void
    {
        $this->expectException(InvalidScalarParameterException::class);
        $this->expectExceptionMessageRegExp(
            '/^Class ".+" can only accept scalar metadata parameters, "stdClass" given$/'
        );

        new EventBehaviourStub(['file' => new \stdClass()]);
    }

    public function testMetadata(): void
    {
        $metadata = [
            'userId' => [
                'id' => '123456',
            ],
        ];
        $createdAt = new \DateTimeImmutable('now');
        $stub = new EventBehaviourStub($metadata, $createdAt);

        static::assertEquals($metadata, $stub->getMetadata());
        static::assertEquals($createdAt, $stub->getCreatedAt());
    }

    public function testMetadataSet(): void
    {
        $metadata = ['userId' => '123456'];
        $stub = new EventBehaviourStub([]);

        static::assertEmpty($stub->getMetadata());

        $newStub = $stub->withMetadata($metadata);

        static::assertNotSame($stub, $newStub);
        static::assertEquals($metadata, $newStub->getMetadata());
    }
}
