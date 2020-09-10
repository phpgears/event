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

namespace Gears\Event\Tests\Stub;

use Gears\Event\AbstractEvent;
use Gears\Event\Time\FixedTimeProvider;

/**
 * Abstract event stub class.
 */
class AbstractEventStub extends AbstractEvent
{
    /**
     * @var string
     */
    private $parameter;

    /**
     * Instantiate event.
     *
     * @param mixed[] $payload
     *
     * @return self
     */
    public static function instance(array $payload): self
    {
        return static::occurred(
            $payload,
            new FixedTimeProvider(\DateTimeImmutable::createFromFormat(\DateTime::ATOM, '2020-01-01T00:00:00Z'))
        );
    }

    /**
     * @return string|null
     */
    public function getParameter(): ?string
    {
        return $this->parameter !== null ? \strtolower($this->parameter) : null;
    }
}
