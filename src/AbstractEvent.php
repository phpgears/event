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

use Gears\DTO\ScalarPayloadBehaviour;
use Gears\Event\Time\SystemTimeProvider;
use Gears\Event\Time\TimeProvider;
use Gears\Immutability\ImmutabilityBehaviour;

/**
 * Abstract immutable event.
 */
abstract class AbstractEvent implements Event
{
    use ImmutabilityBehaviour, ScalarPayloadBehaviour {
        ScalarPayloadBehaviour::__call insteadof ImmutabilityBehaviour;
    }

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * AbstractEvent constructor.
     *
     * @param array<string, mixed> $payload
     * @param \DateTimeImmutable   $createdAt
     */
    private function __construct(array $payload, \DateTimeImmutable $createdAt)
    {
        $this->checkImmutability();

        $this->createdAt = $createdAt->setTimezone(new \DateTimeZone('UTC'));

        $this->setPayload($payload);
    }

    /**
     * Instantiate new event.
     *
     * @param array<string, mixed> $parameters
     * @param TimeProvider         $timeProvider
     *
     * @return mixed|self
     */
    final protected static function occurred(array $parameters, ?TimeProvider $timeProvider = null)
    {
        $timeProvider = $timeProvider ?? new SystemTimeProvider();

        return new static($parameters, $timeProvider->getCurrentTime());
    }

    /**
     * {@inheritdoc}
     */
    final public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed|self
     */
    public static function reconstitute(array $payload, array $attributes)
    {
        return new static($payload, $attributes['createdAt']);
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
