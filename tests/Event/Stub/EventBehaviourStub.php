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

namespace Gears\Event\Tests\Stub;

use Gears\Event\Event;
use Gears\Event\EventBehaviour;

/**
 * EventBehaviour trait stub class.
 */
class EventBehaviourStub
{
    use EventBehaviour;

    /**
     * EventMetadataBehaviourStub constructor.
     *
     * @param array<string, mixed>    $metadata
     * @param \DateTimeImmutable|null $createdAt
     */
    public function __construct(array $metadata, ?\DateTimeImmutable $createdAt = null)
    {
        $this->setMetadata($metadata);
        $this->createdAt = $createdAt ?? new \DateTimeImmutable('now');
    }

    /**
     * {@inheritdoc}
     *
     * @return string[]
     */
    final protected function getAllowedInterfaces(): array
    {
        return [Event::class];
    }
}
