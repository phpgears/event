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
use Gears\Event\Exception\InvalidEventParameterException;
use Gears\Event\Tests\Stub\EventBehaviourStub;
use PHPUnit\Framework\TestCase;

/**
 * EventBehaviour trait test.
 */
class EventBehaviourTest extends TestCase
{
    public function testPreventMetadataOverride(): void
    {
        $this->expectException(InvalidEventParameterException::class);
        $this->expectExceptionMessageRegExp(
            '/^Event parameter "metadata" on ".+" cannot be set\.$/'
        );

        new EventBehaviourStub(['metadata' => 'value'], []);
    }

    public function testPreventCreatedAtOverride(): void
    {
        $this->expectException(InvalidEventParameterException::class);
        $this->expectExceptionMessageRegExp(
            '/^Event parameter "createdAt" on ".+" cannot be set\.$/'
        );

        new EventBehaviourStub(['createdAt' => 'value'], []);
    }

    public function testInvalidMetadata(): void
    {
        $this->expectException(InvalidScalarParameterException::class);
        $this->expectExceptionMessageRegExp(
            '/^Class ".+" can only accept scalar metadata parameters, "stdClass" given\.$/'
        );

        new EventBehaviourStub([], ['file' => new \stdClass()]);
    }

    public function testMetadata(): void
    {
        $metadata = [
            'userId' => [
                'id' => '123456',
            ],
        ];
        $createdAt = new \DateTimeImmutable('now');
        $stub = new EventBehaviourStub([], $metadata, $createdAt);

        static::assertEquals($metadata, $stub->getMetadata());
        static::assertEquals($createdAt, $stub->getCreatedAt());
    }

    public function testMetadataSet(): void
    {
        $stub = new EventBehaviourStub([], []);

        static::assertEmpty($stub->getMetadata());

        $metadata = ['userId' => '123456'];
        $newStub = $stub->withAddedMetadata($metadata);

        static::assertNotSame($stub, $newStub);
        static::assertEquals($metadata, $newStub->getMetadata());

        $addedMetadata = ['contactId' => '654321'];
        $addedStub = $newStub->withAddedMetadata($addedMetadata);

        static::assertNotSame($stub, $addedStub);
        static::assertEquals(\array_merge($metadata, $addedMetadata), $addedStub->getMetadata());
    }
}
