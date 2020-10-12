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
use Gears\Event\Exception\InvalidEventParameterException;

/**
 * Event metadata behaviour.
 */
trait EventBehaviour
{
    use ScalarPayloadBehaviour {
        setPayloadParameter as private scalarSetPayloadParameter;
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
     * @return static
     */
    final public function withAddedMetadata(array $metadata)
    {
        $self = clone $this;

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
                $this->assertPayloadParameterType($value);
            } catch (InvalidScalarParameterException $exception) {
                throw new InvalidScalarParameterException(
                    \sprintf(
                        'Class "%s" can only accept scalar metadata parameters, "%s" given',
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

    /**
     * {@inheritdoc}
     * Extend original to prevent parameters set.
     *
     * @param \ReflectionClass $reflection
     * @param string           $parameter
     * @param mixed            $value
     */
    private function setPayloadParameter(\ReflectionClass $reflection, string $parameter, $value): void
    {
        if (\in_array($parameter, ['metadata', 'createdAt'], true)) {
            throw new InvalidEventParameterException(
                \sprintf('Event parameter "%s" on "%s" cannot be set', $parameter, static::class)
            );
        }

        $this->scalarSetPayloadParameter($reflection, $parameter, $value);
    }

    /**
     * {@inheritdoc}
     * Extend original to prevent event parameters in definition.
     *
     * @return string[]
     */
    private function getPayloadDefinition(): array
    {
        $excludedProperties = \array_filter(\array_map(
            static function (\ReflectionProperty $property): ?string {
                return !$property->isStatic() ? $property->getName() : null;
            },
            (new \ReflectionClass(EventBehaviour::class))->getProperties()
        ));

        return \array_filter(\array_map(
            static function (\ReflectionProperty $property) use ($excludedProperties): ?string {
                return !$property->isStatic() && !\in_array($property->getName(), $excludedProperties, true)
                    ? $property->getName()
                    : null;
            },
            (new \ReflectionClass($this))->getProperties()
        ));
    }
}
