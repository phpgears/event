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
 * Abstract immutable event.
 */
abstract class AbstractEvent implements Event
{
    use EventBehaviour;

    /**
     * AbstractEvent constructor.
     *
     * @param iterable<mixed>    $payload
     * @param \DateTimeImmutable $createdAt
     */
    private function __construct(iterable $payload, \DateTimeImmutable $createdAt)
    {
        $this->setPayload($payload);

        $this->createdAt = $createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventType(): string
    {
        return static::class;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return $this->getPayloadRaw();
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
    public static function reconstitute(iterable $payload, \DateTimeImmutable $createdAt, array $attributes)
    {
        $event = new static($payload, $createdAt);

        if (isset($attributes['metadata'])) {
            $event->addMetadata($attributes['metadata']);
        }

        return $event;
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
