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

use Gears\Event\Tests\Stub\EventBehaviourStub;
use PHPUnit\Framework\TestCase;

/**
 * EventBehaviour trait test.
 */
class EventBehaviourTest extends TestCase
{
    /**
     * @expectedException \Gears\DTO\Exception\InvalidScalarParameterException
     * @expectedExceptionMessageRegExp /^Class .+ can only accept scalar metadata parameters, stdClass given$/
     */
    public function testInvalidMetadata(): void
    {
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

        $this->assertEquals($metadata, $stub->getMetadata());
        $this->assertEquals($createdAt, $stub->getCreatedAt());
    }

    public function testMetadataSet(): void
    {
        $metadata = ['userId' => '123456'];
        $stub = new EventBehaviourStub([]);

        $this->assertEmpty($stub->getMetadata());

        $newStub = $stub->withMetadata($metadata);

        $this->assertNotSame($stub, $newStub);
        $this->assertEquals($metadata, $newStub->getMetadata());
    }
}
