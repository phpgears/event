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

/**
 * Event interface.
 */
interface Event
{
    /**
     * Get event type.
     *
     * @return string
     */
    public function getEventType(): string;

    /**
     * Check parameter existence.
     *
     * @param string $parameter
     *
     * @return bool
     */
    public function has(string $parameter): bool;

    /**
     * Get parameter.
     *
     * @param string $parameter
     *
     * @return mixed
     */
    public function get(string $parameter);

    /**
     * Export message parameters.
     *
     * @return array<string, mixed>
     */
    public function getPayload(): array;

    /**
     * Get event metadata.
     *
     * @return array<string, mixed>
     */
    public function getMetadata(): array;

    /**
     * Get event with added metadata.
     *
     * @param array<string, mixed> $metadata
     *
     * @return mixed|self
     */
    public function withAddedMetadata(array $metadata);

    /**
     * Get event creation time.
     *
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable;

    /**
     * Reconstitute message.
     *
     * @param array<string, mixed> $payload
     * @param \DateTimeImmutable   $createdAt
     * @param array<string, mixed> $attributes
     *
     * @return mixed|self
     */
    public static function reconstitute(array $payload, \DateTimeImmutable $createdAt, array $attributes);
}
