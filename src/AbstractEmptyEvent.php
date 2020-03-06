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
     * {@inheritdoc}
     *
     * @return string[]
     */
    final protected function getAllowedInterfaces(): array
    {
        return [Event::class];
    }
}
