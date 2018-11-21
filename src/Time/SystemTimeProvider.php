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

namespace Gears\Event\Time;

/**
 * General system time provider.
 */
final class SystemTimeProvider implements TimeProvider
{
    /**
     * @var \DateTimeZone
     */
    private $timeZone;

    /**
     * SystemTimeProvider constructor.
     *
     * @param \DateTimeZone|null $timeZone
     */
    public function __construct(?\DateTimeZone $timeZone = null)
    {
        $this->timeZone = $timeZone ?? new \DateTimeZone('UTC');
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentTime(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now', $this->timeZone);
    }
}
