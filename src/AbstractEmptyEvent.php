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
abstract class AbstractEmptyEvent implements Event, \Serializable
{
    use EventBehaviour;

    /**
     * AbstractEmptyEvent constructor.
     *
     * @param \DateTimeImmutable $createdAt
     */
    private function __construct(\DateTimeImmutable $createdAt)
    {
        $this->setPayload(null);

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
    final public function getPayload(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    final public function toArray(): array
    {
        return [];
    }

    /**
     * Get event instance.
     *
     * @return mixed|self
     */
    public static function instance()
    {
        return static::occurred();
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
    public static function reconstitute(iterable $payload, \DateTimeImmutable $createdAt, array $attributes)
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
    public function __serialize(): array
    {
        return [
            'metadata' => $this->metadata,
            'createdAt' => $this->createdAt->format(Event::DATE_RFC3339_EXTENDED),
        ];
    }

    /**
     * @param array<string, mixed> $data
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __unserialize(array $data): void
    {
        $this->setPayload([]);
        $this->metadata = $data['metadata'];
        $this->createdAt = \DateTimeImmutable::createFromFormat(Event::DATE_RFC3339_EXTENDED, $data['createdAt']);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return \serialize([
            'metadata' => $this->metadata,
            'createdAt' => $this->createdAt->format(Event::DATE_RFC3339_EXTENDED),
        ]);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $serialized
     */
    public function unserialize($serialized): void
    {
        $data = \unserialize($serialized, ['allowed_classes' => [\DateTimeImmutable::class]]);

        $this->setPayload([]);
        $this->metadata = $data['metadata'];
        $this->createdAt = \DateTimeImmutable::createFromFormat(Event::DATE_RFC3339_EXTENDED, $data['createdAt']);
    }

    /**
     * {@inheritdoc}
     *
     * @return string[]
     */
    final protected function getAllowedInterfaces(): array
    {
        return [Event::class, \Serializable::class];
    }
}
