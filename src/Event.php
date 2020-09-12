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
     * PHP < 7.3 \DateTime::RFC3339_EXTENDED cannot handle microseconds on \DateTimeImmutable::createFromFormat.
     * Remove when support for PHP < 7.3 is dropped.
     *
     * @see https://stackoverflow.com/a/48949373
     */
    public const DATE_RFC3339_EXTENDED = 'Y-m-d\TH:i:s.uP';

    /**
     * Get event type.
     *
     * @return string
     */
    public function getEventType(): string;

    /**
     * Get parameter.
     *
     * @param string $parameter
     *
     * @return mixed
     */
    public function get(string $parameter);

    /**
     * Export event parameters.
     *
     * @return array<string, mixed>
     */
    public function getPayload(): array;

    /**
     * Export event properties as array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;

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
     * @param iterable<mixed>      $payload
     * @param \DateTimeImmutable   $createdAt
     * @param array<string, mixed> $attributes
     *
     * @return mixed|self
     */
    public static function reconstitute(iterable $payload, \DateTimeImmutable $createdAt, array $attributes);
}
