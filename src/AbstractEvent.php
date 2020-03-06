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

use Gears\Event\Exception\EventException;
use Gears\Event\Time\SystemTimeProvider;
use Gears\Event\Time\TimeProvider;

/**
 * Abstract immutable event.
 */
abstract class AbstractEvent implements Event
{
    use EventBehaviour;

    /**
     * AbstractEvent constructor.
     *
     * @param array<string, mixed> $payload
     * @param \DateTimeImmutable   $createdAt
     */
    private function __construct(array $payload, \DateTimeImmutable $createdAt)
    {
        $this->assertImmutable();

        $this->setPayload($payload);
        $this->createdAt = $createdAt->setTimezone(new \DateTimeZone('UTC'));
    }

    /**
     * {@inheritdoc}
     */
    public function getEventType(): string
    {
        return static::class;
    }

    /**
     * Instantiate new event.
     *
     * @param array<string, mixed> $payload
     * @param TimeProvider         $timeProvider
     *
     * @return mixed|self
     */
    final protected static function occurred(array $payload, ?TimeProvider $timeProvider = null)
    {
        $timeProvider = $timeProvider ?? new SystemTimeProvider();

        return new static($payload, $timeProvider->getCurrentTime());
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed|self
     */
    public static function reconstitute(array $payload, \DateTimeImmutable $createdAt, array $attributes)
    {
        $event = new static($payload, $createdAt);

        if (isset($attributes['metadata'])) {
            $event->addMetadata($attributes['metadata']);
        }

        return $event;
    }

    /**
     * @return string[]
     */
    final public function __sleep(): array
    {
        throw new EventException(\sprintf('Event "%s" cannot be serialized', static::class));
    }

    final public function __wakeup(): void
    {
        throw new EventException(\sprintf('Event "%s" cannot be unserialized', static::class));
    }

    /**
     * @return array<string, mixed>
     */
    final public function __serialize(): array
    {
        throw new EventException(\sprintf('Event "%s" cannot be serialized', static::class));
    }

    /**
     * @param array<string, mixed> $data
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    final public function __unserialize(array $data): void
    {
        throw new EventException(\sprintf('Event "%s" cannot be unserialized', static::class));
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
