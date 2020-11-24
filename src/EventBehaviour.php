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

use Gears\DTO\Exception\InvalidScalarParameterException;
use Gears\DTO\ScalarPayloadBehaviour;
use Gears\Immutability\ImmutabilityBehaviour;

use function DeepCopy\deep_copy;

/**
 * Event metadata behaviour.
 */
trait EventBehaviour
{
    use ImmutabilityBehaviour, ScalarPayloadBehaviour {
        ScalarPayloadBehaviour::__call insteadof ImmutabilityBehaviour;
    }

    /**
     * Event metadata.
     *
     * @var array<string, mixed>
     */
    private $metadata = [];

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * Get event metadata.
     *
     * @return array<string, mixed>
     */
    final public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * Get event with added metadata.
     *
     * @param array<string, mixed> $metadata
     *
     * @return mixed|self
     */
    final public function withAddedMetadata(array $metadata)
    {
        // @var self $self
        $self = deep_copy($this);

        $self->addMetadata($metadata);

        return $self;
    }

    /**
     * Set event metadata.
     *
     * @param array<string, mixed> $metadata
     *
     * @throws InvalidScalarParameterException
     */
    private function addMetadata(array $metadata): void
    {
        foreach ($metadata as $parameter => $value) {
            try {
                $this->checkParameterType($value);
            } catch (InvalidScalarParameterException $exception) {
                throw new InvalidScalarParameterException(
                    \sprintf(
                        'Class "%s" can only accept scalar metadata parameters, "%s" given.',
                        static::class,
                        \is_object($value) ? \get_class($value) : \gettype($value)
                    ),
                    $exception->getCode(),
                    $exception
                );
            }

            $this->metadata[$parameter] = $value;
        }
    }

    /**
     * Get event creation time.
     *
     * @return \DateTimeImmutable
     */
    final public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
