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
 * Abstract empty immutable event.
 */
abstract class AbstractEmptyEvent implements Event
{
    use EventBehaviour;

    /**
     * AbstractEmptyEvent constructor.
     *
     * @param \DateTimeImmutable $createdAt
     */
    private function __construct(\DateTimeImmutable $createdAt)
    {
        $this->assertImmutable();

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
     * @param TimeProvider $timeProvider
     *
     * @return mixed|self
     */
    final protected static function occurred(?TimeProvider $timeProvider = null)
    {
        $timeProvider = $timeProvider ?? new SystemTimeProvider();

        return new static($timeProvider->getCurrentTime());
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed|self
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public static function reconstitute(array $payload, \DateTimeImmutable $createdAt, array $attributes)
    {
        $event = new static($createdAt);

        if (isset($attributes['metadata'])) {
            $event->addMetadata($attributes['metadata']);
        }

        return $event;
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
     * {@inheritdoc}
     *
     * @return string[]
     */
    final protected function getAllowedInterfaces(): array
    {
        return [Event::class];
    }
}
