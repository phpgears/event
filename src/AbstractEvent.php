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
abstract class AbstractEvent implements Event, \Serializable
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
     * @param TimeProvider|null    $timeProvider
     *
     * @return static
     */
    final protected static function occurred(array $payload, ?TimeProvider $timeProvider = null)
    {
        $timeProvider = $timeProvider ?? new SystemTimeProvider();

        return new static($payload, $timeProvider->getCurrentTime());
    }

    /**
     * {@inheritdoc}
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
     * @return array<string, mixed>
     */
    public function __serialize(): array
    {
        return [
            'payload' => $this->getPayloadRaw(),
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
        $this->setPayload($data['payload']);
        $this->metadata = $data['metadata'];
        $this->createdAt = \DateTimeImmutable::createFromFormat(Event::DATE_RFC3339_EXTENDED, $data['createdAt']);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return \serialize([
            'payload' => $this->getPayloadRaw(),
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

        $this->setPayload($data['payload']);
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
