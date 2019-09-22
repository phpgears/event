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

namespace Gears\Event;

use Gears\Event\Time\SystemTimeProvider;
use Gears\Event\Time\TimeProvider;

/**
 * Abstract empty immutable event.
 */
abstract class AbstractEmptyEvent implements Event
{
    use EventBehaviour;

    /**
     * AbstractEmptyEvent constructor.
     *
     * @param array<string, mixed> $metadata
     * @param \DateTimeImmutable   $createdAt
     */
    private function __construct(array $metadata, \DateTimeImmutable $createdAt)
    {
        $this->assertImmutable();

        $this->setMetadata($metadata);
        $this->createdAt = $createdAt->setTimezone(new \DateTimeZone('UTC'));
    }

    /**
     * Instantiate new event.
     *
     * @param TimeProvider $timeProvider
     *
     * @return mixed|self
     */
    final protected static function occurred(?TimeProvider $timeProvider = null)
    {
        $timeProvider = $timeProvider ?? new SystemTimeProvider();

        return new static([], $timeProvider->getCurrentTime());
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed|self
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public static function reconstitute(array $payload, array $attributes)
    {
        return new static($attributes['metadata'], $attributes['createdAt']);
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
